# ImpactLab

This repository contains multiple projects and challenges designed to demonstrate problem-solving, database management, API development, and Laravel framework capabilities. Each folder serves a specific purpose and addresses unique challenges.

---

## Directory Structure

- **[`apiDesignPHP`](#apiDesignPHP)**: Focuses on designing and implementing RESTful APIs in PHP.
- **[`impactLabTest`](#impactLabTest)**: A Laravel-based project showcasing API development, database schema design, and e-commerce-related functionalities.
- **[`programming_challenge_php`](#programming_challenge_php)**: Solves various programming challenges using PHP.
- **[`database_queries_php`](#database_queries_php)**: Implements SQL queries for different database scenarios.

---

## apiDesignPHP

This folder contains RESTful API design and implementation tasks using core PHP.

### Key Features:
- RESTful API architecture.
- Endpoint implementation for handling user and product data.
- Validation and error handling for API requests.
- Database connection and parameterized queries** using the `Database.php` class

Refer to the folder for detailed implementation and examples. [apiDesignPHP](apiDesignPHP/README.md)

---

## impactLabTest

This is a Laravel-based project demonstrating:
- **User and product management APIs**.
- **Order placement functionality** for an e-commerce system.
- **Database schema design** using Laravel migrations.

### Setup Instructions:
1. Navigate to the `impactLabTest` folder.
2. Follow the setup guide in the [impactLabTest README](impactLabTest/README.md).

---

## programmingChallengePHP

This folder contains solutions to various algorithmic challenges, such as:
- Finding the second-highest number in an array.
- Checking if a string is a palindrome.
- Summing even numbers in an array.

### Example Challenges:
1. **Palindrome Checker**:
   - Input: `"A man a plan a canal Panama"`
   - Output: `True`

2. **Sum of Even Numbers**:
   - Input: `[1, 2, 3, 4]`
   - Output: `6`

Check individual files for implementation details. [programmingChallengePHP](programmingChallengePHP/README.md)

---

## database_queries_php

This folder includes SQL queries for tasks such as:
- Retrieving user details.
- Calculating averages.
- Fetching top-selling products.

### Example Queries:
1. **Get All Users**:
    ```sql
    SELECT name, email FROM users;
2. **Average Age of Users**:
    ```sql
    SELECT AVG(age) AS average_age FROM users;
3. **Top 5 Products by Sales**:
   ```sql
    SELECT product_id, SUM(quantity) AS total_sales
    FROM sales
    GROUP BY product_id
    ORDER BY total_sales DESC
    LIMIT 5;

    Refer to the file for detailed SQL implementations.