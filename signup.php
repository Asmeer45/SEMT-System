<?php
session_start();
include('include/config.php');


if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // Sanitize and retrieve form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $email = $conn->real_escape_string($_POST['email']);
    $phonenumber = $conn->real_escape_string($_POST['phone']);

    // Check if the username already exists
    $checkUserQuery = "SELECT * FROM user WHERE User_name = ?";
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
        $sql = "INSERT INTO user(user_name, password, email, phone) VALUES (?, ?, ?, ?)";

        // Prepare and execute the statement
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("ssss", $username, $hashed_password, $email, $phonenumber);
            
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMT System Sign-Up</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f7f7;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            padding: 0 15px; /* Add padding for smaller screens */
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

        /* Responsive Styles */
        @media (max-width: 480px) {
            body {
                padding: 20px 20px;
                width: 100%;
                max-width: 320px;
                 /* Increase padding for small devices */
            }

            .signup-container {
                padding: 15px;
            }

            .signup-container h1 {
                font-size: 20px;
            }

            .input-group input {
                font-size: 12px;
            }

            .signup-btn {
                font-size: 14px;
                padding: 8px;
            }

            .note {
                font-size: 11px;
            }

            .error-message {
                font-size: 11px;
            }
        }
    </style>
</head>
<body>

<?php
include('include/header.php');
?>

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

           

            <button type="submit" class="signup-btn">Sign Up</button>
            <div class="note">Already have an account? <a href="login.php">Login here</a></div>
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
                window.location.href = 'login.php'; // Redirect to login on success
            }
        });

        <?php unset($_SESSION['message']); // Unset the session message after use ?>
    <?php } ?>
};

</script>
</body>
</html>