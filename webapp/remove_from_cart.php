<?php
session_start();
include('db.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['remove_selected']) && isset($_POST['remove_items'])) {
    foreach ($_POST['remove_items'] as $product_id) {
        $stmt = $pdo->prepare("DELETE FROM carts WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$user_id, $product_id]);
    }
}

header('Location: cart.php');
exit();
?>

