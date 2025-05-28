<?php
session_start();
include('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Get the order ID from URL
$order_id = $_GET['order_id'] ?? null;
if (!$order_id) {
    header("Location: my_orders.php");
    exit;
}

// Fetch the order details for this user
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
$stmt->execute([$order_id, $_SESSION['user_id']]);
$order = $stmt->fetch();

if (!$order) {
    header("Location: my_orders.php");
    exit;
}

// Fetch order items
$stmt = $pdo->prepare("
    SELECT p.name, oi.quantity, oi.price 
    FROM order_items oi 
    JOIN products p ON oi.product_id = p.id 
    WHERE oi.order_id = ?
");
$stmt->execute([$order_id]);
$items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Details - My Supermarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<!-- Sticky Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🛒 MySupermarket</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="my_orders.php">My Orders</a></li>
            </ul>
            <div class="d-flex gap-2">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="cart.php" class="btn btn-outline-light btn-lg">🛍 View Cart</a>
                    <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-primary btn-lg">Login</a>
                    <a href="register.php" class="btn btn-primary btn-lg">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="container mt-5">
    <h2>Order #<?= htmlspecialchars($order['id']) ?> Details</h2>
    <p><strong>Date:</strong> <?= htmlspecialchars($order['created_at']) ?></p>
    <p><strong>Status:</strong> <?= htmlspecialchars($order['status']) ?></p>
    <p><strong>Total:</strong> $<?= number_format($order['total_amount'], 2) ?></p>

    <h4 class="mt-4">Items</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Product</th>
                <th>Qty</th>
                <th>Price</th>
                <th>Subtotal</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td>$<?= number_format($item['quantity'] * $item['price'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <a href="my_orders.php" class="btn btn-secondary">← Back to My Orders</a>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
