<?php
include('include/session_check.php');
checkRole('admin');
?>

<?php
include('../include/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'];
    $oldPassword = $_POST['old_password'];
    $newPassword = $_POST['new_password'];

    $query = "SELECT password FROM user WHERE userid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($hashedPassword);
    $stmt->fetch();
    $stmt->close();

    if (password_verify($oldPassword, $hashedPassword)) {
        $newHashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        $updateQuery = "UPDATE user SET password = ? WHERE userid = ?";
        $updateStmt = $conn->prepare($updateQuery);
        $updateStmt->bind_param("si", $newHashedPassword, $id);
        if ($updateStmt->execute()) {
            echo "Password updated successfully.";
        } else {
            echo "Error updating password.";
        }
        $updateStmt->close();
    } else {
        echo "Old password is incorrect.";
    }

    $conn->close();
}
?>
