<?php
include('include/session_check.php');
checkRole('station_master');
?>

<?php

include('side-bar.php');

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance-Scale</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- SweetAlert -->
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


        /* SweetAlert2 custom styles */
        .swal2-popup {
            border-radius: 10px;
            padding: 20px;
            font-family: Arial, sans-serif;
            font-size: 16px;
        }

        /* Styling for the input fields */
        .swal2-input {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 14px;
        }

        /* Styling for labels */
        label {
            font-weight: bold;
            margin-bottom: 5px;
            display: block;
        }

        /* Styling for the service type dropdown */
        #serviceType {
            height: 35px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            padding: 5px;
        }

        /* Styling for the maintenance date input */
        #maintenanceDate {
            height: 35px;
            background-color: #f8f9fa;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
            padding: 5px;
        }

        /* Styling for the confirm and cancel buttons */
        .swal2-confirm,
        .swal2-cancel {
            padding: 10px 20px;
            font-size: 16px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
        }

        /* Custom confirm button color */
        .swal2-confirm {
            background-color: #28a745;
            color: white;
        }

        /* Custom cancel button color */
        .swal2-cancel {
            background-color: #f44336;
            color: white;
        }

        /* Custom confirm button on hover */
        .swal2-confirm:hover {
            background-color: #218838;
        }

        /* Custom cancel button on hover */
        .swal2-cancel:hover {
            background-color: #d32f2f;
        }

        /* Styling for the serial number field (readonly) */
        #serialNumber {
            background-color: #f1f1f1;
            color: #555;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            width: 350px;
            text-align: center;
            position: relative;
        }

        .close {
            position: absolute;
            top: 10px;
            right: 15px;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
        }

        .form-group {
            margin-bottom: 10px;
            text-align: left;
        }

        label {
            font-weight: bold;
        }

        input,
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px;
            cursor: pointer;
            width: 100%;
            border-radius: 4px;
        }

        button:hover {
            background-color: #218838;
        }
    </style>

</head>

