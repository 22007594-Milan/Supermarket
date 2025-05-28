<?php
// Include the database connection
include('db.php');

$username = $email = '';
$password_error = $email_error = $success_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Check if passwords match
    if ($password !== $confirm_password) {
        $password_error = "Passwords do not match!";
    } else {
        // Check if email already exists
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();

        if ($user) {
            $email_error = "Email already exists!";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert into database
            $stmt = $pdo->prepare("INSERT INTO users (username, email, password, role) VALUES (?, ?, ?, 'student')");
            $stmt->execute([$username, $email, $hashed_password]);

            $success_message = "Registration successful! <a href='login.php'>Click here to login</a>";

            // Clear form
            $username = $email = '';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - E-Commerce</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        function validatePasswords() {
            var pw = document.getElementById("password").value;
            var cpw = document.getElementById("confirm_password").value;
            var error = document.getElementById("passwordError");

            if (pw !== cpw) {
                error.textContent = "Passwords do not match!";
                error.style.color = "red";
                return false;
            } else {
                error.textContent = "";
                return true;
            }
        }
    </script>
</head>
<body>
<div class="container mt-5" style="max-width: 500px;">
    <h2 class="text-center mb-4">Create an Account</h2>

    <?php if ($password_error): ?>
        <div class="alert alert-danger"><?php echo $password_error; ?></div>
    <?php endif; ?>

    <?php if ($email_error): ?>
        <div class="alert alert-danger"><?php echo $email_error; ?></div>
    <?php endif; ?>

    <?php if ($success_message): ?>
        <div class="alert alert-success"><?php echo $success_message; ?></div>
    <?php endif; ?>

    <form method="POST" onsubmit="return validatePasswords()" class="border p-4 shadow bg-light rounded">
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" name="username" value="<?php echo htmlspecialchars($username); ?>" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
        </div>

        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            <small id="passwordError" class="form-text text-danger"></small>
        </div>

        <button type="submit" class="btn btn-primary w-100">Register</button>
    </form>

    <div class="text-center mt-3">
        Already have an account? <a href="login.php">Login here</a>
    </div>
</div>
</body>
</html>





