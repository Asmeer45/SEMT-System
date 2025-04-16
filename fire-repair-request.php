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
    <title>Repair Request</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <style>
        /* General Styles */
body {
    font-family: 'Arial', sans-serif;
    background-color: #f7f9fc;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
    margin: 0;
    
    
}

.form-container {
    background: #ffffff;
    padding: 30px 40px;
    border-radius: 15px;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    width: 50%;
    max-width: 500px;
    margin-top: 100px;
    margin-left: 180px;
}

.form-title {
    font-size: 26px;
    font-weight: bold;
    margin-bottom: 25px;
    text-align: center;
    color: #333;
}

/* Equipment Type */
.equipment-type {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.equipment {
    position: relative;
    display: flex;
    align-items: center;
    flex-direction: column;
    gap: 10px;
    padding: 15px;
    border-radius: 12px;
    background: #f0f4fa;
    cursor: pointer;
    width: 48%;
    text-align: center;
    transition: background-color 0.3s ease, border 0.3s ease;
    border: 2px solid transparent;
}

.equipment i {
    font-size: 30px;
    color: #555;
}

.equipment span {
    font-size: 14px;
    font-weight: bold;
    color: #555;
}

.equipment input[type="radio"] {
    display: none;
}

/* Default Icon Colors */
#fire-extinguisher + i {
    color: #ff6b6b; /* Red for Fire Extinguisher */
}
#balance + i {
    color: #4caf50; /* Green for Balance */
}

/* Form Groups */
.form-group {
    margin-bottom: 20px;
}

.form-group select,
.form-group textarea {
    width: 100%;
    padding: 12px 15px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 8px;
    outline: none;
    transition: border 0.3s;
}

.form-group select:focus,
.form-group textarea:focus {
    border-color: #0047ab;
}

/* Priority Level */
.priority-level {
    display: flex;
    justify-content: space-between;
    margin-bottom: 20px;
}

.priority {
    display: flex;
    align-items: center;
    justify-content: center;
    background: #f0f4fa;
    padding: 10px 15px;
    border-radius: 8px;
    cursor: pointer;
    width: 30%;
    transition: all 0.3s;
    text-align: center;
    border: 2px solid transparent;
}

.priority input[type="radio"] {
    display: none;
}

.priority span {
    font-size: 14px;
    font-weight: bold;
    color: #555;
}

.priority input[type="radio"]:checked + span {
    color: #0047ab;
}

.priority:hover {
    background: #e9effb;
    border: 2px solid #0047ab;
}

/* Submit Button */
.submit-btn {
    width: 100%;
    padding: 12px 20px;
    font-size: 16px;
    font-weight: bold;
    color: #fff;
    background-color: #0047ab;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    transition: background 0.3s;
}

.submit-btn:hover {
    background-color: #00357a;
}


/* Labels */
label {
    display: block;
    font-weight: bold;
    margin-bottom: 1px;
    color: #555;
}

/* Input Fields */
input[type="text"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border: 1px solid #ccc;
    border-radius: 4px;
    box-sizing: border-box;
    transition: border-color 0.3s;
    
}

/* Input Focus */
input[type="text"]:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 3px rgba(0, 123, 255, 0.5);
}

/* Readonly Input */
input[readonly] {
    background-color: #f5f5f5;
    color: #777;
    cursor: not-allowed;
}

/* Mobile Responsive Styles */
@media screen and (max-width: 768px) {
    body {
        flex-direction: column;
        align-items: center;
        padding: 0px;
    }

    .form-container {
        width: 90%;
        max-width: 100%;
        margin-left: 0;
        padding: 0px;
        box-shadow: none;
    }

    .equipment-type, 
    .priority-level {
        flex-direction: column;
        gap: 10px;
    }

    .equipment, 
    .priority {
        width: 100%;
    }

    .form-group select, 
    .form-group textarea, 
    .submit-btn {
        font-size: 16px;
        padding: 12px;
    }

    .form-title {
        font-size: 22px;
    }

    label {
        font-size: 14px;
    }
}

/* Even smaller screens (phones) */
@media screen and (max-width: 480px) {
    .form-title {
        font-size: 20px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
        font-size: 14px;
        padding: 10px;
    }

    .submit-btn {
        font-size: 14px;
        padding: 10px;
    }
}

    </style>
</head>
<body>




<?php


