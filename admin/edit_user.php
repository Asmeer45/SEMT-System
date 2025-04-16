
<?php
include('include/session_check.php');
checkRole('admin');
?>

<?php

include('../include/config.php');

if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "<script>alert('Invalid request.'); window.location.href='user_management.php';</script>";
    exit();
}

$id = intval($_GET['id']);
$query = "SELECT user_name, email, phone, user_type, station FROM user WHERE userid = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo "<script>alert('User not found.'); window.location.href='user_management.php';</script>";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_name = $_POST['user_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $user_type = $_POST['user_type'];
    $station = $_POST['station'];

    $updateQuery = "UPDATE user SET user_name = ?, email = ?, phone = ?, user_type = ?, station = ? WHERE userid = ?";
    $stmt = $conn->prepare($updateQuery);
    $stmt->bind_param("sssssi", $user_name, $email, $phone, $user_type, $station, $id);

    if ($stmt->execute()) {
        echo "<script>alert('User updated successfully.'); window.location.href='user_management.php';</script>";
    } else {
        echo "<script>alert('Error updating user.');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .container {
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 400px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        label {
            font-weight: bold;
            display: block;
            margin-top: 10px;
        }
        input, select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            margin-top: 15px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background: #218838;
        }
        a {
            display: block;
            text-align: center;
            margin-top: 10px;
            text-decoration: none;
            color: #007bff;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Edit User</h2>
        <form method="POST">
            <label for="user_name">Username:</label>
            <input type="text" name="user_name" value="<?php echo htmlspecialchars($user['user_name']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>
            
            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
            
            <label for="user_type">User Type:</label>
            <select name="user_type" required>
                <option value="admin" <?php echo ($user['user_type'] == 'admin') ? 'selected' : ''; ?>>admin</option>
                <option value="station_master" <?php echo ($user['user_type'] == 'station_master') ? 'selected' : ''; ?>>station_master</option>
                <option value="fire_company" <?php echo ($user['user_type'] == 'fire_company') ? 'selected' : ''; ?>>fire_company</option>
                <option value="scale_company" <?php echo ($user['user_type'] == 'scale_company') ? 'selected' : ''; ?>>scale_company</option>
            </select>
            
            <label for="station">Station:</label>

            <select id="station" name="station" class="station-select" required>
  <option  ><?php echo htmlspecialchars($user['station']); ?></option>
  <?php
    // Fetch stations from the database
    $stationQuery = "SELECT station_id, station_name FROM station_details";
    $stationResult = $conn->query($stationQuery);
    if ($stationResult->num_rows > 0) {
        while ($row = $stationResult->fetch_assoc()) {
            echo "<option value='{$row['station_name']}'>{$row['station_name']}</option>";
        }
    }
    ?>
  </select>
            <button type="submit">Update</button>
            <a href="user_management.php">Cancel</a>
        </form>
    </div>
    <!-- jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    // Apply Select2 to station dropdown with a search box
    $('.station-select').select2({
      value: "<?php echo htmlspecialchars($user['station']); ?>",
      allowClear: true,
      width: '100%' // Ensures full width
    });

    // Show/hide station dropdown based on role selection
    $('#role').on('change', function() {
      if ($(this).val() === 'station_master') {
        $('#stationField').show();
      } else {
        $('#stationField').hide();
      }
    });
  });
</script>

</body>
</html>
