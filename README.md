# Inventory & Point-of-Sale System

A simple POS and inventory management system built for a Web Programming course project. The idea is a basic POS that a small shop (like a grocery store) could actually use — log in, browse products, add to cart, checkout, and the system saves the invoice and reduces stock automatically.

## Features

- **Login system** (session-based) — protects all pages
- **POS screen** with a product browser and a cart on the side
- Search products by name
- Barcode lookup (type or scan a barcode and press Enter to add to cart)
- Filter by category and sort by price
- Cart with +/- quantity controls, remove button, and live subtotal/total
- **Inventory management** (add/edit/delete products)
- Low stock warnings (highlighted in red when stock ≤ 5)
- Smart delete — blocks deleting products that exist in past invoices (protects history)
- **Transaction history** with invoice details
- Stock is reduced automatically after each sale
- Responsive layout — works on phone, tablet, and desktop

## Technologies

- HTML5 (semantic tags: header, nav, main, section, aside, footer)
- CSS3 (Grid for layout, Flexbox for cart rows, media queries for responsiveness)
- Vanilla JavaScript (Cart class, fetch API, DOM manipulation)
- PHP (procedural with PDO + sessions for login)
- MySQL

No Bootstrap, no Tailwind, no frameworks. Just plain web tech.

## Setup Instructions (XAMPP)

1. Copy the entire `inventory-pos` folder into your `htdocs` directory.
   Example: `C:\xampp\htdocs\inventory-pos`

2. Start **Apache** and **MySQL** from the XAMPP control panel.

3. Open phpMyAdmin in your browser: `http://localhost/phpmyadmin`

4. Import the database:
   - Click on the "Import" tab
   - Choose the file `database.sql` from the project folder
   - Click "Go"

5. **Run the setup script once** to create the admin account:
   `http://localhost/inventory-pos/setup.php`

   This creates a default login: **admin / admin123**

6. Open the project:
   `http://localhost/inventory-pos/`

   You'll be redirected to the login page. Use the admin credentials and you're in.

## Database Configuration

If your MySQL has a password, edit `config/db.php`:

```php
$user = 'root';
$pass = '';   // put your password here
```

By default it uses the standard XAMPP settings (user `root`, no password).

## Default Login

After running `setup.php`:
- **Username:** admin
- **Password:** admin123

You can change the password by editing `setup.php` and re-running it.

## Pages

| Page | Description |
|------|-------------|
| `login.php` | Login page (unprotected) |
| `setup.php` | One-time setup to create the admin user |
| `index.php` | Main POS screen with product grid + cart |
| `admin/products.php` | Inventory list with add/edit/delete |
| `admin/add_product.php` | Form to add a new product |
| `admin/edit_product.php` | Form to edit an existing product |
| `history.php` | List of completed sales |
| `sale_details.php` | Invoice view for a single sale |
| `logout.php` | Destroys session and returns to login |

The `api/` folder has three small endpoints used by JavaScript fetch calls:
- `get_products.php` returns all products as JSON
- `checkout.php` processes a sale (POST request)
- `get_sale_details.php` returns details for one sale

## File Structure

```
inventory-pos/
├── login.php             Login form
├── logout.php            Destroys session
├── setup.php             One-time admin setup
├── index.php             POS screen (protected)
├── history.php           Sales history (protected)
├── sale_details.php      Single invoice view (protected)
├── database.sql          DB schema + sample data
├── config/
│   ├── db.php            PDO connection
│   └── auth.php          Session helper / require_login()
├── api/
│   ├── get_products.php
│   ├── checkout.php
│   └── get_sale_details.php
├── admin/
│   ├── products.php      Inventory listing (protected)
│   ├── add_product.php
│   ├── edit_product.php
│   └── delete_product.php
└── assets/
    ├── css/style.css
    └── js/app.js
```

## Sample Products

The `database.sql` file inserts 12 sample products including Milk, Bread, Rice, Sugar, Tea, Coffee, Chips, Water, Biscuits, Butter, Salt, and Cooking Oil — across categories like Dairy, Bakery, Grocery, Beverages, and Snacks.

One product (Butter) is intentionally set to low stock (4) so you can see the low-stock warning in action.

## Technical Challenges

A few things that were trickier than expected while building this:

1. **Transactional checkout.** When the user clicks checkout we need to insert a sale, insert all sale items, AND reduce stock for each product. If any of these fails, none of them should happen. We solved this with `PDO::beginTransaction()` and `rollBack()` in `checkout.php`.

2. **Preventing negative stock.** The query `UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?` makes sure stock cannot go below zero. If the update affects 0 rows, we know there wasn't enough stock and the transaction rolls back.

3. **Not trusting client-side prices.** The cart sends item IDs and quantities, but the server re-fetches prices from the database before saving. Otherwise someone could modify the JS and pay $0 for everything.

4. **Delete with foreign key constraints.** Originally clicking Delete just silently failed if the product was already in a past sale (because of the `sale_items` foreign key). We fixed this by checking `sale_items` first — if the product is in any past invoice, we show a friendly message saying it can't be deleted (because it would break history), otherwise we delete normally.

5. **Cart buttons not responding.** The first version used HTML entities like `&times;` inside buttons and event delegation with `closest('button')`. That had issues in some browsers because clicks were sometimes registered on the inner content instead of the button. We rewrote the cart to build elements with `document.createElement` and attach event listeners directly to each button — more code, but 100% reliable.

6. **Login & session protection.** We added a `config/auth.php` helper with `require_login()` that every protected page calls at the top. If no session exists, the user is redirected to `login.php`. Passwords are stored with `password_hash()` and verified with `password_verify()`.

## Known Limitations

- No user registration UI — to add more users, insert them via phpMyAdmin or extend `setup.php`.
- No receipt printing.
- Deleting a product that's already in a past sale is intentionally blocked to protect invoice history (a friendlier alternative is to set stock to 0 to hide it from the POS).
- No discount/tax support yet — the cart treats subtotal = total.

## Authors

Web Programming course project, Spring 2026.
