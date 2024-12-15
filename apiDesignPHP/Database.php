<?php

class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $dbname = "impactLabTest";
    private $conn;

    // Constructor to initialize the database connection
    public function __construct()
    {
        try {
            $this->conn = new mysqli($this->host, $this->username, $this->password, $this->dbname);
            if ($this->conn->connect_error) {
                throw new Exception("Connection failed: " . $this->conn->connect_error);
            }
        } catch (Exception $e) {
            die("Error: " . $e->getMessage());
        }
    }
        // Function to run SELECT queries
        public function select($query, $params = [])
        {
            try {
                $stmt = $this->conn->prepare($query);
                if ($params) {
                    $this->bindParams($stmt, $params);
                }
    
                $stmt->execute();
                $result = $stmt->get_result();
                $data = $result->fetch_assoc();
    
                $stmt->close();
    
                return $data;
            } catch (Exception $e) {
                throw new Exception("Error in SELECT query: " . $e->getMessage());
            }
        }
    

    // Function to execute INSERT/UPDATE/DELETE queries
    public function execute($query, $params = [])
    {
        try {
            $stmt = $this->conn->prepare($query);
            if (!$stmt) {
                throw new Exception("Failed to prepare statement: " . $this->conn->error);
            }

            // Bind parameters if provided
            if ($params) {
                $this->bindParams($stmt, $params);
            }

            // Execute the query
            if (!$stmt->execute()) {
                throw new Exception("Execution failed: " . $stmt->error);
            }

            $stmt->close();

            return true; // Indicate success
        } catch (Exception $e) {
            throw new Exception("Error in execute(): " . $e->getMessage());
        }
    }

    // Function to retrieve the last inserted ID
    public function getLastInsertId()
    {
        return $this->conn->insert_id;
    }

    // Function to bind parameters to the prepared statement
    private function bindParams($stmt, $params)
    {
        $types = '';
        $values = [];

        foreach ($params as $param) {
            $types .= $this->getType($param);
            $values[] = $param;
        }

        $stmt->bind_param($types, ...$values);
    }

    // Function to determine the type of each parameter for binding
    private function getType($param)
    {
        if (is_int($param)) {
            return 'i'; // Integer
        } elseif (is_double($param)) {
            return 'd'; // Double
        } elseif (is_string($param)) {
            return 's'; // String
        } else {
            return 'b'; // Blob
        }
    }

    // Close the database connection
    public function close()
    {
        $this->conn->close();
    }
}
?>
