<?php
session_start();
include('db.php');

// Only allow admins
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $order_id = $_POST['order_id'] ?? null;
    $status = $_POST['status'] ?? '';

    if ($order_id && in_array($status, ['Processing', 'Shipped', 'Delivered'])) {
        $stmt = $pdo->prepare("UPDATE orders SET status = ? WHERE id = ?");
        $stmt->execute([$status, $order_id]);
    }
}

header('Location: admin_orders.php'); // Redirect back to orders page
exit;
