<?php
// Start the session with secure parameters
if (session_status() == PHP_SESSION_NONE) {
    $cookieParams = session_get_cookie_params();
    session_set_cookie_params([
        'lifetime' => $cookieParams["lifetime"],
        'path' => $cookieParams["path"],
        'domain' => $cookieParams["domain"],
        'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on', // Ensure cookies are sent over HTTPS
        'httponly' => true, // Prevent JavaScript access to session cookies
        'samesite' => 'Strict' // Adjust as needed ('Lax' or 'None')
    ]);
    session_start();
    
}

// Include the database connection
include("include/config.php");

$message = '';
if (isset($_SESSION['message'])) {
    $message = $_SESSION['message'];
    // Clear the message after displaying
    unset($_SESSION['message']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize and retrieve form data
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password']; // No need to escape password

    // Prepare the SQL query to fetch user data
    $sql = "SELECT password, user_type FROM user WHERE User_name = ?";
    
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        
        if ($stmt->execute()) {
            $stmt->store_result();
            
            if ($stmt->num_rows == 1) {
                $stmt->bind_result($hashed_password, $user_type);
                $stmt->fetch();
                
                // Verify the password
                if (password_verify($password, $hashed_password)) {
                     // Check user type validity
                     if (in_array($user_type, ['station_master', 'fire_company','scale_company','admin'])) {
                        $_SESSION['loggedin'] = true;
                        $_SESSION['user_name'] = $username;
                        $_SESSION['user_type'] = $user_type;
                    
                    // Redirect based on user type
                    if ($user_type === 'station_master') {
                        header("Location: station-dashboard.php");
                    } elseif ($user_type === 'fire_company') {
                        header("Location: fire-company/index.php");
                    } 
                    elseif ($user_type === 'scale_company') {
                        header("Location: scale-company/index.php");
                    } 
                    elseif ($user_type === 'admin') {
                        header("Location: admin/index.php");
                    } 
                    exit();

                } else {
                    $message = "Invalid user type.";
                }
            } else {
                    $message = "Invalid username or password.";
                }
            } else {
                $message = "Invalid username or password.";
            }
        } else {
            $message = "Error executing query: " . $stmt->error;
        }
        $stmt->close();
    } else {
        $message = "Error preparing statement: " . $conn->error;
    }
    $conn->close();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMT System Login</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"> </script>
    <link rel="stylesheet" href="css/login.css">
    
</head>
<body>

<?php
include('include/header.php');
?>
    <div class="login-container">
        <h1>SEMT System</h1>
        <p>Station Equipment Maintenance Tracking</p>
        <form method="POST">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" placeholder="Password" required>
            </div>
            <button type="submit" class="login-btn">Login</button>
            <!-- <div class="role-select">
                <label class="role" for="role">Select Role:</label>
                <select id="role" name="role">
                    <option value="station_master">Station Master</option>
                    <option value="technician">Technician</option>
                    <option value="admin">Admin</option>
                </select>
            </div> -->
        </form>
        <br><br>

        <!-- <div class="signup-link">
            Don't have account? <a href="signup.php">Signup now</a>
        </div> -->
    </div>

    <?php if ($message): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '<?php echo htmlspecialchars($message); ?>',
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'OK'
                });
            });

            </script>
             <?php endif; ?>
</body>
</html>