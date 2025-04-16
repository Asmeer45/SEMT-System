<?php
include('include/session_check.php');
checkRole('station_master');
?>

<?php

include('side-bar.php');

// Get the username of the user who is adding the product
$enteredBy = isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
$stationName = "";

// Fetch station name from the user table
if ($enteredBy) {
$query = "SELECT station FROM user WHERE user_name = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("s", $enteredBy);
$stmt->execute();
$stmt->bind_result($stationName);
$stmt->fetch();
$stmt->close();
}

// Check if the form was submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from POST request
    $serialNumber = isset($_POST['serialNumber']) ? trim($_POST['serialNumber']) : null;
    $brand = isset($_POST['brand']) ? trim($_POST['brand']) : null;
    $type = isset($_POST['type']) ? trim($_POST['type']) : null;
    $capacity = isset($_POST['capacity']) ? trim($_POST['capacity']) : null;
    $installationDate = isset($_POST['installationDate']) ? trim($_POST['installationDate']) : null;
    $status = isset($_POST['status']) ? trim($_POST['status']) : null;
    $conditions = isset($_POST['condition']) ? trim($_POST['condition']) : null;
    $expiryDate = isset($_POST['expiryDate']) ? trim($_POST['expiryDate']) : null;
    $weight = isset($_POST['weight']) ? trim($_POST['weight']) : null;
    $inspectionFrequency = isset($_POST['inspectionFrequency']) ? trim($_POST['inspectionFrequency']) : null;
    $additionalNotes = isset($_POST['additionalNotes']) ? trim($_POST['additionalNotes']) : null;
    $stationName = isset($_POST['station_name']) ? trim($_POST['station_name']) : null;
    $platform = isset($_POST['platform']) ? trim($_POST['platform']) : null;

    

    // Validate required fields
    if (
        $serialNumber && $brand && $type && $capacity &&
        $installationDate && $status && $conditions && $expiryDate &&
        $weight && $inspectionFrequency && $stationName && $platform && $enteredBy
    ) {

       // Check if the serial number already exists
       $checkSql = "SELECT COUNT(*) FROM fire_extinguishers WHERE serial_number = ?";
       $checkStmt = $conn->prepare($checkSql);
       $checkStmt->bind_param("s", $serialNumber);
       $checkStmt->execute();
       $checkStmt->bind_result($count);
       $checkStmt->fetch();
       $checkStmt->close();

       if ($count > 0) {
           // Serial number already exists
           echo "<script>
                   document.addEventListener('DOMContentLoaded', function() {
                       Swal.fire({
                           icon: 'error',
                           title: 'Duplicate Entry',
                           text: 'The serial number already exists. Please enter a unique serial number.'
                       });
                   });
                 </script>";
       } else {
           // Prepare the SQL query
           $sql = "INSERT INTO fire_extinguishers (
               serial_number, brand, type, capacity, installation_date, 
               status, conditions, expiry_date, weight, inspection_frequency, 
               additional_notes, station_name, platform, enter_by
           ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

           $stmt = $conn->prepare($sql);

           if ($stmt) {
               // Bind parameters
               $stmt->bind_param(
                   "ssssssssssssss",
                   $serialNumber, $brand, $type, $capacity, $installationDate,
                   $status, $conditions, $expiryDate, $weight, $inspectionFrequency,
                   $additionalNotes, $stationName, $platform, $enteredBy
               );

               // Execute and check the insertion
               if ($stmt->execute()) {
                   echo "<script>
                           document.addEventListener('DOMContentLoaded', function() {
                               Swal.fire({
                                   icon: 'success',
                                   title: 'Success',
                                   text: 'Fire extinguisher added successfully!',
                                   showConfirmButton: false,
                                   timer: 2000
                               }).then(function() {
                                   window.location.href = 'add_fire.php'; // Redirect after success
                               });
                           });
                         </script>";
               } else {
                   echo "<script>
                           document.addEventListener('DOMContentLoaded', function() {
                               Swal.fire({
                                   icon: 'error',
                                   title: 'Oops...',
                                   text: 'Failed to add fire extinguisher. Please try again later.'
                               });
                           });
                         </script>";
               }

               // Close the statement
               $stmt->close();
           } else {
               echo "<script>
                       document.addEventListener('DOMContentLoaded', function() {
                           Swal.fire({
                               icon: 'error',
                               title: 'SQL Error',
                               text: 'Error preparing the SQL statement: " . $conn->error . "'
                           });
                       });
                     </script>";
           }
       }
   } else {
       echo "<script>
               document.addEventListener('DOMContentLoaded', function() {
                   Swal.fire({
                       icon: 'warning',
                       title: 'Incomplete Data',
                       text: 'All required fields must be filled out!'
                   });
               });
             </script>";
   }
}

// Fetch data for Stations
$stationsQuery = "SELECT station_name, StationID FROM station"; 
$stationsResult = mysqli_query($conn, $stationsQuery);

// Fetch data for Platforms
$platformsQuery = "SELECT platform_number FROM platform"; 
$platformsResult = mysqli_query($conn, $platformsQuery);


