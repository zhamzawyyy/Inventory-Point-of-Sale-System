<?php
require_once 'config/auth.php';
require_login();
require_once 'config/db.php';

$stmt = $pdo->query("SELECT s.id, s.total, s.sale_date, COUNT(si.id) as item_count
                     FROM sales s
                     LEFT JOIN sale_items si ON si.sale_id = s.id
                     GROUP BY s.id
                     ORDER BY s.sale_date DESC");
$sales = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction History</title>
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
        <h2>Transaction History</h2>
    </div>

    <?php if (count($sales) === 0): ?>
        <p style="background:white; padding:20px; border-radius:8px; text-align:center;">
            No transactions yet.
        </p>
    <?php else: ?>
    <table>
        <thead>
            <tr>
                <th>Invoice #</th>
                <th>Date</th>
                <th>Items</th>
                <th>Total</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales as $s): ?>
                <tr>
                    <td>#<?= $s['id'] ?></td>
                    <td><?= date('M d, Y H:i', strtotime($s['sale_date'])) ?></td>
                    <td><?= $s['item_count'] ?></td>
                    <td><strong>$<?= number_format($s['total'], 2) ?></strong></td>
                    <td>
                        <a href="sale_details.php?id=<?= $s['id'] ?>" class="btn">View Details</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php endif; ?>
</div>

<footer class="footer">
    <p>&copy; <?= date('Y') ?> QuickShop POS</p>
</footer>

</body>
</html>
