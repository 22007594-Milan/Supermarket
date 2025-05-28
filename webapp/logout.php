<?php
session_start(); // Start the session

// Destroy the session to log out the user
session_unset(); // Unset all session variables
session_destroy(); // Destroy the session

// Redirect to the home page (index.php) after logging out
header('Location: index.php');
exit();
?>
