<?php
session_start();
include('db.php');

// Check if user is logged in and is admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Get the order ID and new status from the form
$order_id = $_POST['order_id'];
$status = $_POST['status'];

// Update the order status in the database
$stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
$stmt->execute([$status, $order_id]);

// Redirect back to the orders page
header('Location: orders.php');
exit();
?>
