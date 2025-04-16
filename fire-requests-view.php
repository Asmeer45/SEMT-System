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

        .details,
        .history,
        .maintenance,
        .quick-actions {
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

        table th,
        table td {
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

/* Responsive Design */
@media (max-width: 768px) {
    form {
        flex-direction: column;
    }
    
    input, select, textarea, button {
        width: 100%;
    }
    
    table {
                display: block;
                overflow-x: auto;
                white-space: nowrap;
            }
    th, td {
        font-size: 14px;
    }
}

@media (max-width: 480px) {

    .table-container {
        width: 95%;
        padding: 15px;
        margin-right: 0;
    }
    
    h2 {
        font-size: 18px;
    }
    
    button {
        font-size: 14px;
        padding: 8px;
    }
}
    </style>
</head>

<body>
    <div class="dashboard">

        <section class="details">
            <div class="table-container">
                <h2 style="display: flex; justify-content: space-between; align-items: center;">
                    Fire Extinguishers Requests

                </h2>
                <?php


// Assuming $enteredBy contains the user identifier
$enteredBy = $_SESSION['user_name'];

                $query = "
     SELECT 
         fe.id,
         fe.serial_number,
         fe.type,
         fe.service_type,
         fe.request_date,
         fe.scheduled_service_date,
         fe.status,
         fe.description,
         fe.priority,
         fe.service_date,
         fe.repair_details,
         fe.cost_estimation,
         fe.quotation_id,
         fe.invoice_id,
         fe.attachments,
         fe.station_name,
         fe.platform_number
     FROM 
         fire_extinguishers_requests fe

          WHERE 
        fe.send_by = ?

     ORDER BY 
         fe.id
";
$stmt = $conn->prepare($query); // Use prepared statement to prevent SQL injection
$stmt->bind_param("s", $enteredBy); // Bind the user identifier
$stmt->execute();
$result = $stmt->get_result(); // Execute query and get results

               
if (mysqli_num_rows($result) > 0) {
                    // Check if there are any records
                    if (mysqli_num_rows($result) > 0) {
                        echo '<table border="1">';
                        echo '<tr>';
                        echo '<th>Request Id</th>';
                        echo '<th>Serial Number</th>';
                        echo '<th>Type</th>';
                        echo '<th>Service Type</th>';
                        echo '<th>Request Date</th>';
                        echo '<th>Status</th>';
                        echo '<th>Action</th>';
                        echo '</tr>';

                        while ($row = mysqli_fetch_assoc($result)) {
                            $data = htmlspecialchars(json_encode($row));
                            echo '<tr>';
                            echo '<td>' . $row['id'] . '</td>';
                            echo '<td>' . $row['serial_number'] . '</td>';
                            echo '<td>' . $row['type'] . '</td>';
                            echo '<td>' . $row['service_type'] . '</td>';
                            echo '<td>' . $row['request_date'] . '</td>';
                            // Set color based on status
                            $statusColor = '';
                            if ($row['status'] == 'Pending') {
                                $statusColor = 'red';
                            } elseif ($row['status'] == 'In Progress') {
                                $statusColor = 'orange';
                            } elseif ($row['status'] == 'Completed') {
                                $statusColor = 'green';
                            }

                            // Display status with color
                            echo '<td style="color:' . $statusColor . '; font-weight: bold;">' . $row['status'] . '</td>';

                            echo '<td>
            <center>
            <a href="#" title="View" onclick=\'showPopup(' . $data . ')\'>
                    <i class="fas fa-eye" style="font-size: 18px; color: #007bff;"></i>
                </a>
            <a href="#" title="Delete" onclick="deleteRow(' . $row['id'] . ')">
                    <i class="fas fa-trash" style="font-size: 18px; color: #ff0000;"></i>
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
                    <h3 style="text-align: center;">Fire Extinguishers Details</h3>
                    <table id="popupTable" style="width: 100%; border-collapse: collapse;">
                        <tbody id="popupContent"></tbody>
                    </table>
                    <button onclick="closePopup()" style="margin-top: 10px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Close</button>
                </div>

                <script>
                    function showPopup(data) {
                        let content = '';
                        content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Request Id</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.id}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Serial Number</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.serial_number}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Type</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.type}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Service Type</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.service_type}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Request Date</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.request_date}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Status</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.status}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Description</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.description}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Priority</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.priority}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Station Name</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.station_name}</td></tr>`;
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Platform Number</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.platform_number}</td></tr>`;
                    

                        document.getElementById('popupContent').innerHTML = content;

                        document.getElementById('popupModal').style.display = 'block';
                        document.getElementById('overlay').style.display = 'block';
                    }

                   


                    function deleteRow(id) {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You won't be able to revert this!",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#d33",
                            cancelButtonColor: "#3085d6",
                            confirmButtonText: "Yes, delete it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                // Proceed with deletion
                                fetch(`delete_record_fire_extinguishers_requests.php?id=${id}`, {
                                        method: 'GET', // Use GET method as per your original code
                                    })
                                    .then(response => response.text())
                                    .then(data => {
                                        if (data === 'success') {
                                            Swal.fire({
                                                title: "Deleted!",
                                                text: "The record has been deleted.",
                                                icon: "success",
                                                confirmButtonColor: "#3085d6",
                                            }).then(() => {
                                                location.reload(); // Reload the page after successful deletion
                                            });
                                        } else {
                                            Swal.fire({
                                                title: "Error!",
                                                text: "Failed to delete the record.",
                                                icon: "error",
                                                confirmButtonColor: "#d33",
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                        Swal.fire({
                                            title: "Error!",
                                            text: "An error occurred while deleting the record.",
                                            icon: "error",
                                            confirmButtonColor: "#d33",
                                        });
                                    });
                            }
                        });
                    }

                    function updateRequestStatus(id) {
                        Swal.fire({
                            title: "Are you sure?",
                            text: "You want to update the request status to 'In Progress'?",
                            icon: "warning",
                            showCancelButton: true,
                            confirmButtonColor: "#3085d6",
                            cancelButtonColor: "#d33",
                            confirmButtonText: "Yes, update it!"
                        }).then((result) => {
                            if (result.isConfirmed) {
                                fetch(`update_request_status.php?id=${id}`, {
                                        method: 'GET',
                                    })
                                    .then(response => response.text())
                                    .then(data => {
                                        if (data === 'success') {
                                            Swal.fire({
                                                title: "Updated!",
                                                text: "The request status has been updated to 'In Progress'.",
                                                icon: "success",
                                                confirmButtonColor: "#3085d6",
                                            }).then(() => {
                                                location.reload(); // Reload the page after successful update
                                            });
                                        } else {
                                            Swal.fire({
                                                title: "Error!",
                                                text: "Failed to update the request status.",
                                                icon: "error",
                                                confirmButtonColor: "#d33",
                                            });
                                        }
                                    })
                                    .catch(error => {
                                        console.error("Error:", error);
                                        Swal.fire({
                                            title: "Error!",
                                            text: "An error occurred while updating the request status.",
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