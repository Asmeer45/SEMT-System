<?php
session_start();

// Function to check if the user is logged in
function checkRole($requiredRole) {
    if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true || $_SESSION['user_type'] !== $requiredRole) {
        // Redirect to the custom 404 error page if not logged in
        header("Location: include/error404.php");
        exit();
    }
}
?>


