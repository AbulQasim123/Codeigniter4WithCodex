# CodeIgniter 4 Commerce App

A CodeIgniter 4 e-commerce starter application with:
- public store front
- customer registration/login/profile
- shopping cart, checkout, order tracking
- admin dashboard for products, categories, orders, users, and logs
- REST API v1 for products, cart, auth, checkout, and orders

## Requirements

- PHP 8.2 or newer
- MySQL / MariaDB (or another database supported by CodeIgniter 4)
- Composer
- Web server pointing to `public/` or use the built-in PHP server

## Installation

1. Clone the repository:

```bash
git clone https://your-repository-url.git Codeigniter4WithCodex
cd Codeigniter4WithCodex
```

2. Install dependencies:

```bash
composer install
```

3. Copy the environment file and configure your database:

```bash
copy env .env
```

4. Open `.env` and update the database settings:

```text
database.default.hostname = localhost
database.default.database = your_database_name
database.default.username = your_db_user
database.default.password = your_db_password
database.default.DBDriver = MySQLi
database.default.port = 3306
```

5. Update the base URL if needed in `app/Config/App.php` or `.env`:

```php
public string $baseURL = 'http://localhost:8080/';
```

> If you use `.env`, you can also set `app.baseURL = 'http://localhost:8080/'` there.

6. Run database migrations:

```bash
php spark migrate
```

7. Seed catalog data:

```bash
php spark db:seed CatalogSeeder
```

8. Start the development server:

```bash
php spark serve --host 0.0.0.0 --port 8080
```

Then open `http://localhost:8080/` in your browser.

## Public Store Front

The public store front is available at the application root.

### Public routes

- `GET /` — Store home with product listing and categories
- `GET /cart` — View cart contents
- `POST /cart/add/{product_id}` — Add product to cart
- `POST /cart/update/{item_id}` — Update cart item quantity
- `GET /checkout` — Checkout page
- `POST /checkout` — Place an order
- `GET /order/{order_number}` — View order confirmation

### Customer authentication

- `GET /login` — Login page
- `POST /login` — Authenticate customer
- `GET /register` — Customer registration page
- `POST /register` — Create customer account
- `POST /logout` — Log out customer

### Account management

- `GET /profile` — View customer profile
- `POST /profile` — Update profile
- `POST /profile/password` — Change password

## Admin Website

The admin area is protected by the `admin` filter.

### Admin setup

1. After the database is ready, open the admin setup page once:

```text
GET /admin/register
```

2. Create an admin account.
3. Sign in at `GET /login` using the admin credentials.

### Admin routes

- `GET /admin` — Admin dashboard
- `GET /admin/products` — Manage products
- `POST /admin/products` — Create or update products
- `DELETE /admin/products/{id}` — Delete a product
- `GET /admin/categories` — Manage categories
- `POST /admin/categories` — Create or update a category
- `DELETE /admin/categories/{id}` — Delete a category
- `GET /admin/orders` — View orders
- `POST /admin/orders/{id}` — Update order status
- `GET /admin/users` — View customer accounts
- `POST /admin/users/{id}/block` — Block/unblock customer account
- `GET /admin/logs` — Activity log view
- `POST /admin/logout` — Sign out admin

## REST API v1

The API base path is `/api/v1`.

### Endpoints

- `GET /api/v1/products`
  - Browse active products
- `POST /api/v1/auth/register`
  - Register a customer
- `POST /api/v1/auth/login`
  - Login and receive an API token
- `GET /api/v1/cart`
  - Read current cart state
- `POST /api/v1/cart/items`
  - Add product to cart
- `PUT /api/v1/cart/items/{item_id}`
  - Update cart item quantity
- `POST /api/v1/checkout`
  - Place an order using authenticated user session
- `GET /api/v1/orders`
  - List orders for authenticated user

### Authentication

The API uses bearer tokens for user authentication.

Example login request:

```bash
curl -X POST http://localhost:8080/api/v1/auth/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password123"}'
```

Example authorized request:

```bash
curl http://localhost:8080/api/v1/orders \
  -H "Authorization: Bearer YOUR_API_TOKEN"
```

### Cart session header

The API also accepts an `X-Cart-Key` header to associate cart data across requests.

## Database

This project uses CodeIgniter migrations and seeders located in `app/Database`.

### Key tables

- `users` — Customers and admin users
- `categories` — Product categories
- `products` — Store products
- `carts` — Shopping carts
- `cart_items` — Items inside each cart
- `orders` — Order records
- `order_items` — Items saved for each order
- `api_tokens` — API user tokens
- `activity_logs` — Admin and customer activity logging

### Seed data

`app/Database/Seeds/CatalogSeeder.php` populates:
- default categories
- sample products

## Configuration

### Database config

The default database settings are defined in `app/Config/Database.php`.

Use `.env` to override the default DB settings without editing source files.

### Base URL

Set `app.baseURL` in `app/Config/App.php` or `app.baseURL` in `.env` when the app runs on a custom domain or port.

## Running tests

Run unit tests with:

```bash
composer test
```

## Notes

- The project is built on CodeIgniter 4 framework `codeigniter4/framework`.
- The webroot is `public/`.
- If you use a production web server, point the document root to `public/`.
- Do not expose `app/Config/Database.php` or `.env` publicly.
