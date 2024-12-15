<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Database\QueryException;
use Validator;


class ProductController extends Controller
{
    public function getAllProducts(Request $request)
    {

        try {
            $params = $request->all();

            // Validation for Input request
            $rules = [
                'per_page' => 'nullable|integer|min:1|max:100',
                'page' => 'nullable|integer|min:1',
            ];

            $validator = Validator::make($params, $rules);
            if ($validator->fails()) {
                return response()->json([
                    'message' => 'Validation failed.',
                    'status' => false,
                    'data' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();



            $perPage = (int) ($validated['per_page'] ?? 10);
            $page = (int) ($validated['page'] ?? 1);

            //fetches data from db 
            $products = Product::select('name', 'description', 'price', 'quantity', 'image_url')->paginate($perPage, ['*'], 'page', $page);
            if ($products->isEmpty()) {

                return response()->json(['message' => 'No records found', 'status' => true, 'data' => []]);
            } else {

                return response()->json([
                    'message' => 'Success',
                    'status' => true,
                    'data' => $products->items(), // Current page data
                    'pagination' => [
                        'total' => $products->total(),
                        'per_page' => $products->perPage(),
                        'current_page' => $products->currentPage(),
                        'last_page' => $products->lastPage(),
                        'from' => $products->firstItem(),
                        'to' => $products->lastItem(),
                    ]
                ], 200);
            }
        } catch (QueryException $qe) {
            // Log for database query exception
            Log::error('Query Exception: ' . $qe->getMessage());

            return response()->json(['message' => 'A database error occurred.', 'status' => false, 'data' => []]);
        } catch (\Exception $e) {
            Log::error('Unexpected Exception: ' . $e->getMessage());

            return response()->json(['message' => 'An error occurred while processing the request.', 'status' => false, "data" => []]);
        }
    }
}
