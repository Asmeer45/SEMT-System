
<?php
include('include/session_check.php');
checkRole('station_master');
include('side-bar.php');
include('header.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMT Dashboard</title>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f9;
            color: #333;
        }

        .dashboard {
            padding: 20px;
        }

        .stat-card {
            flex: 1;
            margin: 0 10px;
            background: #fff;
            padding: 20px;
            text-align: center;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .details, .history, .maintenance, .quick-actions {
            margin: 20px 0;
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .table-container {
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th, table td {
            padding: 10px;
            border: 1px solid #ddd;
            text-align: left;
        }

        .active {
            color: green;
        }

        .maintenance {
            color: orange;
        }

        button {
            padding: 10px 15px;
            background: #0047ab;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #002c7a;
        }

        @media (max-width: 768px) {
            .stats {
                flex-direction: column;
            }

            .stat-card {
                margin-bottom: 20px;
            }

            table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }

            th, td {
                font-size: 0.9rem;
                padding: 8px;
            }

            h2 {
                font-size: 1.2rem;
                flex-direction: column;
                align-items: flex-start;
            }

            .btn-add {
                margin-top: 10px;
                width: 100%;
                text-align: center;
            }
        }

        @media (max-width: 480px) {
            .stat-card h3 {
                font-size: 1rem;
            }

            .stat-card p {
                font-size: 1.2rem;
            }

            th, td {
                font-size: 0.8rem;
                padding: 6px;
            }
        }
    </style>
</head>

<body>
<div class="dashboard">

<section class="details">
            <div class="table-container">
            <h2 style="display: flex; justify-content: space-between; align-items: center;">
            Fire Extinguishers Quotations 
</h2>
<?php




 // Assuming $enteredBy contains the user identifier
 $enteredBy = $_SESSION['user_name'];

$query = "
     SELECT 
         fq.id,
         fq.repair_request_id,
         fq.quotation_date,
         fq.amount,
         fq.quotation_attachment,
         fq.remarks,
         fq.approved_by,
         fq.approval_date,
         fq.payment_status
     FROM 
         fire_extinguishers_quotations fq
         JOIN 
        fire_extinguishers_requests rr ON fq.repair_request_id = rr.id
    WHERE 
        rr.send_by = '$enteredBy'  -- Show only the user's requested quotations
     ORDER BY 
         fq.id
";

$result = mysqli_query($conn, $query);  // Execute query

if ($result) {
    // Check if there are any records
    if (mysqli_num_rows($result) > 0) {
        echo '<table border="1">';
        echo '<tr>';    
        echo '<th>Repair Request ID</th>';
        echo '<th>Quotation Date</th>';
        echo '<th>Amount</th>';
        echo '<th>Attachment</th>';
        echo '<th>Remarks</th>';
        echo '<th>Payment Status</th>';
        echo '</tr>';

        while ($row = mysqli_fetch_assoc($result)) {
            $data = htmlspecialchars(json_encode($row)); 
            echo '<tr>';     
            echo '<td>' . $row['repair_request_id'] . '</td>';
            echo '<td>' . $row['quotation_date'] . '</td>';
            echo '<td>' . $row['amount'] . '</td>';
            
            // Ensure the file path is correctly formed
    $dbPath = $row['quotation_attachment']; // Path from database
    $filePath = realpath(__DIR__ . '/' . str_replace('../', '', $dbPath)); // Absolute path for checking
    $fileUrl = 'uploads/' . basename($dbPath); // Correct URL for display

    // Display PDF link if file exists
    echo '<td>';
    if (!empty($dbPath) && file_exists($filePath)) {
        echo '<a href="' . $fileUrl . '" target="_blank">Open PDF</a>';
    } else {
        echo '<span style="color: red;">File Not Found</span>';
    }
    echo '</td>';

            echo '<td>' . $row['remarks'] . '</td>';
                                            // Set color based on status
$statusColor = '';
if ($row['payment_status'] == 'Pending') {
    $statusColor = 'red';
} elseif ($row['payment_status'] == 'In Progress') {
    $statusColor = 'orange';
} elseif ($row['payment_status'] == 'Paid') {
    $statusColor = 'rgb(11, 158, 75)';
}

// Display status with color
echo '<td style="color:' . $statusColor . '; font-weight: bold;">' . $row['payment_status'] . '</td>';

            echo '<td>
            <center>
            <a href="#" title="View" onclick="showPopup(' . $data . ')" 
           style="display: inline-block; margin-right: 10px;">
            <i class="fas fa-eye" style="font-size: 18px; color: #007bff;"></i>
        </a>

        <a href="#" title="Update Payment Status" onclick="updatePaymentStatus(' . $row['id'] . ')" 
           style="display: inline-block; padding: 6px 12px; background-color:rgb(11, 158, 75); color: white; 
                  text-decoration: none; border-radius: 5px; font-weight: bold; margin-left: 10px;">
            Approve
        </a>

        
            </center>
          </td>';
            echo '</tr>';
        }
        echo '</table>';
    } else {
        echo 'No data found';
    }
} else {
    echo "Error executing query: " . mysqli_error($conn);
}

// Close database connection
mysqli_close($conn);
?>

<div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

<div id="popupModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border-radius: 10px; z-index: 1000; width: 70%; max-width: 600px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);">
    <h3 style="text-align: center;">Fire Extinguishers Quotattions</h3>
    <table id="popupTable" style="width: 100%; border-collapse: collapse;">
        <tbody id="popupContent"></tbody>
    </table>
    <button onclick="closePopup()" style="margin-top: 10px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Close</button>
</div>

<script>
function showPopup(data) {
    let content = '';
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>ID</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.id}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Repair Request ID</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.repair_request_id}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Quotation date</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.quotation_date}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Amount</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.amount}</td></tr>`;
    // content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Quotation A</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.quotation_attachment}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Remark</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.remarks}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Approval Date</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.approval_date}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Payment Status</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.payment_status}</td></tr>`;
     // Add PDF Link (Only if a valid attachment exists)
    if (data.quotation_attachment && data.quotation_attachment !== "null") {
        let pdfUrl = data.quotation_attachment.replace("../", ""); // Adjust the path if needed
        content += `<tr><td style="border: 1px solid #ddd; padding: 8px;">
                        <strong>Quotation PDF:</strong></td><td style="border: 1px solid #ddd; padding: 8px;">
                        <a href="${pdfUrl}" target="_blank" style="color: blue; text-decoration: underline;">View PDF</a>
                    </td></tr>`;
    } else {
        content += `<tr><td colspan="2" style="text-align: center; color: red; padding: 10px;">No PDF available</td></tr>`;
    }

    document.getElementById('popupContent').innerHTML = content;

    document.getElementById('popupModal').style.display = 'block';
    document.getElementById('overlay').style.display = 'block';
}

