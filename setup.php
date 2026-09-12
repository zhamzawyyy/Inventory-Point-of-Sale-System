<?php
// One-time setup script
// Run this ONCE after importing database.sql to set up the admin password
// Then delete this file (or leave it — it's safe to run multiple times)

require_once 'config/db.php';

$username = 'admin';
$password = 'admin123';
$hashed = password_hash($password, PASSWORD_DEFAULT);

try {
    // Check if admin user exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $existing = $stmt->fetch();

    if ($existing) {
        // Update password
        $upd = $pdo->prepare("UPDATE users SET password = ? WHERE username = ?");
        $upd->execute([$hashed, $username]);
        $message = "Admin password reset successfully.";
    } else {
        // Insert new admin
        $ins = $pdo->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $ins->execute([$username, $hashed]);
        $message = "Admin user created successfully.";
    }
    $success = true;
} catch (PDOException $e) {
    $message = "Error: " . $e->getMessage();
    $success = false;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Setup - QuickShop POS</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<div class="container" style="max-width:600px; margin-top:80px;">
    <div class="form-card">
        <h2 style="margin-bottom:20px; color:#2c3e50;">Setup Complete</h2>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $message ?></div>
            <p style="margin: 15px 0; line-height: 1.7;">
                You can now log in with:<br>
                <strong>Username:</strong> admin<br>
                <strong>Password:</strong> admin123
            </p>
            <a href="login.php" class="btn">Go to Login</a>
        <?php else: ?>
            <div class="alert alert-error"><?= htmlspecialchars($message) ?></div>
            <p>Make sure you imported <code>database.sql</code> first.</p>
        <?php endif; ?>
    </div>
</div>
</body>
</html>
