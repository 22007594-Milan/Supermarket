<?php
session_start();
include('db.php');

// Check if user is logged in and is admin
if (!isset($_SESSION['username']) || $_SESSION['role'] !== 'admin') {
    header('Location: index.php');
    exit();
}

// Fetch all products
$stmt = $pdo->query("SELECT * FROM products ORDER BY id DESC");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - My Supermarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h2 class="mb-4">Admin Dashboard</h2>

    <div class="mb-3">
        <a href="admin_orders.php" class="btn btn-primary">Manage Order</a> <!-- Link to orders.php -->
        <a href="add_product.php" class="btn btn-success">+ Add New Product</a>
        <a href="logout.php" class="btn btn-secondary">Logout</a>
    </div>

    <?php if (count($products) === 0): ?>
        <div class="alert alert-info">No products found. Click "Add New Product" to create one.</div>
    <?php else: ?>
        <table class="table table-bordered table-hover">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Description</th>
                    <th>Price ($)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?= $product['id'] ?></td>
                        <td>
                            <?php if ($product['image']): ?>
                                <img src="assets/images/<?= htmlspecialchars($product['image']) ?>" width="60">
                            <?php else: ?>
                                <em>No image</em>
                            <?php endif; ?>
                        </td>
                        <td><?= htmlspecialchars($product['name']) ?></td>
                        <td><?= htmlspecialchars($product['description']) ?></td>
                        <td><?= number_format($product['price'], 2) ?></td>
                        <td>
                            <a href="edit_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-warning">Edit</a>
                            <a href="delete_product.php?id=<?= $product['id'] ?>" class="btn btn-sm btn-danger"
                               onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
</body>
</html>

