# apiDesignPHP

This directory contains tasks focused on designing and implementing RESTful APIs using core PHP. The goal of this section is to demonstrate the ability to create clean, maintainable, and efficient API endpoints with proper validation and error handling.

---

## Features

- RESTful API Design
- Handling various HTTP methods (GET, POST)
- Validation and error handling
- Database connection and parameterized queries** using the `Database.php` class

---

## Files and Endpoints

### **1.1 User  API**

- **GET** `/api/users/{user_id}` –  retrieves user profile details using a unique ID
- **url** - http://localhost/impactLab/apiDesignPHP/get_user_profile.php?user_id=1
- **response**
    {
    "message": "User profile fetched successfully",
    "status": true,
    "data": [
        {
            "id": 1,
            "name": "Winifred Huels II",
            "email": "mertz.irwin@example.com",
            "bio": "Harum earum eum voluptatem ut nobis.",
            "url": "http://sporer.com/",
            "created_at": "2024-12-15 03:51:15"
        }
    ]
}
**validations**
- Check if the correct HTTP method is used (GET)
- Check if user_id is passed in the URL parameters
- Validate user_id is a valid integer
- Check if the user profile was found 

### **1.2 POST API**

- **POST** `/api/posts` – allow users to add a new post by providing a title and body content.
- **url** - http://localhost/impactLab/apiDesignPHP/create_post.php
- **request** 
    { 
  "title": "Creating a Post", 
  "content": "New post body text" 
    }
- **response** 
    {
    "status": "success",
    "message": "Post created successfully",
    "data": [
        {
            "postId": 1
        }
    ]
    }

**validations**
- Check if the correct HTTP method is used (GET)
- Check JSON format
- Validate that 'title' and 'content' are provided
- Validate the length of 'title' ( must not exceed 255 characters).
- Validate the length of 'content' (must be at least 10 characters long)
- Check if the title is unique

## Database Connection: `Database.php`

The **`Database.php`** file is used for connecting to a MySQL database and running parameterized queries. This ensures that your SQL queries are secure and protected against SQL injection attacks. The class supports the following functionalities:

### **1.1 Connecting to the Database**
The `Database.php` file initializes a connection to the MySQL database using **MySQLi**. The connection parameters such as host, username, password, and database name are configured in the class. If the connection fails, an exception is thrown.


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
}

### 1.2 Running Parameterized Queries
The Database.php file provides two primary functions for interacting with the database:

select() for SELECT queries, which fetch data.
execute() for INSERT, UPDATE, and DELETE queries.
Both methods support parameterized queries to ensure data security.

select() Method (for SELECT Queries)
The select() method is used for SELECT queries. It prepares and executes the query, binding any parameters passed. It returns the result of the query.

execute() Method (for INSERT, UPDATE, DELETE Queries)
The execute() method is used for running INSERT, UPDATE, and DELETE queries. It prepares the query, binds parameters, and executes the query.

###  1.3 Binding Parameters
The bindParams() method binds the parameters to the prepared statement. This ensures that the data is correctly escaped and reduces the risk of SQL injection.

### getType() Method
The getType() method determines the correct type for each parameter (integer, double, string, or blob) and returns the appropriate type code (i, d, s, b).
---

## Setup Instructions

1. Clone the repository and navigate to the `apiDesignPHP` folder.
2. Ensure that your PHP environment is correctly set up.
3. You can use a local server (e.g., XAMPP, LAMP) to run the project or use the PHP built-in server:
   ```bash
   php -S localhost:8000
