<?php

// Include necessary classes
include('Database.php');
include('User.php');

// Set the content type to JSON
header('Content-Type: application/json');

// Check if the correct HTTP method is used (GET)
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'message' => 'Invalid request method. Only GET method is allowed.',
        'status' => false,
        'data' => []
    ]);
    exit(); // Terminate the script to prevent further processing
}

// Get the user_id from the URL parameters (e.g., /api/users/1)
if (!isset($_GET['user_id']) || empty($_GET['user_id'])) {
    echo json_encode([
        'message' => 'User ID is required',
        'status' => false,
        'data' => []
    ]);
    exit();
}

// Validate user_id is a valid integer
$user_id = (int) $_GET['user_id'];

if ($user_id <= 0) {
    echo json_encode([
        'message' => 'Invalid user ID',
        'status' => false,
        'data' => []
    ]);
    exit();
}

// Initialize User object
$user = new User();

// Fetch the user profile by user_id
try {
    $userProfile = $user->getUserProfile($user_id);

    // Check if the user profile was found
    if (!$userProfile) {
        echo json_encode([
            'message' => 'User not found',
            'status' => false,
            'data' => []
        ]);
    } else {
        echo json_encode([
            'message' => 'User profile fetched successfully',
            'status' => true,
            'data' => [$userProfile]
        ]);
    }

} catch (Exception $e) {
    // Log the error for debugging (you could log it to a file or error monitoring tool)
    error_log($e->getMessage());

    // Return a response with the error message
    echo json_encode([
        'message' => 'An error occurred while fetching the user profile',
        'status' => false,
        'data' => []
    ]);
}
?>
