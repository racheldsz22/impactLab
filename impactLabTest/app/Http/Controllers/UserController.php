<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\QueryException;

class UserController extends Controller
{
    public function removeUser($id)
    {
        try {



            // Validate and sanitize user_id
            $validatedId = (int) $id;  // Casting to integer to sanitize input

            // Find the user by ID
            $user = User::find($validatedId);



            // Check if the user exists
            if (!$user || $user->deleted_at !== null) {
                return response()->json(['message' => 'User not found or User is Inactive', 'status' => false, 'data' => []], 404); // 404 Not Found
            }


            // Check if the user has a 'customer' role and delete the customer profile if exists
            if ($user->role === 'customer' && $user->customer) {
                $user->customer()->delete(); // Delete the customer profile first
            }

            // Perform the soft delete on the user
            $user->delete();

            // Return a successful response
            return response()->json(['message' => 'User removed successfully', 'status' => true, 'data' => []]);
        } catch (QueryException $qe) {
            // Log database query exception
            Log::error('Query Exception during soft delete: ' . $qe->getMessage());

            return response()->json(['message' => 'A database error occurred while performing the soft delete.', 'status' => false, 'data' => []], 500); // 500 Internal Server Error
        } catch (\Exception $e) {
            // Log unexpected exceptions
            Log::error('Unexpected Exception during soft delete: ' . $e->getMessage());

            return response()->json(['message' => 'An unexpected error occurred while processing the soft delete request.', 'status' => false, 'data' => []], 500); // 500 Internal Server Error
        }
    }
}
