<?php

// Include necessary classes
include('Database.php');
include('Post.php');

// Set the content type to JSON
header('Content-Type: application/json');

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method. Only POST method is allowed.',
        'data' => []
    ]);
    exit();
}

// Get the raw POST body and decode the JSON
$requestBody = file_get_contents('php://input');
$data = json_decode($requestBody, true);

// Check if JSON decoding failed
if (json_last_error() !== JSON_ERROR_NONE) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid JSON format.',
        'data' => []
    ]);
    exit();
}

// Validate that 'title' and 'content' are provided
if (!isset($data['title']) || empty(trim($data['title']))) {
    echo json_encode([
        'status' => 'error',
        'message' => 'The title is required and cannot be empty.',
        'data' => []
    ]);
    exit();
}

if (!isset($data['content']) || empty(trim($data['content']))) {
    echo json_encode([
        'status' => 'error',
        'message' => 'The content is required and cannot be empty.',
        'data' => []
    ]);
    exit();
}

// Validate the length of 'title'
$title = trim($data['title']);
if (strlen($title) > 255) {
    echo json_encode([
        'status' => 'error',
        'message' => 'The title must not exceed 255 characters.',
        'data' => []
    ]);
    exit();
}

// Validate the length of 'content'
$content = trim($data['content']);
if (strlen($content) < 10) {
    echo json_encode([
        'status' => 'error',
        'message' => 'The content must be at least 10 characters long.',
        'data' => []
    ]);
    exit();
}

// Initialize the Post object
$post = new Post();

// Check if the title is unique
if (!$post->isTitleUnique($title)) {
    echo json_encode([
        'status' => 'error',
        'message' => 'The title must be unique. A post with this title already exists.',
        'data' => []
    ]);
    exit();
}

try {
    // Create the post and get the ID of the newly created post
    $postId = $post->createPost($title, $content);

    // Return a success response with the post ID
    echo json_encode([
        'status' => 'success',
        'message' => 'Post created successfully',
        'data' => [
            ['postId' => $postId]
        ]
    ]);
} catch (Exception $e) {
    // Log the error for debugging (optional)
    error_log($e->getMessage());

    // Return an error response
    echo json_encode([
        'status' => 'error',
        'message' => 'An error occurred while creating the post.',
        'data' => []
    ]);
}
?>
