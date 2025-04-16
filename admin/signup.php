<?php
include('include/session_check.php');
checkRole('admin');
?>

<?php
//session_start();
include('../include/config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $email = $conn->real_escape_string($_POST['email']);
    $phonenumber = $conn->real_escape_string($_POST['phone']);
    $role = $conn->real_escape_string($_POST['role']);
    
    // Check if station is provided; handle null value if not
    $station = !empty($_POST['station']) ? $conn->real_escape_string($_POST['station']) : null;

    // Check if the username already exists
    $checkUserQuery = "SELECT * FROM user WHERE user_name = ?";
    $stmt = $conn->prepare($checkUserQuery);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $_SESSION['message'] = "username_exists";
    } else {
        // Hash the password for security
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Prepare the SQL query
        $sql = "INSERT INTO user(user_name, password, email, phone, user_type, station) VALUES (?, ?, ?, ?, ?, ?)";

        // Prepare and execute the statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssssss", $username, $hashed_password, $email, $phonenumber, $role, $station);

            if ($stmt->execute()) {
                // Set the success message in session
                $_SESSION['message'] = "success";
            } else {
                $_SESSION['message'] = "error";
            }

            $stmt->close();
        } else {
            $_SESSION['message'] = "error";
        }
    }

    $conn->close();

    // Redirect to the same page to avoid resubmission
    header("Location: " . $_SERVER['PHP_SELF']);
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SEMT System Sign-Up</title>

  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css">
  <!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />


  <style>
        body {
            
            background-color: #f7f7f7;
           
        }

        .signup-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 100%;
            max-width: 400px;
            margin-top: 50px;
            margin-left: 420px;
        }

        .signup-container h1 {
            font-size: 24px;
            margin-bottom: 15px;
            font-weight: bold;
            color: #333;
            
        }

        .input-group {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    padding: 10px;
    background-color: #f9f9f9;
}

.input-group i {
    margin-right: 10px;
    color: #888;
}

.input-group input {
            border: none;
            outline: none;
            flex: 1;
            font-size: 14px;
            background-color: transparent;
        }

.input-group select {
    border: none;
    outline: none;
    flex: 1;
    font-size: 14px;
    background-color: transparent;
    appearance: none; /* Remove default browser styling */
    padding: 5px 0;
    color: #333;
    font-family: inherit;
}

.input-group select:focus {
    border: none;
    outline: none;
}

.input-group select option {
    color: black;
    background-color: #fff;
}

.error-message {
    color: red;
    font-size: 12px;
    margin-bottom: 10px;
    text-align: left;
}

.signup-btn {
    background-color: #007bff;
    color: #fff;
    border: none;
    padding: 10px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    width: 100%;
}

.signup-btn:hover {
    background-color: #0056b3;
}

.note {
    margin-top: 15px;
    font-size: 12px;
    color: #666;
}

.note a {
    color: #007bff;
    text-decoration: none;
}

.note a:hover {
    text-decoration: underline;
}

        
        

       

    </style>
</head>

<body>
  <div class="layer"></div>
  <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
  <div class="page-flex">

    <?php include("sidebar.php"); ?>

    <div class="main-wrapper">
      <?php include("navigation_hader.php"); ?>

      <main class="main users chart-page" id="skip-target">
      <div class="signup-container">
        <h1>Create Account</h1>
        <form id="signupForm" action="" method="POST">

        <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" id="username" placeholder="Username" name="username" required>
            </div>
            <div class="error-message" id="usernameError" ></div>

            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" id="password" placeholder="Password" name="password" required>
            </div>
            <div class="error-message" id="passwordError"></div>
            
            <div class="input-group">
                <i class="fas fa-envelope"></i>
                <input type="email" id="email" placeholder="Email" name="email" required>
            </div>
            <div class="error-message" id="emailError"></div>

            <div class="input-group">
                <i class="fas fa-phone"></i>
                <input type="tel" id="phone" placeholder="Phone Number" name="phone" required>
            </div>
            <div class="error-message" id="phonenumberError"></div>
         
<!-- Role -->
<div class="input-group">
  <i class="fas fa-user-tag"></i>
  <select id="role" name="role" required onchange="checkRole()">
    <option value="" disabled selected>Select Role</option>
    <!-- Dynamically populated options -->
    <?php
    $roleQuery = "SHOW COLUMNS FROM user LIKE 'user_type'";
    $roleResult = $conn->query($roleQuery);
    if ($roleResult) {
        $row = $roleResult->fetch_assoc();
        preg_match("/^enum\('(.*)'\)$/", $row['Type'], $matches);
        $enumValues = explode("','", $matches[1]);
        foreach ($enumValues as $value) {
            echo "<option value='$value'>$value</option>";
        }
    }
    ?>
  </select>
</div>
<div class="error-message" id="roleError"></div>

<!-- Station (Initially hidden) -->
<div class="input-group" id="stationField" style="display: none;">
  <i class="fas fa-train"></i>
  <select id="station" name="station" class="station-select">
  <option value="" disabled selected>Select Station</option>
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
</div>
<div class="error-message" id="stationError"></div>

