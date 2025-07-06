<?php
session_start();
include('db.php');

// Category filter logic
$filter = $_GET['category'] ?? '';

if ($filter) {
    $stmt = $pdo->prepare("SELECT * FROM products WHERE category = ?");
    $stmt->execute([$filter]);
} else {
    $stmt = $pdo->query("SELECT * FROM products");
}

$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Supermarket - Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Sticky Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">🛒 MySupermarket</a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNavbar">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Category Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="productDropdown" role="button" data-bs-toggle="dropdown">
                        Products
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="index.php?category=Fruit">Fruits</a></li>
                        <li><a class="dropdown-item" href="index.php?category=Vegetable">Vegetables</a></li>
                        <li><a class="dropdown-item" href="index.php?category=Dairy">Dairy</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="index.php">All Products</a></li>
                        <li><a class="dropdown-item" href="contact.php">Contact Us</a></li>
                    </ul>
                </li>
            </ul>

            <div class="d-flex gap-2">
                <?php if (isset($_SESSION['username'])): ?>
                    <a href="cart.php" class="btn btn-outline-light btn-lg">🛍 View Cart</a>
                    <a href="my_orders.php" class="btn btn-outline-light btn-lg">My Orders</a> <!-- Link to My Orders -->
                    <a href="logout.php" class="btn btn-danger btn-lg">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-primary btn-lg">Login</a>
                    <a href="register.php" class="btn btn-primary btn-lg">Register</a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>


<!-- Product Display -->
<div class="container mt-4">
    <?php if ($filter): ?>
        <h3 class="mb-4">Showing: <?= htmlspecialchars($filter) ?></h3>
    <?php endif; ?>

    <div class="row">
        <?php if (empty($products)): ?>
            <p class="text-muted">No products found in this category.</p>
        <?php else: ?>
            <?php foreach ($products as $product): ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100">
                        <?php if ($product['image']): ?>
                            <img src="images/<?= htmlspecialchars($product['image']) ?>" class="card-img-top" alt="Product Image">

                        <?php endif; ?>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title"><?= htmlspecialchars($product['name']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text"><strong>$<?= number_format($product['price'], 2) ?></strong></p>

                            <?php if (isset($_SESSION['username'])): ?>
                                <form method="POST" action="cart.php" class="mt-auto">
                                    <input type="hidden" name="product_id" value="<?= $product['id'] ?>">
                                    <input type="number" name="quantity" value="1" min="1" class="form-control mb-2">
                                    <button type="submit" name="add_to_cart" class="btn btn-primary w-100">Add to Cart</button>
                                </form>
                            <?php else: ?>
                                <p class="text-center text-muted mt-auto">Login to buy</p>
                                <a href="login.php" class="btn btn-outline-primary w-100">Login to Add to Cart</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

</body>
</html>





