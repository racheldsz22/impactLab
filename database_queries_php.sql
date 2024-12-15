/*to get all users*/
SELECT name, email 
FROM users

/*to get all active users*/
SELECT name, email 
FROM users 
WHERE deleted_at IS NULL;

/*to get avg age of all users*/
SELECT AVG(age) AS average_age
FROM users;

/*top five products with the highest sales */
-- Top 5 products by quantity sold
SELECT product_id, SUM(quantity) AS total_quantity
FROM sales
GROUP BY product_id
ORDER BY total_quantity DESC
LIMIT 5;

-- Top 5 products by sales amount
SELECT product_id, SUM(sales_amount) AS total_sales
FROM sales
GROUP BY product_id
ORDER BY total_sales DESC
LIMIT 5;