<script>
 function checkRole() {
    const role = document.getElementById('role').value;
    const stationField = document.getElementById('stationField');
    if (role === 'station_master') {
        stationField.style.display = 'block';
    } else {
        stationField.style.display = 'none';
    }
}

</script>

<div class="error-message" id="stationError"></div>
            <div style="display: flex; align-items: center; gap: 10px; margin-top: 20px;">
  <!-- Back Button -->
  <a href="user_management.php" class="btn" style="display: inline-block; text-align: center; padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; text-decoration: none; font-size: 16px; font-weight: 500;">
    <i class="fas fa-arrow-left"></i> Back
  </a>

  <!-- Sign Up Button -->
  <button type="submit" class="btn" style="padding: 10px 20px; background-color: #007bff; color: #fff; border: none; border-radius: 5px; cursor: pointer; font-size: 16px; font-weight: 500;">
    Sign Up
  </button>
</div>



               </form>
    </div>
    <script>
    function clearFields() {
        document.getElementById('username').value = '';
        document.getElementById('password').value = '';
        document.getElementById('email').value = '';
        document.getElementById('phone').value = '';
        document.getElementById('usernameError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('phonenumberError').textContent = '';
    }

    document.getElementById('phone').addEventListener('input', function () {
        this.value = this.value.replace(/\D/g, '').slice(0, 10);
    });

    document.getElementById('signupForm').addEventListener('submit', function(event) {
        let isValid = true;

        document.getElementById('usernameError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        document.getElementById('emailError').textContent = '';
        document.getElementById('phonenumberError').textContent = '';

        // Validate username
        const username = document.getElementById('username').value.trim();
        if (username === '') {
            document.getElementById('usernameError').textContent = 'Please fill out this field';
            isValid = false;
        }

        // Validate password
        const password = document.getElementById('password').value.trim();
        if (password === '') {
            document.getElementById('passwordError').textContent = 'Please fill out this field';
            isValid = false;
        }

        // Validate email format
        const email = document.getElementById('email').value.trim();
        const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email === '') {
            document.getElementById('emailError').textContent = 'Please fill out this field';
            isValid = false;
        } else if (!emailPattern.test(email)) {
            document.getElementById('emailError').textContent = 'Please enter a valid email address';
            isValid = false;
        }

        // Validate phone number (10 digits, only numbers)
        const phonenumber = document.getElementById('phone').value.trim();
        if (phonenumber === '') {
            document.getElementById('phonenumberError').textContent = 'Please fill out this field';
            isValid = false;
        } else if (phonenumber.length !== 10) {
            document.getElementById('phonenumberError').textContent = 'Phone number must be exactly 10 digits';
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    window.onload = function() {
    <?php if (isset($_SESSION['message'])) { ?>
        let icon, title, text;
        
        switch ('<?php echo $_SESSION['message']; ?>') {
            case "success":
                icon = "success";
                title = "Success";
                text = "New record created successfully";
                break;
            case "username_exists":
                icon = "error";
                title = "Error";
                text = "Username already exists";
                break;
            default:
                icon = "error";
                title = "Error";
                text = "An unexpected error occurred";
        }

        Swal.fire({
            icon: icon,
            title: title,
            text: text,
            confirmButtonText: 'OK'
        }).then((result) => {
            if (result.isConfirmed && icon === 'success') {
                window.location.href = 'user_management.php'; // Redirect to login on success
            }
        });

        <?php unset($_SESSION['message']); // Unset the session message after use ?>
    <?php } ?>
};

</script>

      <footer class="footer">
        <div class="container footer--flex">
          <div class="footer-start">
            <p>2025 © SEMT System Dashboard</p>
          </div>
        </div>
      </footer>
    </div>
  </div>





<!-- jQuery (Required for Select2) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<script>
  $(document).ready(function() {
    // Apply Select2 to station dropdown with a search box
    $('.station-select').select2({
      placeholder: "Select Station",
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



  <!-- Chart Library -->
  <script src="./plugins/chart.min.js"></script>
  <!-- Icons Library -->
  <script src="./plugins/feather.min.js"></script>
  <!-- Custom Scripts -->
  <script src="./js/script.js"></script>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const detectBrowser = () => {
        const userAgent = navigator.userAgent;

        if (/Chrome/.test(userAgent)) {
          console.log("Chrome detected.");
        } else if (/Firefox/.test(userAgent)) {
          console.log("Firefox detected.");
        } else if (/Safari/.test(userAgent) && !/Chrome/.test(userAgent)) {
          console.log("Safari detected. Content may be restricted.");
        } else if (/MSIE|Trident/.test(userAgent)) {
          console.log("Internet Explorer detected. Content may not display properly.");
        } else if (/Edge/.test(userAgent)) {
          console.log("Edge detected.");
        } else {
          console.log("Unknown browser.");
        }
      };

      detectBrowser();
    });
  </script>
</body>

</html>