<body>
<div class="dashboard">

    <section class="details">
        <div class="table-container">
            <h2 style="display: flex; justify-content: space-between; align-items: center;">
            Weight Scales Maintenance

            </h2>

            <?php


            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $serial_number = $_POST['serialNumber'];
                $service_type = $_POST['serviceType'];
                $maintenance_date = $_POST['maintenanceDate'];

                // Calculate the next scheduled maintenance date (3 months later)
                $next_scheduled_maintenance = date('Y-m-d', strtotime($maintenance_date . ' +3 months'));

                // Fetch item_id based on the serial_number
                $query = "SELECT id FROM weight_scales WHERE serial_number = ?";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("s", $serial_number);
                $stmt->execute();
                $result = $stmt->get_result();
                $row = $result->fetch_assoc();

                if ($row) {
                    $item_id = $row['id'];

                    // Insert into fire_extinguishers_history with next scheduled maintenance date
                    $insertQuery = "INSERT INTO weight_scales_history (item_id, maintenance_type, maintenance_date, next_scheduled_maintenance) VALUES (?, ?, ?, ?)";
                    $insertStmt = $conn->prepare($insertQuery);
                    $insertStmt->bind_param("isss", $item_id, $service_type, $maintenance_date, $next_scheduled_maintenance);

                    if ($insertStmt->execute()) {
                        echo "<script>
                Swal.fire({
                    title: 'Success!',
                    text: 'Maintenance record saved successfully.',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    window.location.href = 'maintenance-scale.php'; // Redirect if needed
                });
            </script>";
                    } else {
                        echo "<script>
                Swal.fire({
                    title: 'Error!',
                    text: 'Failed to save record. Try again.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            </script>";
                    }
                } else {
                    echo "<script>
            Swal.fire({
                title: 'Error!',
                text: 'Serial number not found!',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        </script>";
                }
            }


            include('header.php');

            // Assuming $enteredBy contains the user identifier
            $enteredBy = $_SESSION['user_name']; // Or another variable storing the user ID


    

$query = "
SELECT 
    fe.serial_number,
    fe.model,
    fe.capacity,
    fe.status,
    feh.maintenance_date,
    feh.next_scheduled_maintenance
FROM 
    weight_scales fe
LEFT JOIN 
    weight_scales_history feh ON fe.id = feh.item_id
WHERE 
    fe.enter_by = ?
ORDER BY 
    fe.id
";

            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $enteredBy);
            $stmt->execute();
            $result = $stmt->get_result();

            if (mysqli_num_rows($result) > 0) {
                echo '<table>';
                echo '<tr>';
                echo '<th>Serial Number</th>';
                echo '<th>Model</th>';
                echo '<th>Capacity</th>';
                echo '<th>Status</th>';
                echo '<th>Maintenance Date</th>';
                echo '<th>Next Scheduled Maintenance</th>';
                echo '<th>Action</th>';
                echo '</tr>';

                while ($row = mysqli_fetch_assoc($result)) {
                    $data = htmlspecialchars(json_encode($row));
                    echo '<tr>';
                    echo '<td>' . $row['serial_number'] . '</td>';
                    echo '<td>' . $row['model'] . '</td>';
                    echo '<td>' . $row['capacity'] . '</td>';
                    echo '<td class="active">' . $row['status'] . '</td>';
                    echo '<td>' . ($row['maintenance_date'] ?? 'N/A') . '</td>';
                    echo '<td>' . ($row['next_scheduled_maintenance'] ?? 'N/A') . '</td>';
                    echo '<td>
            <a href="#" title="View" onclick=\'showPopup(' . json_encode($row, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) . ')\'>
        <i class="fas fa-eye" style="font-size: 18px; color: #007bff;"></i>
    </a>
            <a href="#" title="Confirm" onclick="openModal(\'' . htmlspecialchars($row['serial_number'], ENT_QUOTES) . '\')">
                <i class="fas fa-check-circle" style="font-size: 18px; color: #28a745;"></i>
            </a>
        </td>';
                    echo '</tr>';
                }
                echo '</table>';
            } else {
                echo 'No data found';
            }
            ?>

            <!-- Modal -->
            <div id="confirmModal" class="modal">
                <div class="modal-content">
                    <span class="close" onclick="closeModal()">&times;</span>
                    <h3>Maintenance Details</h3>
                    <form id="maintenanceForm" method="POST">
                        <div class="form-group">
                            <label for="serialNumber">Serial Number</label>
                            <input type="text" id="serialNumber" name="serialNumber" required readonly>
                        </div>
                        <div class="form-group">
                            <label for="serviceType">Service Type</label>
                            <select name="serviceType" id="serviceType" required>
                <option value="" disabled selected>Service Type</option>
                <option value="Inspection">Inspection</option>
                <option value="Recharging">Recharging</option>
                <option value="Repair">Calibration</option>
                <option value="Repair">Repair</option>
            </select>
                        </div>
                        <div class="form-group">
                            <label for="maintenanceDate">Maintenance Date</label>
                            <input type="date" id="maintenanceDate" name="maintenanceDate" required>
                        </div>
                        <button type="submit">Submit</button>
                    </form>
                </div>
            </div>




            <!-- HTML Structure -->
            <div id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

            <div id="popupModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border-radius: 10px; z-index: 1000; width: 70%; max-width: 600px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);">
                <h3 style="text-align: center;">Fire Extinguishers Details</h3>
                <table id="popupTable" style="width: 100%; border-collapse: collapse;">

                    <tbody id="popupContent"></tbody>
                </table>
                <button onclick="closePopup()" style="margin-top: 10px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Close</button>
            </div>

            <!-- JavaScript -->
            <script>
                function showPopup(data) {
                    // Clear the previous content
                    let content = '';
                    // Populate the table rows with key-value pairs
                    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Serial Number</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.serial_number}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Model</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.model}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Capacity</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.capacity}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Status</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.status}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Maintenance Date</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.maintenance_date || 'N/A'}</td></tr>`;
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Next Scheduled Maintenance</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.next_scheduled_maintenance || 'N/A'}</td></tr>`;

    document.getElementById('popupContent').innerHTML = content;

                    // Show the popup and overlay
                    document.getElementById('popupModal').style.display = 'block';
                    document.getElementById('overlay').style.display = 'block';
                }

                function closePopup() {
                    // Hide the popup and overlay
                    document.getElementById('popupModal').style.display = 'none';
                    document.getElementById('overlay').style.display = 'none';
                }
            </script>

            <script>
                function openModal() {
                    document.getElementById("confirmModal").style.display = "flex";
                }

                function closeModal() {
                    document.getElementById("confirmModal").style.display = "none";
                }

                function openModal(serialNumber) {
                    document.getElementById("serialNumber").value = serialNumber; // Set serial number in modal input
                    document.getElementById("confirmModal").style.display = "flex";
                }

                function closeModal() {
                    document.getElementById("confirmModal").style.display = "none";
                }
            </script>



    </section>
            </div>
</body>

</html>