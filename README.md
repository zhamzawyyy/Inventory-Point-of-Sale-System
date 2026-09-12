# 🛒 Inventory & Point-of-Sale System

A web-based **Inventory and Point-of-Sale (POS) System** designed for small shops to manage products, process sales, track inventory, and maintain transaction history.

The system provides a simple POS interface where users can browse products, search or scan barcodes, add items to a cart, complete purchases, and automatically update stock levels.

---

## ✨ Features

### 🔐 Authentication

* Session-based login system
* Protected application pages
* Admin account setup
* Secure password hashing using PHP's `password_hash()`

### 🛍️ Point of Sale

* Browse available products
* Search products by name
* Barcode lookup
* Add products to cart
* Increase/decrease product quantities
* Remove products from cart
* Automatic subtotal and total calculation
* Checkout and invoice generation
* Automatic stock reduction after a successful sale

### 📦 Inventory Management

* View all products
* Add new products
* Edit existing products
* Delete products
* Product categories
* Barcode management
* Price management
* Stock quantity tracking
* Low-stock warnings when stock is **5 or less**

### 📊 Sales & History

* View completed transactions
* View individual invoice details
* Store sale date and total
* Store individual products included in each sale
* Automatically preserve historical sale information

### 🛡️ Data Protection

* Prevents stock from becoming negative
* Uses database transactions during checkout
* Prevents deletion of products that are referenced by previous invoices
* Uses foreign-key relationships between sales and sale items

---

## 🛠️ Technologies

| Technology     | Purpose                                              |
| -------------- | ---------------------------------------------------- |
| **HTML5**      | Application structure                                |
| **CSS3**       | Responsive UI and layouts                            |
| **JavaScript** | Cart logic, search, filtering, and API communication |
| **PHP**        | Backend logic and authentication                     |
| **MySQL**      | Database and data persistence                        |
| **PDO**        | Database connection and queries                      |
| **XAMPP**      | Local development environment                        |

The project uses **vanilla HTML, CSS, JavaScript, PHP, and MySQL** without Bootstrap, Tailwind, or other frontend frameworks.

---

## 📂 Project Structure

```text
inventory-pos/
│
├── index.php
├── login.php
├── logout.php
├── setup.php
├── history.php
├── sale_details.php
├── database.sql
│
├── admin/
│   ├── products.php
│   ├── add_product.php
│   ├── edit_product.php
│   └── delete_product.php
│
├── api/
│   ├── get_products.php
│   ├── checkout.php
│   └── get_sale_details.php
│
├── config/
│   ├── db.php
│   └── auth.php
│
└── assets/
    ├── css/
    │   └── style.css
    │
    └── js/
        └── app.js
```

---

## ⚙️ Installation

### 1. Install XAMPP

Install [XAMPP](https://www.apachefriends.org/) with:

* Apache
* MySQL
* phpMyAdmin

### 2. Clone or copy the project

Place the project inside the XAMPP `htdocs` directory:

```text
C:\xampp\htdocs\inventory-pos
```

### 3. Start XAMPP

Open the XAMPP Control Panel and start:

```text
Apache
MySQL
```

### 4. Create the database

Open phpMyAdmin:

```text
http://localhost/phpmyadmin
```

Import:

```text
database.sql
```

The SQL file creates the:

```text
inventory_pos
```

database and the required tables.

### 5. Configure the database

Open:

```text
config/db.php
```

The default XAMPP configuration uses:

```php
$user = 'root';
$pass = '';
```

If your MySQL installation uses a password, update the configuration accordingly.

### 6. Run the setup

Open:

```text
http://localhost/inventory-pos/setup.php
```

The setup script creates the administrator account.

### 7. Launch the application

Open:

```text
http://localhost/inventory-pos/
```

You will be redirected to the login page if authentication is required.

---

## 🔑 Default Login

After running the setup script:

```text
Username: admin
Password: admin123
```

> For a real deployment, change the default credentials and remove or protect the setup script.

---

## 🗄️ Database Design

The system uses four main tables:

### `users`

Stores application users and authentication information.

```text
id
username
password
created_at
```

### `products`

Stores inventory information.

```text
id
name
category
barcode
price
stock
created_at
```

### `sales`

Stores completed sales/invoices.

```text
id
total
sale_date
```

### `sale_items`

Stores the individual products included in each sale.

```text
id
sale_id
product_id
product_name
quantity
price
subtotal
```

The database uses foreign keys to connect sales with their corresponding sale items.

---

## 🔄 Sales Workflow

The checkout process follows this general workflow:

```text
Select Product
      ↓
Add to Cart
      ↓
Adjust Quantity
      ↓
Calculate Total
      ↓
Checkout
      ↓
Create Sale
      ↓
Create Sale Items
      ↓
Reduce Inventory
      ↓
Generate Invoice
```

The checkout operation uses a database transaction so that the sale, sale items, and stock updates are handled together.

If an operation fails, the transaction can be rolled back instead of leaving partially completed data.

---

## 📱 Responsive Design

The interface is designed to work across:

* 💻 Desktop
* 📱 Mobile
* 📲 Tablet

CSS Grid, Flexbox, and media queries are used to adapt the layout to different screen sizes.

---

## 📄 Main Pages

| Page                       | Purpose                     |
| -------------------------- | --------------------------- |
| `login.php`                | User login                  |
| `setup.php`                | Initial administrator setup |
| `index.php`                | Main POS interface          |
| `admin/products.php`       | Inventory management        |
| `admin/add_product.php`    | Add product                 |
| `admin/edit_product.php`   | Edit product                |
| `admin/delete_product.php` | Delete product              |
| `history.php`              | Sales history               |
| `sale_details.php`         | Individual invoice          |
| `logout.php`               | Logout                      |

---

## 🔌 API Endpoints

The frontend communicates with PHP endpoints using JavaScript `fetch()` requests.

### Get Products

```text
api/get_products.php
```

Returns available products as JSON.

### Checkout

```text
api/checkout.php
```

Processes the current cart and creates the sale.

### Sale Details

```text
api/get_sale_details.php
```

Returns information about a specific completed sale.

---

## 🧪 Sample Data

The database includes sample products such as:

* Milk
* Bread
* Rice
* Sugar
* Tea
* Coffee
* Potato Chips
* Water
* Biscuits
* Butter
* Salt
* Cooking Oil

Products are organized into categories such as:

```text
Dairy
Bakery
Grocery
Beverages
Snacks
```

A low-stock product is included so the inventory warning functionality can be tested.

---

## 🎯 Project Objectives

This project demonstrates practical experience with:

* PHP backend development
* MySQL database design
* CRUD operations
* User authentication
* Session management
* REST-style API endpoints
* JavaScript DOM manipulation
* Fetch API
* Shopping cart logic
* Inventory management
* Transaction processing
* Relational databases
* Responsive web design

---

## 🚧 Future Improvements

Possible improvements include:

* Multiple user roles
* Customer management
* Printable PDF invoices
* Sales analytics dashboard
* Daily/monthly revenue reports
* Product image support
* Barcode scanner integration
* Advanced inventory reports
* Password change functionality
* CSRF protection
* Improved input validation
* Deployment to a production server

---

## 👨‍💻 Author

**Ziad Sayed Ahmed (Zico)**

📧 `z.hamzawyyy@gmail.com`

---

## 📌 Disclaimer

This project was developed as a **Web Programming course project** and is intended primarily for educational and portfolio purposes.

For production use, additional security hardening, deployment configuration, user management, and validation would be recommended.
