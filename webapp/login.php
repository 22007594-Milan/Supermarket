<?php
session_start();
include('db.php');


$error_message = '';
$username = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE username = ?");
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        // Generate a 6-digit code
        $code = rand(100000, 999999);
    
        // Save code in DB
        $stmt = $pdo->prepare("UPDATE users SET verification_code = ? WHERE id = ?");
        $stmt->execute([$code, $user['id']]);
    
        // Store user temporarily
        $_SESSION['temp_user_id'] = $user['id'];
        $_SESSION['2fa_email'] = $user['email'];
    
        // Send email
        require __DIR__ . '/send_email.php';

        send_2fa_email($user['email'], $code);
    
        // Redirect to 2FA verification page
        header('Location: verify_email_2fa.php');
        exit();
    }
    else {
        $error_message = "Username or password is incorrect!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - E-Commerce</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container d-flex justify-content-center align-items-center vh-100">
    <div class="card shadow p-4" style="max-width: 400px; width: 100%;">
        <h3 class="text-center mb-4">Login To My Supermarket</h3>

        <?php if ($error_message): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="login.php">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" name="username" class="form-control" id="username" value="<?php echo htmlspecialchars($username); ?>" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" name="password" class="form-control" id="password" required>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary">Login</button>
            </div>
        </form>

        <p class="text-center">Don't have an account? <a href="register.php">Register here</a></p>
    </div>
</div>

</body>
</html>




