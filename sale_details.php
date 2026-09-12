<?php
require_once 'config/auth.php';
require_login();
require_once 'config/db.php';

$id = intval($_GET['id'] ?? 0);
if ($id < 1) {
    header("Location: history.php");
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM sales WHERE id = ?");
$stmt->execute([$id]);
$sale = $stmt->fetch();

if (!$sale) {
    header("Location: history.php");
    exit;
}

$itemsStmt = $pdo->prepare("SELECT * FROM sale_items WHERE sale_id = ?");
$itemsStmt->execute([$id]);
$items = $itemsStmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #<?= $sale['id'] ?></title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<header class="topbar">
    <h1>QuickShop POS</h1>
    <nav>
        <a href="index.php">POS</a>
        <a href="admin/products.php">Inventory</a>
        <a href="history.php" class="active">History</a>
        <a href="logout.php">Logout</a>
    </nav>
</header>

<div class="container">
    <div class="page-header">
        <h2>Invoice Details</h2>
        <a href="history.php" class="btn btn-secondary">← Back to History</a>
    </div>

    <div class="invoice-box">
        <div class="invoice-header">
            <h2>Invoice #<?= $sale['id'] ?></h2>
            <p>Date: <?= date('F d, Y - H:i', strtotime($sale['sale_date'])) ?></p>
        </div>

        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $it): ?>
                    <tr>
                        <td><?= htmlspecialchars($it['product_name']) ?></td>
                        <td><?= $it['quantity'] ?></td>
                        <td>$<?= number_format($it['price'], 2) ?></td>
                        <td>$<?= number_format($it['subtotal'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <div class="invoice-total">
            Total: $<?= number_format($sale['total'], 2) ?>
        </div>
    </div>
</div>

<footer class="footer">
    <p>&copy; <?= date('Y') ?> QuickShop POS</p>
</footer>

</body>
</html>
