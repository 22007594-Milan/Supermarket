<?php
session_start();
include('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

// Ensure the order_id exists in the URL
if (!isset($_GET['order_id']) || empty($_GET['order_id'])) {
    die("Order ID is missing.");
}

$order_id = $_GET['order_id']; // Get the order ID from the URL

// Fetch the order details
$stmt = $pdo->prepare("SELECT * FROM orders WHERE id = ?");
$stmt->execute([$order_id]);
$order = $stmt->fetch();

if (!$order) {
    die("Order not found.");
}

// Fetch the order items
$stmt = $pdo->prepare("SELECT p.name, oi.quantity, oi.price FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
$stmt->execute([$order_id]);
$order_items = $stmt->fetchAll();

if (!$order_items) {
    die("No items found for this order.");
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2>Order Confirmation</h2>

    <p>Thank you for your order! Your order ID is <strong>#<?= htmlspecialchars($order['id']) ?></strong>.</p>
    <p>Status: <?= htmlspecialchars($order['status']) ?></p>

    <h4>Order Details</h4>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Product Name</th>
                <th>Price</th>
                <th>Quantity</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($order_items as $item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['name']) ?></td>
                    <td>$<?= number_format($item['price'], 2) ?></td>
                    <td><?= $item['quantity'] ?></td>
                    <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h4>Total: $<?= number_format($order['total_amount'], 2) ?></h4>
</div>
    <div class="mt-4">
        <a href="index.php" class="btn btn-primary">Continue Shopping</a>
    </div>


</body>
</html>

