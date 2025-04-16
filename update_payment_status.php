<?php
include('include/session_check.php');
checkRole('station_master');
?>


<?php 
include 'include/config.php'; // Ensure this file connects to your database

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // Sanitize input

    session_start();

    $approvedBy = $_SESSION['user_name']; // Get the approving user

    // Start transaction to ensure both updates execute properly
    $conn->begin_transaction();

    try {

        $updateInvoiceQuery = "
        UPDATE fire_extinguishers_quotations
        SET 
            approved_by = ?, 
            approval_date = NOW() 
        WHERE id = ?";
    $stmt3 = mysqli_prepare($conn, $updateInvoiceQuery);
    mysqli_stmt_bind_param($stmt3, "si", $approvedBy, $id);
    mysqli_stmt_execute($stmt3);

        // Fetch repair_request_id from fire_extinguishers_quotations
        $queryFetch = "SELECT repair_request_id FROM fire_extinguishers_quotations WHERE id = ?";
        $stmtFetch = $conn->prepare($queryFetch);
        $stmtFetch->bind_param("i", $id);
        $stmtFetch->execute();
        $stmtFetch->bind_result($repair_request_id);
        $stmtFetch->fetch();
        $stmtFetch->close();

        if ($repair_request_id || $id) {
            // First update: fire_extinguishers_quotations.payment_status
            $query1 = "UPDATE fire_extinguishers_quotations SET payment_status = 'In Progress' WHERE id = ?";
            $stmt1 = $conn->prepare($query1);
            $stmt1->bind_param("i", $id);
            $stmt1->execute();
            $stmt1->close();

            // Second update: fire_extinguishers_requests.status
            $query2 = "UPDATE fire_extinguishers_requests SET status = 'In Progress' WHERE id = ?";
            $stmt2 = $conn->prepare($query2);
            $stmt2->bind_param("i", $repair_request_id); // Use repair_request_id
            $stmt2->execute();
            $stmt2->close();

            // Commit the transaction
            $conn->commit();

            // Return response including repair_request_id
            echo json_encode(['status' => 'success', 'repair_request_id' => $repair_request_id]);
        } else {
            throw new Exception("No repair_request_id found.");
        }
    } catch (Exception $e) {
        // Rollback on failure
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }

    $conn->close();
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request']);
}
?>
