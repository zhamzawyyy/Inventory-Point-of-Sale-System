<?php
require_once 'config/auth.php';
require_login();
require_once 'config/db.php';

// Get distinct categories for the filter dropdown
$cat_stmt = $pdo->query("SELECT DISTINCT category FROM products ORDER BY category");
$categories = $cat_stmt->fetchAll(PDO::FETCH_COLUMN);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>POS - Inventory System</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="topbar">
    <h1>QuickShop POS</h1>
    <nav>
        <a href="index.php" class="active">POS</a>
        <a href="admin/products.php">Inventory</a>
        <a href="history.php">History</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<main class="pos-layout">

    <!-- LEFT SIDE: Products -->
    <section class="products-section">
        <div class="filters">
            <input type="text" id="searchInput" placeholder="Search product by name...">
            <input type="text" id="barcodeInput" placeholder="Scan / enter barcode">
            <select id="categoryFilter">
                <option value="">All categories</option>
                <?php foreach ($categories as $cat): ?>
                    <option value="<?= htmlspecialchars($cat) ?>"><?= htmlspecialchars($cat) ?></option>
                <?php endforeach; ?>
            </select>
            <select id="sortBy">
                <option value="">Sort by</option>
                <option value="price_asc">Price (Low to High)</option>
                <option value="price_desc">Price (High to Low)</option>
                <option value="name_asc">Name (A-Z)</option>
            </select>
        </div>

        <div id="productGrid" class="product-grid">
            <p class="loading">Loading products...</p>
        </div>
    </section>

    <!-- RIGHT SIDE: Cart -->
    <aside class="cart-section">
        <h2>Cart</h2>
        <ol id="cartList" class="cart-list">
            <li class="empty-cart">Cart is empty</li>
        </ol>

        <div class="cart-summary">
            <div class="row">
                <span>Subtotal:</span>
                <span id="subtotal">$0.00</span>
            </div>
            <div class="row total">
                <span>Total:</span>
                <span id="total">$0.00</span>
            </div>
            <button id="checkoutBtn" class="btn-checkout">Checkout</button>
            <button id="clearCartBtn" class="btn-clear">Clear Cart</button>
        </div>
    </aside>

</main>

<footer class="footer">
    <p>&copy; <?= date('Y') ?> QuickShop POS - Web Programming Project</p>
</footer>

<script src="assets/js/app.js"></script>
</body>
</html>
