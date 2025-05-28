<?php
session_start();
include('db.php');

$error = '';  // Initialize the error variable

if (!isset($_SESSION['temp_user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entered_code = $_POST['code'];
    $user_id = $_SESSION['temp_user_id'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? AND verification_code = ?");
    $stmt->execute([$user_id, $entered_code]);
    $user = $stmt->fetch();

    if ($user) {
        // Verified — start session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Clear temp session
        unset($_SESSION['temp_user_id']);
        unset($_SESSION['2fa_email']);

        // Optionally clear the verification code from DB
        $pdo->prepare("UPDATE users SET verification_code = NULL WHERE id = ?")->execute([$user_id]);

        header('Location: dashboard.php');
        exit();
    } else {
        $error = "Invalid verification code.";
    }
}
?>

<!-- HTML form with Bootstrap for styling -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verify 2FA - My Supermarket</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: Arial, sans-serif;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
        }
        .container {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .alert {
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card p-4" style="width: 100%; max-width: 400px;">
        <h2 class="text-center mb-4">Verify 2FA Code</h2>
        
        <!-- Display error message if there's any -->
        <?php if ($error): ?>
            <div class="alert alert-danger" role="alert">
                <?= $error ?>
            </div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label for="code" class="form-label">Enter your 6-digit verification code</label>
                <input type="text" name="code" id="code" class="form-control" placeholder="Enter 6-digit code" required>
            </div>
            <button type="submit" class="btn btn-primary w-100">Verify</button>
        </form>

        <p class="text-center mt-3">
            <a href="login.php" class="btn btn-link p-0">Back to login</a>
        </p>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>





