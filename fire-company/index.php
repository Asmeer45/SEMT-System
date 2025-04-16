
<?php
include('include/session_check.php');
 checkRole('fire_company');
?>

<?php include('side-bar.php'); 
include('include/header.php');?>

<?php
include('../include/config.php'); // Include your database connection file

// Query to count tasks based on their status
$query = "SELECT status, COUNT(*) as count FROM fire_extinguishers_requests GROUP BY status";
$result = mysqli_query($conn, $query);

$counts = ["Pending" => 0, "In Progress" => 0, "Completed" => 0];
while ($row = mysqli_fetch_assoc($result)) {
    $counts[$row['status']] = $row['count'];
}

// Fetch all pending tasks
$sql = "SELECT id, serial_number, service_type, request_date, priority, type, description, status, station_name, platform_number FROM fire_extinguishers_requests WHERE status = 'pending'";
$result1 = $conn->query($sql);

$sql1 = "SELECT f.id, f.serial_number, f.service_type, f.request_date, f.priority, f.type, f.description, f.status, f.station_name, f.platform_number, o.quotation_attachment FROM fire_extinguishers_requests f 
INNER JOIN fire_extinguishers_quotations o ON f.id = o.repair_request_id
WHERE f.status = 'In Progress'";
$result2 = $conn->query($sql1);

$sql2 = "SELECT f.id, f.serial_number, f.service_type, f.request_date, f.priority, f.type, f.description, f.status, f.station_name, 
f.platform_number, f.scheduled_service_date, f.service_date, f.repair_details, f.cost_estimation, f.quotation_id, f.invoice_id, 
o.invoice_attachment, w.quotation_attachment FROM fire_extinguishers_requests f 
INNER JOIN fire_extinguishers_invoice o ON f.id = o.repair_request_id
    INNER JOIN fire_extinguishers_quotations w ON f.id= w.repair_request_id
WHERE f.status = 'Completed'";
$result3 = $conn->query($sql2);
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <style>
        body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f9;
    margin: 0;
    display: flex;
}

h1{    text-align: center;        }

.container {
    margin-left: 270px;
    width: calc(100% - 270px);
    padding: 20px;
    margin-top:80px;
    margin-bottom:150px;
}
.header {
    text-align: center;
    margin-bottom: 20px;
}
.header h1 {
    margin: 0;
    color: #333;
    text-align: center;

}
.task-summary {
    display: flex;
    justify-content: space-around;
    margin-bottom: 20px;
}
.summary-card {
    text-align: center;
    padding: 20px;
    border-radius: 10px;
    color: #fff;
    font-weight: bold;
}
.summary-card.pending {
    background-color: #ff6b6b;
}
.summary-card.in-progress {
    background-color:rgb(198, 138, 9);
}
.summary-card.completed {
    background-color: #1dd1a1;
}
.task-list {
    margin-top: 20px;
    padding: 35px;
}
.task-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 15px;
    border: 1px solid #ddd;
    border-radius: 8px;
    margin-bottom: 10px;
    background: #f9f9f9;
}
.task-item.pending {
    border-left: 5px solid #ff6b6b;
}
.task-item.in-progress {
    border-left: 5px solid #feca57;
}
.task-item.completed {
    border-left: 5px solid #1dd1a1;
}
.task-item .task-details {
    flex: 1;
}
.task-item .task-details p {
    margin: 5px 0;
}
.task-item .task-actions button {
    padding: 10px 20px;
    border: none;
    border-radius: 8px;
    background-color: #1dd1a1;
    color: #fff;
    cursor: pointer;
}
.task-item .task-actions button:hover {
    background-color: #10ac84;
}
.chart-container {
    width: 300px; /* Set the desired width */
    height: 300px; /* Set the desired height */
    margin: 0 auto; /* Center the chart container */
    display: flex;
    justify-content: center;
    align-items: center;
    margin-top: 30px;
    margin-bottom: 30px;
    padding-top: 50px;
    padding-bottom: 50px;
}

#taskChart {
    width: 300px !important;  /* Force width */
    height: 300px !important; /* Force height *//* Ensure the canvas takes up the full height of the container */
    margin-top: 30px;
    margin-bottom: 30px;
}


