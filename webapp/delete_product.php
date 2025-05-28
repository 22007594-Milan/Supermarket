<?php
session_start();
include('db.php');

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$id = $_GET['id'] ?? null;

if ($id) {
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);
}

header('Location: dashboard.php');
exit();
?>