// Close the database connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Fire Extinguishers</title>
  <!-- Include SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 20px;
      background-color: #f9f9f9;
    }

    .form-container {
      max-width: 600px;
      margin: auto;
      background: #fff;
      padding: 20px;
      border-radius: 8px;
      box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
      margin-right: 300px;
      
    }

    .form-group {
      margin-bottom: 15px;
    }

    .form-group label {
      display: block;
      font-weight: bold;
      margin-bottom: 5px;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      height: 40px;
      padding: 8px;
      border: 1px solid #ccc;
      border-radius: 4px;
      box-sizing: border-box;
    }

    .form-group textarea {
      height: 80px;
      resize: none;
    }

    .form-actions {
      text-align: center;
    }

    .form-actions button {
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .form-actions button:hover {
      background-color: #0056b3;
    }


/* Responsive Design */
@media (max-width: 768px) {
  .form-container {
    width: 90%;
    padding: 15px;
  }

  .form-group input,
  .form-group select,
  .form-group textarea {
    height: 35px;
    padding: 6px;
  }
}

@media (max-width: 480px) {
  body {
    padding: 0px;
  }

  .form-container {
    width: 100%;
    padding: 10px;
  }

  .form-group input,
  .form-group select,
  .form-group textarea {
    height: 30px;
    font-size: 14px;
  }

  .form-actions button {
    font-size: 14px;
    padding: 8px;
  }
}

    
  </style>
</head>

<body>
<?php
include('header.php');

?>
  <div class="form-container">
    <h2>Add Fire Extinguisher</h2>
    <form action="add_fire.php" method="post">
      <div class="form-group">
        <label for="serialNumber">Serial Number:</label>
        <input type="text" id="serialNumber" name="serialNumber" required>
      </div>
      <div class="form-group">
      <label for="station-input">Station Name:</label><br>
            <input type="text" name="station_name" id="station-input" value="<?= htmlspecialchars($stationName); ?>" readonly><br><br>
      </div>

      <div class="form-group">
      <label for="platform">Platform Number:</label>
      <select name="platform" id="platform" required>
        <option value="" disabled selected>Select Platform</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
        <option value="12">12</option>
    </select>
      </div>
      
      <div class="form-group">
        <label for="brand">Brand & Model:</label>
        <input type="text" id="brand" name="brand" required>
      </div>
      <div class="form-group">
        <label for="type">Type:</label>
        <select name="type" id="type"  required>
        <option value="" disabled selected>Select Type</option>
        <option value="water">Water</option>
        <option value="foam">Foam</option>
        <option value="co2">Co2</option>
        <option value="powder">Powder</option>
        </select>
      </div>
      <div class="form-group">
        <label for="capacity">Capacity:</label>
        <input type="text" id="capacity" name="capacity" required>
      </div>
      
      <div class="form-group">
        <label for="installationDate">Installation Date:</label>
        <input type="date" id="installationDate" name="installationDate" required>
      </div>
      <div class="form-group">
        <label for="condition">Condition:</label>
        <select id="condition" name="condition" required>
          <option value="good">Good</option>
          <option value="needRepair">Need Repair</option>
        </select>
      </div>
      <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" required>
          <option value="active">Active</option>
          <option value="expired">Expired</option>
        </select>
      </div>
      <div class="form-group">
        <label for="expiryDate">Expiry Date:</label>
        <input type="date" id="expiryDate" name="expiryDate" required>
      </div>
      <div class="form-group">
        <label for="weight">Weight:</label>
        <input type="text" id="weight" name="weight" required>
      </div>
      <div class="form-group">
        <label for="inspectionFrequency">Inspection Frequency:</label>
        <select id="inspectionFrequency" name="inspectionFrequency" required>
          <option value="monthly">Monthly</option>
          <option value="annually">Annually</option>
        </select>
      </div>
      <div class="form-group">
        <label for="additionalNotes">Additional Notes:</label>
        <textarea id="additionalNotes" name="additionalNotes" rows="3"></textarea>
      </div>


     



      <div class="form-actions">
        <button type="submit">Submit</button>
      </div>
    </form>
  </div>

  <script>
//     document.getElementById('station').addEventListener('change', function() {
//     var stationId = this.value;
//     var platformDropdown = document.getElementById('platform');
    
//     // Clear previous platform options
//     platformDropdown.innerHTML = '<option value="" disabled selected>Select Platform</option>';

//     // Make AJAX request to fetch platforms for the selected station
//     var xhr = new XMLHttpRequest();
//     xhr.open('GET', 'fetch_platforms.php?StationID=' + stationId, true);
//     xhr.onload = function() {
//         if (xhr.status === 200) {
//             var platforms = JSON.parse(xhr.responseText);
//             platforms.forEach(function(platform) {
//                 var option = document.createElement('option');
//                 option.value = platform.platform_number;
//                 option.textContent = platform.platform_number;
//                 platformDropdown.appendChild(option);
//             });
//         }
//     };
//     xhr.send();
// });
  </script>
</body>

</html>