<?php
session_start();
include('db.php');

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$id = $_GET['id'] ?? null;

if ($id) {
    try {
        // First delete related order_items (to avoid FK constraint error)
        $stmt1 = $pdo->prepare("DELETE FROM order_items WHERE product_id = ?");
        $stmt1->execute([$id]);

        // Then delete the product
        $stmt2 = $pdo->prepare("DELETE FROM products WHERE id = ?");
        $stmt2->execute([$id]);

        header('Location: dashboard.php?msg=Product deleted');
        exit();
    } catch (PDOException $e) {
        // Handle deletion error (e.g. foreign key constraint)
        header('Location: dashboard.php?error=Could not delete product: ' . urlencode($e->getMessage()));
        exit();
    }
} else {
    header('Location: dashboard.php?error=Invalid product ID');
    exit();
}
?>

