<?php
include('include/session_check.php');
checkRole('station_master');
?>


<?php
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


/* Responsive Design */
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


<?php

// Initialize counts
$totalFireExtinguishers = 0;
$totalBalances = 0;
$pendingQuotationsfire = 0;
$pendingQuotationsscale = 0;

// Assuming you have a session or a variable storing the logged-in user's ID
$user_id = $_SESSION['user_name']; // Ensure this is set when the user logs in

try {
    // Total Fire Extinguishers added by the user
    $stmt = $conn->prepare("SELECT COUNT(*) FROM fire_extinguishers WHERE enter_by = ?");
    $stmt->bind_param("s", $user_id); // Use "s" if enter_by is VARCHAR
    $stmt->execute();
    $stmt->bind_result($totalFireExtinguishers);
    $stmt->fetch();
    $stmt->close();

    // Total Balances added by the user
    $stmt = $conn->prepare("SELECT COUNT(*) FROM weight_scales WHERE enter_by = ?");
    $stmt->bind_param("s", $user_id);
    $stmt->execute();
    $stmt->bind_result($totalBalances);
    $stmt->fetch();
    $stmt->close();

    // Pending Quotations for Fire Extinguishers added by the user
    $stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM fire_extinguishers_quotations fq
    JOIN fire_extinguishers_requests fr ON fq.repair_request_id = fr.id
    WHERE fr.send_by = ? AND fq.payment_status = 'Pending'
");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($pendingQuotationsfire);
$stmt->fetch();
$stmt->close();


    // Pending Quotations for Weight Scales added by the user
    $stmt = $conn->prepare("
    SELECT COUNT(*)
    FROM weight_scales_quotations fq
    JOIN weight_scales_requests fr ON fq.repair_request_id = fr.id
    WHERE fr.send_by = ? AND fq.payment_status = 'Pending'
");
$stmt->bind_param("s", $user_id);
$stmt->execute();
$stmt->bind_result($pendingQuotationsscale);
$stmt->fetch();
$stmt->close();
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

    <div class="dashboard">
        
    <div class="stats">
    <div class="stat-card">
        <h3><i class="fas fa-fire-extinguisher" style="color: #FF5733;"></i> Total Fire Extinguishers</h3>
        <p><?php echo $totalFireExtinguishers; ?></p>
    </div>
    <div class="stat-card">
        <h3><i class="fa-solid fa-scale-balanced" style="color: #4CAF50;"></i> Total Balances</h3>
        <p><?php echo $totalBalances; ?></p>
    </div>
    <div class="stat-card">
        <h3><i class="fas fa-fire-extinguisher" style="color: #FF5733;"></i> Pending Quotations Fire</h3>
        <p><?php echo $pendingQuotationsfire; ?></p>
    </div>

    <div class="stat-card">
        <h3><i class="fa-solid fa-scale-balanced" style="color: #4CAF50;"></i> Pending Quotations Balances</h3>
        <p><?php echo $pendingQuotationsscale; ?></p>
    </div>

</div>     
        <section class="details">
            <div class="table-container">
            <h2 style="display: flex; justify-content: space-between; align-items: center;">
    Fire Extinguishers  
    <button class="btn-add" onclick="location.href='add_fire.php'">Add Fire Extinguishers</button>
</h2>

<?php 


// Assuming $enteredBy contains the user identifier
$enteredBy = $_SESSION['user_name']; // Or another variable storing the user ID

$query = "
    SELECT 
        serial_number,
        brand,
        type,
        capacity,
        location,
        installation_date,
        status,
        conditions,
        expiry_date,
        weight,
        inspection_frequency,
        additional_notes,
        station_name,
        platform
    FROM 
        fire_extinguishers
    WHERE 
        enter_by = ?
    ORDER BY 
        id
";

$stmt = $conn->prepare($query);
$stmt->bind_param("s", $enteredBy);
$stmt->execute();
$result = $stmt->get_result();

if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr>';    
    echo '<th>Serial Number</th>';
    echo '<th>Platform Number</th>';
    echo '<th>Type</th>';
    echo '<th>Capacity</th>';
    echo '<th>Status</th>';
    echo '<th>Action</th>';
    echo '<th></th>';
    echo '</tr>';

    while ($row = mysqli_fetch_assoc($result)) {
        $data = htmlspecialchars(json_encode($row)); 
        echo '<tr>';     
        echo '<td>' . $row['serial_number'] . '</td>';
        echo '<td>' . $row['platform'] . '</td>';    
        echo '<td>' . $row['type'] . '</td>';
        echo '<td>' . $row['capacity'] . '</td>';
        echo '<td class="active">' . $row['status'] . '</td>';
        echo '<td>
            <a href="#" title="View" onclick=\'showPopup(' . $data . ')\'>
            <i class="fas fa-eye" style="font-size: 18px; color: #007bff;"></i></a>
            <a href="edit_fire.php?serial_number=' . urlencode($row['serial_number']) . '&station_name=' . urlencode($row['station_name']) . '&platform=' . urlencode($row['platform']) . '&type=' . urlencode($row['type']) . '" title="edit" style="margin-left: 10px;"><i class="fas fa-edit" style="font-size: 18px; color: #28a745;"></i></a>
            <a href="fire-delete.php?serial_number=' . urlencode($row['serial_number']) . '" title="Delete" style="margin-left: 10px;" onclick="return confirm(\'Are you sure you want to delete this record?\');">
                <i class="fas fa-trash-alt" style="font-size: 18px; color: #dc3545;"></i>
            </a>
        </td>';
        echo '<td>
            <a href="fire-repair-request.php?serial_number=' . urlencode($row['serial_number']) . '&station_name=' . urlencode($row['station_name']) . '&platform=' . urlencode($row['platform']) .  '&type=' . urlencode($row['type']) . '" title="Request" style="margin-left: 10px;">
                <button style="background-color: #ffc107; border: none; padding: 4px 8px; font-size: 14px; cursor: pointer; border-radius: 5px;">Request</button>
            </a>
        </td>';
        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'No data found';
}
?>



<!-- HTML Structure -->
<div class="overlay" id="overlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

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
    content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Station Name</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.station_name}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Platform Number</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.platform}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Serial Number</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.serial_number}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Brand</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.brand}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Type</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.type}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Capacity</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.capacity}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Installation Date</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.installation_date}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Status</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.status}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Condition</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.conditions}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Expiry Date</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.expiry_date}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Weight</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.weight} kg</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Inspection Frequency</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.inspection_frequency}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Additional Notes</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.additional_notes}</td></tr>`;

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





            <div class="table-container">
            <h2 style="display: flex; justify-content: space-between; align-items: center;">
    Balances  
    <button class="btn-add" onclick="location.href='add_balance.php'">Add Balances</button>
</h2>
<?php

// Assuming $enteredBy contains the user identifier
$enteredBy = $_SESSION['user_name']; // Or another variable storing the user ID


$query = "
    SELECT 
        serial_number,
        brand,
        model,
        capacity,
        location,
        installation_date,
        status,
        conditions,
        weight,
        display_type,
        inspection_frequency,
        additional_notes,
        station_name, 
        platform
    FROM 
        weight_scales
    WHERE 
        enter_by = ?
    ORDER BY 
        id
";


$stmt = $conn->prepare($query); // Use prepared statement to prevent SQL injection
$stmt->bind_param("s", $enteredBy); // Bind the user identifier
$stmt->execute();
$result = $stmt->get_result(); // Execute query and get results

// Check if there are any records
if (mysqli_num_rows($result) > 0) {
    echo '<table>';
    echo '<tr>';
    echo '<th>Serial Number</th>';
    echo '<th>Model</th>';
    echo '<th>Display Type</th>';
    echo '<th>Capacity</th>';
    echo '<th>Status</th>';
    // echo '<th>Last Service</th>';
    echo '<th>Action</th>';
    echo '<th></th>';
    echo '</tr>';

    // Loop through each record and display it in the table
    while ($row = mysqli_fetch_assoc($result)) {
        $data = htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8'); 
        echo '<tr>';     
        echo '<td>' . $row['serial_number'] . '</td>';
        echo '<td>' . $row['model'] . '</td>';
        echo '<td>' . $row['display_type'] . '</td>';
        echo '<td>' . $row['capacity'] . '</td>';
        echo '<td class="active">' . $row['status'] . '</td>';
        // echo '<td>' . $row['LastService'] . '</td>';
        echo '<td>
        <a href="#" title="View" onclick=\'showBalancePopup(' . $data . ')\'>
                <i class="fas fa-eye" style="font-size: 18px; color: #007bff;"></i>
            </a>
        <a href="edit_balance.php?serial_number=' . urlencode($row['serial_number']) . '&station_name=' . urlencode($row['station_name']) . '&platform=' . '&model=' . urlencode($row['model']) . '" title="edit" style="margin-left: 10px;"><i class="fas fa-edit" style="font-size: 18px; color: #28a745;"></i></a>
            </a>
      <a href="scale-delete.php?serial_number=' . urlencode($row['serial_number']) . '" title="Delete" style="margin-left: 10px;" onclick="return confirm(\'Are you sure you want to delete this record?\');">
                <i class="fas fa-trash-alt" style="font-size: 18px; color: #dc3545;"></i>
            </a>
      </td>';

      echo '<td>
      <a href="scale-repair-request.php?serial_number=' . urlencode($row['serial_number']) . '&station_name=' . urlencode($row['station_name']) .  '&model=' . urlencode($row['model']) . '" title="Request" style="margin-left: 10px;">
          <button style="background-color: #ffc107; border: none; padding: 4px 8px; font-size: 14px; cursor: pointer; border-radius: 5px;">Request</button>
      </a>
    </td>';

        echo '</tr>';
    }
    echo '</table>';
} else {
    echo 'No data found';
}





// Close database connection
mysqli_close($conn);
?>

<!-- HTML Structure for Balances Popup -->
<div id="balanceOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 999;"></div>

<div id="balancePopupModal" style="display: none; position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: #fff; padding: 20px; border-radius: 10px; z-index: 1000; width: 70%; max-width: 600px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.25);">
    <h3 style="text-align: center;">Balance Details</h3>
    <table id="balancePopupTable" style="width: 100%; border-collapse: collapse;">
        <tbody id="balancePopupContent"></tbody>
    </table>
    <button onclick="closeBalancePopup()" style="margin-top: 10px; padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer;">Close</button>
</div>

<!-- JavaScript for Balances -->
<script>
function showBalancePopup(data) {
    
    // Clear the previous content
    let content = '';
  // Populate the table rows with key-value pairs
  content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Station Name</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.station_name}</td></tr>`;
// content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Platform Number</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.platform}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Serial Number</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.serial_number}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Brand</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.brand}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Type</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.type}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Capacity</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.capacity}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Location</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.location}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Installation Date</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.installation_date}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Status</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.status}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Condition</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.conditions}</td></tr>`;

content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Display Type</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.display_type}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Weight</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.weight} kg</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Power Source</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.power_source}</td></tr>`;

content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Inspection Frequency</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.inspection_frequency}</td></tr>`;
content += `<tr><td style="border: 1px solid #ddd; padding: 8px;"><strong>Additional Notes</strong></td><td style="border: 1px solid #ddd; padding: 8px;">${data.additional_notes}</td></tr>`;

    document.getElementById('balancePopupContent').innerHTML = content;

    // Show the popup and overlay
    document.getElementById('balancePopupModal').style.display = 'block';
    document.getElementById('balanceOverlay').style.display = 'block';
}

function closeBalancePopup() {
    // Hide the popup and overlay
    document.getElementById('balancePopupModal').style.display = 'none';
    document.getElementById('balanceOverlay').style.display = 'none';
}
</script>
        </section>

    </div>

</body>
</html>
