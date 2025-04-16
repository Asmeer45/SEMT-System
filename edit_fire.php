
<?php
include('include/session_check.php');
checkRole('station_master');
?>

<?php
include('include/config.php');

// Check if the form is submitted via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect form data
    $serial_number = $_POST['serial_number'];
    $brand = $_POST['brand'];
    $type = $_POST['type'];
    $capacity = $_POST['capacity'];
    $location = $_POST['location'];
    $installation_date = $_POST['installationDate'];
    $condition = $_POST['condition'];
    $status = $_POST['status'];
    $expiry_date = $_POST['expiryDate'];
    $weight = $_POST['weight'];
    $inspection_frequency = $_POST['inspectionFrequency'];
    $additional_notes = $_POST['additionalNotes'];
    $station_id = $_POST['station'];
    $platform_id= $_POST['platform'];

    // Validate if required fields are present
    if ($serial_number && $brand && $type && $capacity && $location && $installation_date &&
        $condition && $status && $expiry_date && $weight && $inspection_frequency && $station_id && $platform_id) {
        
        // Prepare the SQL UPDATE query
        $query = "UPDATE fire_extinguishers SET
                    brand = ?, type = ?, capacity = ?, location = ?, installation_date = ?,
                    conditions = ?, status = ?, expiry_date = ?, weight = ?, inspection_frequency = ?,
                    additional_notes = ?, station_name = ?, platform = ?
                  WHERE serial_number = ?";

        // Prepare statement
        if ($stmt = mysqli_prepare($conn, $query)) {
            // Bind parameters
            mysqli_stmt_bind_param($stmt, 'ssssssssssssss', $brand, $type, $capacity, $location, $installation_date,
                                   $condition, $status, $expiry_date, $weight, $inspection_frequency, 
                                   $additional_notes, $station_id, $platform_id, $serial_number);

            // Execute the query
            if (mysqli_stmt_execute($stmt)) {
                echo "<script>
                        alert('Fire extinguisher updated successfully!');
                        window.location.href = 'station-dashboard.php'; // Redirect after success
                      </script>";
            } else {
                echo "<script>
                        alert('Failed to update the fire extinguisher. Please try again.');
                      </script>";
            }

            // Close the statement
            mysqli_stmt_close($stmt);
        } else {
            echo "<script>
                    alert('SQL error: " . mysqli_error($conn) . "');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Please fill out all required fields!');
              </script>";
    }
}

// Fetch existing fire extinguisher details for the given serial_number
if (isset($_GET['serial_number'])) {
    $serial_number = $_GET['serial_number'];
    $query = "SELECT * FROM fire_extinguishers WHERE serial_number = '$serial_number'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
    } else {
        echo "<script>
                alert('No record found!');
                window.location.href = 'station-dashboard.php';
              </script>";
        exit;
    }
} else {
    echo "<script>
            alert('Invalid request!');
            window.location.href = 'station-dashboard.php';
          </script>";
    exit;
}

// Fetch data for Stations
$stationsQuery = "SELECT StationID, station_name FROM station"; 
$stationsResult = mysqli_query($conn, $stationsQuery);

// Fetch data for Platforms
$platformsQuery = "SELECT platform_id, platform_number FROM platform"; 
$platformsResult = mysqli_query($conn, $platformsQuery);

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Fire Extinguisher</title>
  <!-- Include SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <link rel="stylesheet" href="styles.css"> <!-- Link to the CSS file -->
</head>

<style>
/* Add your custom styling here */
body {
  font-family: Arial, sans-serif;
  background-color: #f4f4f4;
  margin: 0;
  padding: 20px;
}

.form-container {
  max-width: 600px;
  margin: auto;
  background: #fff;
  padding: 20px;
  border-radius: 10px;
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
}

h1 {
  text-align: center;
  margin-bottom: 20px;
}

.form-group {
  margin-bottom: 15px;
}

.form-group label {
  display: block;
  font-weight: bold;
  margin-bottom: 5px;
  color: #333;
}

.form-group input,
.form-group select,
.form-group textarea {
  width: 100%;
  padding: 10px;
  border: 1px solid #ccc;
  border-radius: 5px;
  box-sizing: border-box;
  font-size: 14px;
}

.form-actions {
  text-align: right;
}

button[type="submit"], 
button.cancel-btn {
  padding: 10px 20px;
  background-color: #007bff;
  color: white;
  border: none;
  border-radius: 5px;
  font-size: 16px;
  cursor: pointer;
}

button[type="submit"]:hover, 
button.cancel-btn:hover {
  background-color: #0056b3;
}
</style>

