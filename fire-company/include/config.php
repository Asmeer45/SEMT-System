<?php 

// Create constants to store non-repeating values
define('LOCALHOST', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'semt_db');

// Database connection
$conn = mysqli_connect(LOCALHOST, DB_USERNAME, DB_PASSWORD);

// Check if the connection was successful
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// Select database
$db_select = mysqli_select_db($conn, DB_NAME);

// Check if database selection was successful
if (!$db_select) {
    die("Database selection failed: " . mysqli_error($conn));
}

?>
