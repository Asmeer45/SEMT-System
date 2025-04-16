<?php
// Assuming you already have the database connection
include("include/config.php"); // Include your database connection

if (isset($_GET['StationID'])) {
    $stationId = $_GET['StationID'];

    // Query to get platforms for the selected station
    $platformsQuery = "SELECT platform_number FROM platform WHERE StationID = ?";
    $stmt = $conn->prepare($platformsQuery);
    $stmt->bind_param("i", $stationId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $platforms = [];
    while ($row = $result->fetch_assoc()) {
        $platforms[] = $row;
    }
    
    // Return platform data as JSON
    echo json_encode($platforms);
}
?>
