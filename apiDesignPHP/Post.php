<?php

class Post
{
    private $db;

    // Constructor to initialize the Database object
    public function __construct()
    {
        $this->db = new Database();
    }

    // Check if a post title already exists
    public function isTitleUnique($title)
    {
        try {
            $query = "SELECT COUNT(*) as count FROM posts WHERE title = ?";
            $params = [$title];

            $result = $this->db->select($query, $params);

            return $result['count'] == 0; // Returns true if title is unique
        } catch (Exception $e) {
            throw new Exception("Error checking title uniqueness: " . $e->getMessage());
        }
    }

    // Add a new post
    public function createPost($title, $content)
    {
        try {
            $query = "INSERT INTO posts (title, content) VALUES (?, ?)";
            $params = [$title, $content];

            $this->db->execute($query, $params);

            return $this->db->getLastInsertId();
        } catch (Exception $e) {
            throw new Exception("Failed to create post: " . $e->getMessage());
        }
    }
}