<body>
  <?php include('header.php'); ?>

  <div class="form-container">
    <h2>Edit Fire Extinguisher</h2>
    <form action="edit_fire.php" method="post">
    <input type="hidden" name="serial_number" value="<?php echo $row['serial_number']; ?>">

      <div class="form-group">
        <label for="brand">Brand & Model:</label>
        <input type="text" id="brand" name="brand" value="<?php echo $row['brand']; ?>" required>
      </div>
      <div class="form-group">

        <label for="type">Type:</label>
        <select name="type" id="type"  required>
        <option value="" disabled selected>Select Type</option>
        <option value="water" <?php echo $row['type'] == 'water' ? 'selected' : ''; ?>>Water</option>
        <option value="foam" <?php echo $row['type'] == 'foam' ? 'selected' : ''; ?>>Foam</option>
        <option value="co2" <?php echo $row['type'] == 'co2' ? 'selected' : ''; ?>>Co2</option>
        <option value="powder" <?php echo $row['type'] == 'powder' ? 'selected' : ''; ?>>Powder</option>
        </select>
      </div>
      <div class="form-group">
        <label for="capacity">Capacity:</label>
        <input type="text" id="capacity" name="capacity" value="<?php echo $row['capacity']; ?>" required>
      </div>
      <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" value="<?php echo $row['location']; ?>" required>
      </div>
      <div class="form-group">
        <label for="installationDate">Installation Date:</label>
        <input type="date" id="installationDate" name="installationDate" value="<?php echo $row['installation_date']; ?>" required>
      </div>
      <div class="form-group">
        <label for="condition">Condition:</label>
        <select id="condition" name="condition" required>
          <option value="good" <?php echo $row['conditions'] == 'good' ? 'selected' : ''; ?>>Good</option>
          <option value="needRepair" <?php echo $row['conditions'] == 'needRepair' ? 'selected' : ''; ?>>Need Repair</option>
        </select>
      </div>
      <div class="form-group">
        <label for="status">Status:</label>
        <select id="status" name="status" required>
          <option value="active" <?php echo $row['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
          <option value="expired" <?php echo $row['status'] == 'expired' ? 'selected' : ''; ?>>Expired</option>
        </select>
      </div>
      <div class="form-group">
        <label for="expiryDate">Expiry Date:</label>
        <input type="date" id="expiryDate" name="expiryDate" value="<?php echo $row['expiry_date']; ?>" required>
      </div>
      <div class="form-group">
        <label for="weight">Weight:</label>
        <input type="text" id="weight" name="weight" value="<?php echo $row['weight']; ?>" required>
      </div>
      <div class="form-group">
        <label for="inspectionFrequency">Inspection Frequency:</label>
        <select id="inspectionFrequency" name="inspectionFrequency" required>
          <option value="monthly" <?php echo $row['inspection_frequency'] == 'monthly' ? 'selected' : ''; ?>>Monthly</option>
          <option value="annually" <?php echo $row['inspection_frequency'] == 'annually' ? 'selected' : ''; ?>>Annually</option>
        </select>
      </div>
      <div class="form-group">
        <label for="additionalNotes">Additional Notes:</label>
        <textarea id="additionalNotes" name="additionalNotes" rows="3"><?php echo $row['additional_notes']; ?></textarea>
      </div>

      <div class="form-group">
        <label for="station">Station:</label>
        <select name="station" id="station" required>
          <option value="" disabled>Select Station</option>
          <?php while ($stationRow = mysqli_fetch_assoc($stationsResult)) : ?>
            <option value="<?= $stationRow['StationID']; ?>" <?php echo ($row['station_name'] == $stationRow['StationID']) ? 'selected' : ''; ?>>
              <?= $stationRow['station_name']; ?>
            </option>
          <?php endwhile; ?>
        </select>
      </div>
      
      <div class="form-group">
    <label for="platform">Platform:</label>
    <select name="platform" id="platform" required>
        <option value="" disabled selected>Select Platform</option>
        <?php 
        // Generate default platform numbers (1-12)
        for ($i = 1; $i <= 12; $i++) {
            $selected = ($row['platform'] == $i) ? 'selected' : '';
            echo "<option value='$i' $selected>$i</option>";
        }
        ?>
    </select>
</div>


      
      <div class="form-actions">
        <button type="submit">Update</button>
        <button type="button" class="cancel-btn" onclick="window.location.href='station-dashboard.php';">Cancel</button>
      </div>
    </form>
  </div>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      var stationDropdown = document.getElementById('station');
      var platformDropdown = document.getElementById('platform');
      var platforms = <?php echo json_encode($platforms); ?>;
      
      function updatePlatforms() {
        var stationId = stationDropdown.value;
        platformDropdown.innerHTML = '<option value="" disabled>Select Platform</option>';
        if (platforms[stationId]) {
          platforms[stationId].forEach(function (platform) {
            var option = document.createElement('option');
            option.value = platform;
            option.textContent = platform;
            if (platform == "<?php echo $row['platform']; ?>") {
              option.selected = true;
            }
            platformDropdown.appendChild(option);
          });
        }
      }
      stationDropdown.addEventListener('change', updatePlatforms);
      updatePlatforms();
    });
  </script>
</body>
</html>
