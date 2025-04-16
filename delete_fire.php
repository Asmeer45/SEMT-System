<?php
include('include/session_check.php');
checkRole('station_master');
?>

<?php
include 'db_connection.php';

if (isset($_GET['serial_number'])) {
    $serialNumber = $_GET['serial_number'];
    $query = "DELETE FROM weight_scales WHERE serial_number = '$serialNumber'";
    mysqli_query($conn, $query);
}

header("Location: index.php"); // Redirect back to the main page
exit();
?>
