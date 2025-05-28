<?php
session_start();
include('db.php');

// Ensure the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Handle selected items if passed via POST
$selected_items = isset($_POST['selected_items']) ? $_POST['selected_items'] : [];

// Fetch selected cart items if available, otherwise fetch all
if (!empty($selected_items)) {
    // Prepare placeholders for IN clause
    $placeholders = rtrim(str_repeat('?,', count($selected_items)), ',');
    $params = array_merge([$user_id], $selected_items);

    $stmt = $pdo->prepare("
        SELECT c.quantity, p.id AS product_id, p.name, p.price 
        FROM carts c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ? AND c.product_id IN ($placeholders)
    ");
    $stmt->execute($params);
} else {
    $stmt = $pdo->prepare("
        SELECT c.quantity, p.id AS product_id, p.name, p.price 
        FROM carts c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ?
    ");
    $stmt->execute([$user_id]);
}

$cart_items = $stmt->fetchAll();

// Calculate total amount
$total_amount = 0;
foreach ($cart_items as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Store data in session for use in place_order.php
$_SESSION['cart_total'] = $total_amount;
$_SESSION['checkout_items'] = array_column($cart_items, 'product_id');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Checkout - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2>Checkout</h2>

    <?php if (empty($cart_items)): ?>
        <div class="alert alert-info">No items selected or your cart is empty.</div>
    <?php else: ?>
        <h4>Your Selected Items</h4>
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
                <?php foreach ($cart_items as $item): ?>
                    <tr>
                        <td><?= htmlspecialchars($item['name']) ?></td>
                        <td>$<?= number_format($item['price'], 2) ?></td>
                        <td><?= $item['quantity'] ?></td>
                        <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <h4>Total: $<?= number_format($total_amount, 2) ?></h4>

        <!-- Checkout Form -->
        <form method="POST" action="place_order.php">
            <div class="mb-3">
                <label for="shipping_address" class="form-label">Shipping Address</label>
                <input type="text" class="form-control" id="shipping_address" name="shipping_address" required>
            </div>

            <div class="mb-3">
                <label for="payment_method" class="form-label">Payment Method</label>
                <select class="form-select" id="payment_method" name="payment_method" required>
                    <option value="Credit Card">Credit Card</option>
                    <option value="PayPal">PayPal</option>
                    <option value="Cash on Delivery">Cash on Delivery</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Place Order</button>
        </form>
    <?php endif; ?>
</div>

</body>
</html>