table { width: 100%; border-collapse: collapse; margin-top: 20px; margin-left: 30px;}
        th, td { border: 1px solid black; padding: 10px; text-align: left; font-size: 20px; }
        th { background-color: #f4f4f4; }


        /* Mobile responsiveness */
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

            .task-summary {
                flex-direction: column;
                align-items: center;
            }

            .summary-card {
                width: 90%;
                margin-bottom: 10px;
            }

            .chart-container {
                width: 100%;
                margin-top: 20px;
            }

            .task-list {
                padding: 20px;
            }

            .task-item {
                flex-direction: column;
                align-items: flex-start;
                margin-bottom: 15px;
            }

            .task-actions button {
                width: 100%;
                margin-top: 10px;
            }

            table { 
                
                display: block;
                overflow-x: auto;
                white-space: nowrap;
                }
            th, td { font-size: 14px; padding: 8px; }
        }

        /* Small screen (mobile) */
        @media (max-width: 480px) {


            .container {
                margin-left: 0;
                flex-direction: column;
                width: 100%;
            }

             h1 {
                font-size: 16px;
                text-align: center;

            }

            .task-summary {
                flex-direction: column;
                align-items: center;
            }

            .task-item {
                padding: 12px;
                margin-bottom: 10px;
            }

            .task-item .task-actions button {
                width: 100%;
                font-size: 12px;
                padding: 8px;
            }
        }

    </style>
    
</head>
<body>
    <!-- all-task.php -->

<?php
    // include('include/header.php');
    ?>
    <div class="container">
        <h1     text-align: center;>All Tasks</h1>
        <div class="task-summary">
            <div class="summary-card pending">Pending: <span id="pendingCount"><?php echo $counts['Pending']; ?></span></div>
            <div class="summary-card in-progress">In Progress: <span id="inProgressCount"><?php echo $counts['In Progress']; ?></span></div>
            <div class="summary-card completed">Completed: <span id="completedCount"><?php echo $counts['Completed']; ?></span></div>
        </div><br><br>
    <div class="chart-container">
        <canvas id="taskChart"></canvas>
    </div>

    </br></br></br>
    <div class="">
        <h1 style="padding-top: 20px; padding-bottom:10px;">Pending Tasks</h1>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Serial Number</th>
                    <th>Service Type</th>
                    <th>Request Date</th>
                    <th>Priority</th>
                    <th>Station Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result1->num_rows > 0) {
                    while ($row = $result1->fetch_assoc()) {
                        
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['serial_number'] . '</td>';
                        echo '<td>' . $row['service_type'] . '</td>';
                        echo '<td>' . $row['request_date'] . '</td>';
                        echo '<td>' . $row['priority'] . '</td>';
                        echo '<td>'. $row['station_name'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No pending tasks found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>
            </br></br>
    <div class="">
        <h1 style="padding-top: 20px; padding-bottom:10px;">In Progress Tasks</h1>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Serial Number</th>
                    <th>Service Type</th>
                    <th>Request Date</th>
                    <th>Priority</th>
                    <th>Station Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result2->num_rows > 0) {
                    while ($row = $result2->fetch_assoc()) {
                        
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['serial_number'] . '</td>';
                        echo '<td>' . $row['service_type'] . '</td>';
                        echo '<td>' . $row['request_date'] . '</td>';
                        echo '<td>' . $row['priority'] . '</td>';
                        echo '<td>'. $row['station_name'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No progress tasks found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>

            </br></br>
    <div class="">
        <h1 style="padding-top: 20px; padding-bottom:10px;">Completed Tasks</h1>
        <table>
            <thead>
                <tr>
                    <th>Request ID</th>
                    <th>Serial Number</th>
                    <th>Service Type</th>
                    <th>Request Date</th>
                    <th>Priority</th>
                    <th>Station Name</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if ($result3->num_rows > 0) {
                    while ($row = $result3->fetch_assoc()) {
                        
                        echo '<tr>';
                        echo '<td>' . $row['id'] . '</td>';
                        echo '<td>' . $row['serial_number'] . '</td>';
                        echo '<td>' . $row['service_type'] . '</td>';
                        echo '<td>' . $row['request_date'] . '</td>';
                        echo '<td>' . $row['priority'] . '</td>';
                        echo '<td>'. $row['station_name'] . '</td>';
                        echo '</tr>';
                    }
                } else {
                    echo '<tr><td colspan="6">No completed tasks found.</td></tr>';
                }
                ?>
            </tbody>
        </table>
    </div>


    
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var canvas = document.getElementById("taskChart");
        canvas.width = 300; // Explicit width
        canvas.height = 300; // Explicit height

        var ctx = canvas.getContext("2d");
        new Chart(ctx, {
            type: "pie",
            data: {
                labels: ["Pending", "In Progress", "Completed"],
                datasets: [{
                    data: [<?php echo $counts['Pending']; ?>, <?php echo $counts['In Progress']; ?>, <?php echo $counts['Completed']; ?>],
                    backgroundColor: ['#ff6b6b', '#feca57', '#1dd1a1']
                }]
            },
            options: {
                responsive: false, // Disable responsiveness to allow manual sizing
                maintainAspectRatio: false, // Allow custom width and height
                plugins: { 
                    legend: { position: "top" } 
                }
            }
        });
    });
</script>
</body>
</html>