function updatePaymentStatus(id) {
    Swal.fire({
        title: "Are you sure?",
        text: "You want to update the payment status to 'In Progress'?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes, update it!"
    }).then((result) => {
        if (result.isConfirmed) {
            // Proceed with updating the payment_status
            fetch(`update_payment_status.php?id=${id}`, {
                method: 'GET', // Using GET, but POST is preferred for updates
            })
            .then(response => response.json())  // Parse the JSON response
            .then(data => {
                if (data.status === 'success') {  // Check the 'status' key
                    Swal.fire({
                        title: "Updated!",
                        text: "The payment status has been updated to 'In Progress'.",
                        icon: "success",
                        confirmButtonColor: "#3085d6",
                    }).then(() => {
                        location.reload(); // Reload the page after successful update
                    });
                } else {
                    Swal.fire({
                        title: "Error!",
                        text: data.message || "Failed to update the payment status.",
                        icon: "error",
                        confirmButtonColor: "#d33",
                    });
                }
            })
            .catch(error => {
                console.error("Error:", error);
                Swal.fire({
                    title: "Error!",
                    text: "An error occurred while updating the payment status.",
                    icon: "error",
                    confirmButtonColor: "#d33",
                });
            });
        }
    });
}


function closePopup() {
    document.getElementById('popupModal').style.display = 'none';
    document.getElementById('overlay').style.display = 'none';
}
</script>
</div>
</body>
</html>
