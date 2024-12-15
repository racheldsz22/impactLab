<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class OrderController extends Controller
{
    public function placeOrder(Request $request)
    {
        try {
            $params = $request->all();

            // Validation for Input request
            $rules = [
                'user_id' => 'required|exists:users,id',
                'products' => 'required|array',
                'products.*.product_id' => 'required|exists:products,id',
                'products.*.quantity' => 'required|integer|min:1',
            ];

            // Custom validation messages
            $messages = [
                'user_id.exists' => 'User ID does not exist',
                'products.*.product_id.exists' => 'Product ID does not exist',
                'products.*.quantity.min' => 'The quantity for each item must be at least 1',
            ];

            $validator = Validator::make($params, $rules, $messages);

            // Return validation errors
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'status' => false,
                    'data' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();


            $user = User::find($validated['user_id']);
            // Check if the user exists and is active (not soft-deleted)
            if (!$user || $user->deleted_at !== null) {
                return response()->json([
                    'message' => 'User is inactive or does not exist.',
                    'status' => false,
                    'data' => []
                ], 403);
            }

            // Ensure the user has the 'customer' role
            if ($user->role !== 'customer') {
                return response()->json([
                    'message' => 'Only customers can place an order.',
                    'status' => false,
                    'data' => []
                ], 403);
            }

            // Begin transaction
            DB::beginTransaction();

            // Create the order
            $order = Order::create([
                'user_id' => $validated['user_id'],
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $totalPrice = 0;
            $productsQuantity = [];

            // Calculate the total price and prepare product quantities
            foreach ($validated['products'] as $productData) {
                $product = Product::find($productData['product_id']);

                if (!$product) {
                    return response()->json([
                        'message' => 'Product not found.',
                        'status' => false,
                        'data' => []
                    ], 404);
                }

                if ($product->quantity < $productData['quantity']) {
                    return response()->json([
                        'message' => 'Not enough stock for product: ' . $product->name,
                        'status' => false,
                        'data' => []
                    ], 400);
                }

                $productsQuantity[$product->id] = $productData['quantity'];
            }

            // Create order items and update stock
            foreach ($productsQuantity as $productId => $quantity) {
                $product = Product::find($productId);

                // Reduce product stock
                $product->quantity -= $quantity;
                $product->save();

                // Add order item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]);

                // Update total price
                $totalPrice += $product->price * $quantity;
            }

            // Update total price in the order
            $order->total_price = $totalPrice;
            $order->save();

            // Commit transaction
            DB::commit();

           
            $order->load('orderItems');

            // Prepare response data
            $responseData = [
                [
                    'Customer Name' => $order->user->name,
                    'status' => $order->status,
                    'total_price' => number_format($order->total_price, 2),
                    'order_items' => $order->orderItems->map(function ($item) {
                        $product = $item->product; // Fetch product details for each order item
                        return [
                            'product_name' => $product->name,
                            'quantity' => $item->quantity,
                            'price' => number_format($item->price, 2),
                        ];
                    }),
                ]
            ];

            return response()->json([
                'message' => 'Order placed successfully',
                'status' => true,
                'data' => $responseData,
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack(); // Rollback transaction on error
            return response()->json([
                'message' => 'Failed to place order: ' . $e->getMessage(),
                'status' => false,
                'data' => []
            ], 500);
        }
    }
}
