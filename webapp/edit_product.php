<?php
session_start();
include('db.php');

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$product_id = $_GET['id'] ?? null;
$message = '';

if (!$product_id) {
    die("Product ID is required!");
}

// Fetch the current product details from the database
$stmt = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    die("Product not found!");
}

$name = $product['name'];
$description = $product['description'];
$price = $product['price'];
$current_image = $product['image'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Optional: handle image upload
    $image = $current_image;
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/" . $image);
    }

    // Update product details in the database
    $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, price = ?, image = ? WHERE id = ?");
    $stmt->execute([$name, $description, $price, $image, $product_id]);

    $message = "Product updated successfully!";
}

?>

<!-- HTML form -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Edit Product</h2>
    <?php if ($message): ?>
        <div class="alert alert-success"><?= $message ?></div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data">
        <div class="mb-3">
            <label>Name:</label>
            <input type="text" name="name" class="form-control" required value="<?= htmlspecialchars($name) ?>">
        </div>
        <div class="mb-3">
            <label>Description:</label>
            <textarea name="description" class="form-control" required><?= htmlspecialchars($description) ?></textarea>
        </div>
        <label for="category">Category:</label>
<select name="category" id="category" required>
    <option value="Fruit">Fruit</option>
    <option value="Vegetable">Vegetable</option>
    <option value="Dairy">Dairy</option>
</select>

        <div class="mb-3">
            <label>Price:</label>
            <input type="number" step="0.01" name="price" class="form-control" required value="<?= htmlspecialchars($price) ?>">
        </div>
        <div class="mb-3">
            <label>Image:</label>
            <input type="file" name="image" class="form-control">
            <?php if ($current_image): ?>
                <img src="assets/images/<?= htmlspecialchars($current_image) ?>" alt="Current Image" class="img-fluid mt-3" style="max-width: 150px;">
            <?php endif; ?>
        </div>
        <button type="submit" class="btn btn-success">Update Product</button>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>

