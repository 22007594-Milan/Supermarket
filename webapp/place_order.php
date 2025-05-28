<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id']) || !isset($_POST['shipping_address']) || !isset($_POST['payment_method']) || !isset($_SESSION['checkout_items'])) {
    header('Location: cart.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$shipping_address = $_POST['shipping_address'];
$payment_method = $_POST['payment_method'];
$selected_items = $_SESSION['checkout_items'];

// Fetch selected cart items from DB
$placeholders = implode(',', array_fill(0, count($selected_items), '?'));
$sql = "SELECT c.product_id, c.quantity, p.price 
        FROM carts c 
        JOIN products p ON c.product_id = p.id 
        WHERE c.user_id = ? AND c.product_id IN ($placeholders)";
$params = array_merge([$user_id], $selected_items);
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$items_to_order = $stmt->fetchAll();

// Calculate total
$total_amount = 0;
foreach ($items_to_order as $item) {
    $total_amount += $item['price'] * $item['quantity'];
}

// Insert into `orders` table
$order_stmt = $pdo->prepare("INSERT INTO orders (user_id, total_amount, shipping_address, payment_method, status) VALUES (?, ?, ?, ?, 'Pending')");
$order_stmt->execute([$user_id, $total_amount, $shipping_address, $payment_method]);
$order_id = $pdo->lastInsertId();

// After inserting the order into the database, get the order ID
$order_id = $pdo->lastInsertId();  // Get the ID of the newly inserted order

// Insert into `order_items` table
$item_stmt = $pdo->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
foreach ($items_to_order as $item) {
    $item_stmt->execute([$order_id, $item['product_id'], $item['quantity'], $item['price']]);
}

// Remove items from cart
$delete_stmt = $pdo->prepare("DELETE FROM carts WHERE user_id = ? AND product_id IN ($placeholders)");
$delete_stmt->execute($params);

// Clear checkout session
unset($_SESSION['checkout_items']);
unset($_SESSION['cart_total']);

// Redirect to the order confirmation page with the order_id in the URL
header("Location: order_confirmation.php?order_id=" . $order_id);
exit();




