
<?php
include('include/session_check.php');
checkRole('station_master');
?>

<?php
session_start();
include 'include/config.php'; // Ensure this file contains the database connection ($conn)

if (isset($_GET['serial_number'])) {
    $serial_number = $_GET['serial_number'];

    // Prepare delete query
    $deleteQuery = "DELETE FROM fire_extinguishers WHERE serial_number = ?";
    $stmt = $conn->prepare($deleteQuery);
    $stmt->bind_param("s", $serial_number);

    if ($stmt->execute()) {
        echo "<script>alert('Record deleted successfully!'); window.location.href='station-dashboard.php';</script>";
    } else {
        echo "<script>alert('Error deleting record!'); window.location.href='station-dashboard.php';</script>";
    }
    $stmt->close();
}
$conn->close();
?>
