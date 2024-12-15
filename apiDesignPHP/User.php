<?php

class User
{
    private $db;

    // Constructor to initialize the Database object
    public function __construct()
    {
        $this->db = new Database();
    }

    // Get a user's profile by user_id
    public function getUserProfile($user_id)
    {
        try {
            // SQL query to fetch user details by user_id
            $query = "SELECT id, name, email, bio, url, created_at FROM users WHERE id = ? AND deleted_at IS NULL";
            $params = [$user_id]; // Bind the user_id parameter

            return $this->db->select($query, $params);
        } catch (Exception $e) {
            throw new Exception("Failed to fetch user profile: " . $e->getMessage());
        }
    }
}
?>
