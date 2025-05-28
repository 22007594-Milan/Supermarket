<?php
session_start();
include('db.php');

if ($_SESSION['role'] !== 'admin') {
    die("Access denied");
}

$name = $description = $price = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    // Optional: handle image upload
    $image = '';
    if (!empty($_FILES['image']['name'])) {
        $image = basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "assets/images/" . $image);
    }

    $category = $_POST['category'];
    $stmt = $pdo->prepare("INSERT INTO products (name, price, image, category) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $price, $image, $category]);
    

    $message = "Product added successfully!";
    $name = $description = $price = '';
}
?>

<!-- HTML form -->
<!DOCTYPE html>
<html>
<head>
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Add New Product</h2>
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
        <div class="mb-3">
    <label for="category">Category:</label>
    <select name="category" id="category" class="form-select" required>
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
        </div>
        <button type="submit" class="btn btn-success">Add Product</button>
        <a href="dashboard.php" class="btn btn-secondary">Back</a>
    </form>
</div>
</body>
</html>