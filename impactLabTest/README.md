
# ImpactLabTest (Laravel Project)

**ImpactLabTest** is a Laravel-based project demonstrating API development, database management, and e-commerce functionality. The project implements RESTful APIs for user management, order placement, and product management.

---

## Features

- Remove User ( Soft Delete)
- Product management with RESTful endpoints
- Order placement with multiple products
- Pagination for large datasets
- Error handling and validation
- Database Migrations and Database Seeder

---

## Setup Instructions

1. Create a laravel project
    - composer create-project --prefer-dist laravel/laravel impactLabTest "11.*"
2. Copy .env.example to .env
    - cp .env.example .env
3. Generate the application key:
    - php artisan key:generate
4. Make database Migrations: 
    - php artisan make:migration create_products_table
    - php artisan make:migration create_customers_table
    - php artisan make:migration create_orders_table
    - php artisan make:migration create_order_items_table
    - php artisan make:migration create_reviews_table
    - php artisan make:migration create_posts_table
    - php artisan make:migration modify_users_table --table=users
    - php artisan make:migration add_quantity_to_products_table -- table=products
5. Run migrations to set up the database:
    - php artisan migrate
6. Create Models for the above tables
    - php artisan make:model Customer
    - php artisan make:model Product
    - php artisan make:model Order
    - php artisan make:model OrderItem
7. Create factory for the above Models to generate sample data
    - php artisan make:factory CustomerFactory --model=Customer
        class CustomerFactory extends Factory
            {
    
                public function definition(): array
                {
                    return [
                        'user_id' => User::factory(),
                        'phone' => $this->faker->phoneNumber,
                        'shipping_address' => $this->faker->address,
                        'billing_address' => $this->faker->address,
                    ];
                }
            }
    - php artisan make:factory ProductFactory --model=Product
        class ProductFactory extends Factory
            {
                
                public function definition(): array
                {
                    return [
                        'name' => $this->faker->word, // Generate a random product name
                        'description' => $this->faker->sentence(10), // Short description
                        'price' => $this->faker->randomFloat(2, 1, 500), // Random price between 1 and 500
                        'quantity' => $this->faker->numberBetween(1, 500), // Random stock quantity
                        'image_url' => $this->faker->imageUrl(640, 480, 'products'), // Random product image URL
                    ];
                }
            }
8. Create seeder for the above factory
    - php artisan make:seeder CustomerSeeder
        class CustomerSeeder extends Seeder
        {
            public function run(): void
            {
                
                Customer::factory()->count(50)->create();
            }
        }
    - php artisan make:seeder ProductSeeder
        class ProductsTableSeeder extends Seeder
        {
        
            public function run(): void
            {
                
                Product::factory()->count(50)->create(); 
            
            }
        }
9. Seed the database:
    - php artisan db:seed
10. Create Controllers
    - php artisan make:controller ProductController 
    - php artisan make:controller UserController 
    - php artisan make:controller OrderController 
    - Define the logic in Controller for the respective function
11. Since we are building API's we will have to define the routes in routes/api.php. But laravel 11 doesn't have this by default, we will have to install it
    - php artisan install:api
    Once we install this we will find api.php in routes folder. We have to define our routes in this folder
    - Route::post('/products', [ProductController::class, 'getAllProducts']);
    - Route::delete('/users/{id}', [UserController::class, 'removeUser']);
    - Route::post('/orders', [OrderController::class, 'placeOrder']);
12. Run the Laravel server:
    - php artisan serve
        The application will be available at http://127.0.0.1:8000/.


## API Endpoints

### **1.1 Product  API**

- **POST** `api/products` –  retrieves all products
- **url** - http://127.0.0.1:8000/api/products
- **request**
   {
    "per_page":20,
    "page":1
}
- **response**
  {
    "message": "Success",
    "status": true,
    "data": [
        {
            "name": "Soundcore Sleep A20 ",
            "description": "Soundcore Sleep A20 by Anker Sleep Earbuds, Noise Blocking Sleep Headphones, Small Design for Side Sleepers, 80H Playtime, Stream Content via Bluetooth 5.3, Sleep Monitor, Personal Alarm",
            "price": "250.80",
            "quantity": 2,
            "image_url": "https://m.media-amazon.com/images/I/61lV3lqGSBL._AC_SL1500_.jpg"
        },
        {
            "name": "adipisci",
            "description": "Ratione et libero illum ullam unde consequatur saepe quibusdam ea praesentium non veritatis esse voluptatem.",
            "price": "267.08",
            "quantity": 349,
            "image_url": "https://via.placeholder.com/640x480.png/001100?text=products+dolore"
        },
       
       
    ],
    "pagination": {
        "total": 2,
        "per_page": 20,
        "current_page": 1,
        "last_page": 1,
        "from": 1,
        "to": 2
    }
}
**validations**
- Validation for Input request
    # per_page
    - It can be null
    - It must be an integer
    - Minimum value 1 
    - Maximum value 100
    # page
    - It can be null
    - It must be an integer
    - Minimum value 1 

Note : Pagination is set for this API thinking about the future if there are millions of records in the table then to load all the records will hamper the performance of the webiste and since we may want to send per_page value and page value the api is in POST method. The default value of per_page is 10 and page is 1


### **1.2 Order Placement API**

- **POST** `api/orders` –   lets a user place an order containing mul ple products
- **url** - http://127.0.0.1:8000/api/orders
- **request**
   {
    "user_id": 1,
    "products": [
        {
            "product_id": 7,
            "quantity": 2
        },
        {
            "product_id": 6,
            "quantity": 2
        }
    ]
}
- **response**
 {
    "message": "Order placed successfully",
    "status": true,
    "data": [
        {
            "Customer Name": "Winifred Huels II",
            "status": "pending",
            "total_price": "1,141.56",
            "order_items": [
                {
                    "product_name": "autem",
                    "quantity": 2,
                    "price": "249.68"
                },
                {
                    "product_name": "itaque",
                    "quantity": 2,
                    "price": "321.10"
                }
            ]
        }
    ]
}
**validations**
- Validation for Input request
    # user_id
    - It  is required
    - It must exists in the user table
    # products
    - Product array is required
    - Each product id is required for each object in the product array
    - Each product id must exits in the product table
    - Each quantity is required for each object in the product array
    - Each quantity must be an integer
    - The quantity for each item must be at least 1
- Check if the user exists and is active (not soft-deleted)
- Check if user is a customer (Only customers can place an order)
- Product is found or not
- Check quantity of stock available


### **1.3 User  API**

- **DELETE** `api/users/{id}` –   removing a user entry from the "users" table 
- **url** - http://127.0.0.1:8000/api/users/6
- **response**
  {
    "message": "User removed successfully",
    "status": true,
    "data": []
}

**validations**
- Sanitize user_id
- Check if the user exists

Note:
It is recommended to implement soft deletes on the users table. This approach allows us to recover deleted data in the future if needed. Additionally, if a user is accidentally deleted, we can easily roll back the action. In contrast, hard deletes remove the data permanently and cannot be rolled back since they are direct DML commands.

Future Scope:
Once we integrate authentication, we can restrict the ability to delete users to admins only. Moreover, if there are multiple admins, we can store the id of the admin who performed the deletion in the deleted_by column in the users table.