// Retrieve data from the query string
$serial_number = isset($_GET['serial_number']) ? $_GET['serial_number'] : '';
$station_name = isset($_GET['station_name']) ? $_GET['station_name'] : '';
$platform = isset($_GET['platform']) ? $_GET['platform'] : '';
$type = isset($_GET['type']) ? $_GET['type'] : '';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $serial_number = isset($_POST['fire-extinguisher-serial']) ? $_POST['fire-extinguisher-serial'] : '';
    $type = isset($_POST['type']) ? $_POST['type'] : '';
    $station_name = isset($_POST['station']) ? $_POST['station'] : '';
    $platform = isset($_POST['Platform']) ? $_POST['Platform'] : '';
    $service = isset($_POST['service']) ? $_POST['service'] : '';
    $description = isset($_POST['description']) ? $_POST['description'] : '';
    $priority = isset($_POST['priority']) ? $_POST['priority'] : '';

    // Get the username of the user who is adding the product
    $sendBy = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;

    // Prepare the SQL query to insert data into the fire_extinguishers table
    $query = "INSERT INTO fire_extinguishers_requests (serial_number,type, station_name, platform_number, service_type, description, priority, request_date, send_by) 
              VALUES (?, ?, ?, ?, ?, ?, ?, NOW(), ?)";

    // Use prepared statements to prevent SQL injection
    if ($stmt = $conn->prepare($query)) {
        $stmt->bind_param('ssssssss', $serial_number, $type, $station_name, $platform, $service, $description, $priority, $sendBy);

        // Execute the query
if ($stmt->execute()) {
    echo "<script>
        Swal.fire({
            title: 'Success!',
            text: 'Maintenance request submitted successfully.',
            icon: 'success',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = window.location.href;
        });
    </script>";
} else {
    echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Failed to submit the maintenance request.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = window.location.href;
        });
    </script>";
}

// Close the statement
$stmt->close();
} else {
    echo "<script>
        Swal.fire({
            title: 'Error!',
            text: 'Database error: Unable to prepare the query.',
            icon: 'error',
            confirmButtonText: 'OK'
        }).then(() => {
            window.location.href = window.location.href;
        });
    </script>";
}

}

?>



<div class="form-container">
    <h1 class="form-title">Fire extinguisher<br>Repair Request Form</h1>
    <form action="#" method="post">

        <!-- Serial Number Field -->
        <div id="fire-extinguisher-serial" class="form-group">
            <label for="fire-extinguisher-serial-input">Serial Number:</label><br>
            <input type="text" name="fire-extinguisher-serial" id="fire-extinguisher-serial-input" value="<?= htmlspecialchars($serial_number); ?>" readonly>
        </div>    

        <label for="type-input">Type:</label><br>
        <input type="text" name="type" id="type-input" value="<?= htmlspecialchars($type); ?>" readonly><br><br>

        <!-- Station Name and Platform Fields -->
        <div class="form-group">
            <label for="station-input">Station Name:</label><br>
            <input type="text" name="station" id="station-input" value="<?= htmlspecialchars($station_name); ?>" readonly><br><br>

            <label for="Platform-input">Platform Number:</label><br>
            <input type="text" name="Platform" id="Platform-input" value="<?= htmlspecialchars($platform); ?>" readonly><br><br>

        <label for="service">Service Type:</label><br>
            <select name="service" id="service" required>
                <option value="" disabled selected>Service Type</option>
                <option value="Inspection">Inspection</option>
                <option value="Recharging">Refilling</option>
                <option value="Repair">Repair</option>
            </select>

        </div>

            <!-- Description -->
            <label for="description">Description:</label><br>
            <div class="form-group">
                <textarea name="description" id="description" rows="4" placeholder="Describe the issue in detail..." required></textarea>
            </div>

            <!-- Priority Level -->
            <label name="urgency">Urgency</label><br>
<div class="priority-level">

    <label for="low" class="priority">
        <input type="radio" id="low" name="priority" value="low" checked>
        <span>Low</span>
    </label>
    <label for="medium" class="priority">
        <input type="radio" id="medium" name="priority" value="medium">
        <span>Medium</span>
    </label>
    <label for="high" class="priority">
        <input type="radio" id="high" name="priority" value="high">
        <span>High</span>
    </label>
</div>

<!-- Submit Button -->
<button type="submit" class="submit-btn">Submit Repair Request</button>


    

    <script>    

/*change color when select  the low, medium, high*/
document.addEventListener('DOMContentLoaded', function () {
    const priorityLabels = document.querySelectorAll('.priority');
    
    // Function to update background color based on the selected radio button
    function updateBackgroundColor() {
        // Reset background color for all labels
        priorityLabels.forEach(label => label.style.backgroundColor = '#f0f4fa');
        
        // Find the selected radio button
        const selectedRadio = document.querySelector('input[name="priority"]:checked');
        const selectedLabel = selectedRadio ? selectedRadio.closest('label') : null;

        // Apply color based on selected radio button value
        if (selectedLabel) {
            switch (selectedRadio.value) {
                case 'low':
                    selectedLabel.style.backgroundColor = '#e0ffe0'; // Light green for low priority
                    break;
                case 'medium':
                    selectedLabel.style.backgroundColor = '#ffffe0'; // Light yellow for medium priority
                    break;
                case 'high':
                    selectedLabel.style.backgroundColor = '#ffe0e0'; // Light red for high priority
                    break;
            }
        }
    }

    // Add event listener to radio buttons to update background color on change
    const radios = document.querySelectorAll('input[name="priority"]');
    radios.forEach(radio => {
        radio.addEventListener('change', updateBackgroundColor);
    });

    // Call the function initially to set the default color
    updateBackgroundColor();
});


    </script>
</body>
</html>
