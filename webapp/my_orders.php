<?php
session_start();
include('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Fetch orders for this user
$stmt = $pdo->prepare("
    SELECT o.id, o.total_amount, o.created_at, o.status,
           GROUP_CONCAT(p.name SEPARATOR ', ') AS items
    FROM orders o
    JOIN order_items oi ON o.id = oi.order_id
    JOIN products p ON oi.product_id = p.id
    WHERE o.user_id = ?
    GROUP BY o.id
    ORDER BY o.created_at DESC
");

$stmt->execute([$_SESSION['user_id']]);
$orders = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Orders - My Supermarket</title>
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

<!-- Order History Section -->
<div class="container mt-4">
    <h1>My Orders</h1>

    <?php if (empty($orders)): ?>
        <p class="text-muted">You have no orders yet.</p>
    <?php else: ?>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Ordered Items</th>
                    <th>Date</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><?= htmlspecialchars($order['id']) ?></td>
                        <td><?= htmlspecialchars($order['items']) ?></td>
                        <td><?= htmlspecialchars($order['created_at']) ?></td>
                        <td>$<?= number_format($order['total_amount'], 2) ?></td>
                        <td><?= htmlspecialchars($order['status']) ?></td>
                        <td><a href="order_detail.php?order_id=<?= $order['id'] ?>" class="btn btn-info btn-sm">View Details</a></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
