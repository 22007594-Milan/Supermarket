<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];

// Add to Cart
if (isset($_POST['add_to_cart'])) {
    $product_id = $_POST['product_id'];
    $quantity = $_POST['quantity'];

    $stmt = $pdo->prepare("SELECT * FROM carts WHERE user_id = ? AND product_id = ?");
    $stmt->execute([$user_id, $product_id]);
    $existing_cart_item = $stmt->fetch();

    if ($existing_cart_item) {
        $new_quantity = $existing_cart_item['quantity'] + $quantity;
        $stmt = $pdo->prepare("UPDATE carts SET quantity = ? WHERE user_id = ? AND product_id = ?");
        $stmt->execute([$new_quantity, $user_id, $product_id]);
    } else {
        $stmt = $pdo->prepare("INSERT INTO carts (user_id, product_id, quantity) VALUES (?, ?, ?)");
        $stmt->execute([$user_id, $product_id, $quantity]);
    }

    header('Location: cart.php');
    exit();
}

// Fetch cart items
$stmt = $pdo->prepare("SELECT c.quantity, p.id AS product_id, p.name, p.price, p.image FROM carts c JOIN products p ON c.product_id = p.id WHERE c.user_id = ?");
$stmt->execute([$user_id]);
$cart_items = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Your Cart - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-4">
    <h2 class="text-center">Your Cart</h2>

    <?php if (empty($cart_items)): ?>
        <p>Your cart is empty. Start shopping now!</p>
    <?php else: ?>
        <form method="POST" action="checkout.php">
            <table class="table table-bordered align-middle">
                <thead>
                    <tr>
                        <th>Checkout</th>
                        <th>Product Name</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Remove</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $total = 0; ?>
                    <?php foreach ($cart_items as $item): ?>
                        <tr>
                            <td>
                                <input type="checkbox" name="selected_items[]" value="<?= $item['product_id'] ?>">
                            </td>
                            <td><?= htmlspecialchars($item['name']) ?></td>
                            <td>$<?= number_format($item['price'], 2) ?></td>
                            <td><?= $item['quantity'] ?></td>
                            <td>$<?= number_format($item['price'] * $item['quantity'], 2) ?></td>
                            <td>
                                <input type="checkbox" form="remove-form" name="remove_items[]" value="<?= $item['product_id'] ?>">
                            </td>
                        </tr>
                        <?php $total += $item['price'] * $item['quantity']; ?>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h4>Total in Cart: $<?= number_format($total, 2) ?></h4>

            <div class="d-flex justify-content-between">
                <button type="submit" class="btn btn-success">Checkout</button>
        </form>

        <!-- Remove form -->
        <form method="POST" action="remove_from_cart.php" id="remove-form" onsubmit="return confirm('Remove selected items from cart?');">
            <button type="submit" name="remove_selected" class="btn btn-danger">Remove Selected</button>
        </form>
            </div>
    <?php endif; ?>
</div>

</body>
</html>








