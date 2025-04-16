

<?php
include('include/session_check.php');
checkRole('scale_company');
?>

<?php
  include('side-bar.php');?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Tasks</title>
    <style>
         body { font-family: Arial, sans-serif; }
        .container {
    margin-left: 270px;
    width: calc(100% - 270px);
    padding: 20px;
    margin-top: 80px;
    margin-bottom:150px;}
        h1{    text-align: center;        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-left:10px; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background-color: #f4f4f4; }
        .action-button { padding: 5px 10px; margin: 5px; border: none; border-radius: 5px; cursor: pointer; }
        .action-button1 {background-color: #007BFF; color: #fff; padding: 5px 10px; margin: 5px; border: none; border-radius: 5px; cursor: pointer; }
        .action-button1:hover { background-color: #0056b3; }
        .blue-button { background-color: #007BFF; color: #fff; }
        .blue-button:hover { background-color: #0056b3; }
        .green-button { background-color: #28a745; color: #fff; }
        .green-button:hover { background-color: #218838; }
        .modal { display: none; position: fixed; z-index: 1; ; left: 0; top: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.4); }
        .modal-content { background-color: #fff; margin: 10% auto;line-height: 2; padding: 20px; border: 1px solid #888; width: 50%; border-radius: 5px; }
        .close { float: right; font-size: 28px; font-weight: bold; cursor: pointer; }


                        /* Mobile Responsive Styles */
                        @media (max-width: 768px) {

body {
flex-direction: column;
align-items: center;
padding: 0px;
}
.container {
width: 90%;
max-width: 100%;
margin-left: 0;
padding: 0px;
box-shadow: none;
}

table { 

display: block;
overflow-x: auto;
white-space: nowrap;
}
th, td { font-size: 14px; padding: 8px; }

.action-button1, .blue-button, .green-button {
padding: 8px 15px;
font-size: 14px;
}

.action-button {
padding: 5px 8px;
font-size: 14px;
}

.modal-content {
width: 90%;
padding: 10px;
}

.close {
font-size: 24px;
}

}

@media (max-width: 480px) {
.container {
margin-left: 0;
flex-direction: column;
width: 100%;
}
h1{
font-size:18px;
}
table { 

display: block;
overflow-x: auto;
white-space: nowrap;
padding:2px;
}
th, td { font-size: 14px; padding: 8px; }


.action-button1, .blue-button, .green-button {
padding: 8px 12px;
font-size: 12px;
}

.action-button {
padding: 4px 6px;
font-size: 12px;
}

.modal-content {
margin-top:130px;
width: 100%;
padding: 8px;
}

.close {
font-size: 20px;
}
}
    </style>
</head>
<body>
    <?php 
  
    include('include/header.php');
    include('../include/config.php');

    // Query to fetch pending tasks
    $sql = "SELECT id, serial_number, service_type, request_date, priority, model, description, status, station_name, platform_number FROM weight_scales_requests WHERE status = 'pending'";
    $result = $conn->query($sql);


    // Fetch all request IDs that exist in the fire_quotations table
$quotation_sql = "SELECT repair_request_id FROM weight_scales_quotations";
$quotation_result = $conn->query($quotation_sql);
$quoted_requests = [];
while ($row = $quotation_result->fetch_assoc()) {
    $quoted_requests[] = $row['repair_request_id'];
}
    ?>

    <div class="container">
        <div class="header">
            <h1>Pending Tasks</h1>
        </div>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Serial Number</th>
                    <th>Service Type</th>
                    <th>Request Date</th>
                    <th>Priority</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php 
                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $buttonClass = in_array($row['id'], $quoted_requests) ? 'green-button' : 'blue-button';
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['serial_number'] . '</td>';
                        echo '<td>' . $row['service_type'] . '</td>';
                        echo '<td>' . $row['request_date'] . '</td>';
                        echo '<td>' . $row['priority'] . '</td>';
                        echo '<td>
<button class="action-button1" onclick="openModal(' . $row['id'] . ', \'' . $row['serial_number'] . '\', \'' . $row['service_type'] . '\', \'' . $row['request_date'] . '\', \'' . $row['priority'] . '\',\'' 
                                    . $row['model'] . '\',\'' . $row['description'] . '\',\'' . $row['status'] . '\',\'' . $row['station_name'] . '\',\'' . $row['platform_number'] . '\')">View</button>
                                <a href="scale-quotations.php?request_id=' . $row['id'] . '">
                                    <button class="action-button ' . $buttonClass . '">Send Quotations</button>
                                </a>
                              </td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No pending tasks found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

    <!-- Modal Structure -->
    <div id="taskModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Task Details</h2>
            <p><strong>Request ID:</strong> <span id="modalRequestId"></span></p>
            <p><strong>Serial Number:</strong> <span id="modalSerialNumber"></span></p>
            <p><strong>Service Type:</strong> <span id="modalServiceType"></span></p>
            <p><strong>Request Date:</strong> <span id="modalRequestDate"></span></p>
            <p><strong>Priority:</strong> <span id="modalPriority"></span></p>
            <p><strong>Model:</strong> <span id="modalModel"></span></p>
            <p><strong>Description:</strong> <span id="modalDescription"></span></p>
            <p><strong>Status:</strong> <span id="modalStatus"></span></p>
            <p><strong>Station Name:</strong> <span id="modalStationName"></span></p>
            <p><strong>Platform Number:</strong> <span id="modalPlatformNumber"></span></p>


            <button class="action-button1" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        function openModal(id, serialNumber, serviceType, requestDate, priority, model, description, status, stationName, platformNumber) {
            document.getElementById('modalRequestId').innerText = id;
            document.getElementById('modalSerialNumber').innerText = serialNumber;
            document.getElementById('modalServiceType').innerText = serviceType;
            document.getElementById('modalRequestDate').innerText = requestDate;
            document.getElementById('modalPriority').innerText = priority;
            document.getElementById('modalModel').innerText = model;
            document.getElementById('modalDescription').innerText = description;
            document.getElementById('modalStatus').innerText = status;
            document.getElementById('modalStationName').innerText = stationName;
            document.getElementById('modalPlatformNumber').innerText = platformNumber;
            document.getElementById('taskModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('taskModal').style.display = 'none';
        }
    </script>
</body>
</html>
