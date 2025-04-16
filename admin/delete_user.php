<?php
include('include/session_check.php');
checkRole('admin');
?>


<?php

include('../include/config.php');

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Ensure the ID is an integer

    // Prepare and execute delete query
    $deleteQuery = "DELETE FROM user WHERE userid = ?";
    if ($stmt = $conn->prepare($deleteQuery)) {
        $stmt->bind_param("i", $id);
        if ($stmt->execute()) {
            echo "<script>alert('User deleted successfully.'); window.location.href='user_management.php';</script>";
        } else {
            echo "<script>alert('Error deleting user.'); window.location.href='user_management.php';</script>";
        }
        $stmt->close();
    } else {
        echo "<script>alert('Error preparing statement.'); window.location.href='user_management.php';</script>";
    }
    $conn->close();
} else {
    echo "<script>alert('Invalid request.'); window.location.href='user_management.php';</script>";
}
?>
