<?php
include('include/session_check.php');
checkRole('admin');
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>SEMT Information System | Dashboard</title>

  <!-- FontAwesome Icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css">

  <style>
    body {
      font-family: Arial, sans-serif;
    }

    .user-table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }

    .user-table th,
    .user-table td {
      padding: 12px;
      text-align: left;
      border: 1px solid #ddd;
    }

    .user-table th {
      background-color: #f4f4f4;
      font-weight: bold;
    }

    .user-table tr:hover {
      background-color: #f1f1f1;
    }

    .action-btn {
      display: flex;
      gap: 10px;
    }

    .action-btn button {
      padding: 5px 10px;
      background-color: #14a7fd;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .action-btn button:hover {
      background-color: #007bb5;
    }

    .btn-add {
      display: inline-flex;
      align-items: center;
      padding: 10px 20px;
      background-color: #007bff;
      color: white;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      font-size: 16px;
      transition: background-color 0.3s ease;
      gap: 8px;
    }

    .btn-add:hover {
      background-color: #0056b3;
    }
  </style>
</head>

<body>
  <div class="layer"></div>
  <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
  <div class="page-flex">

    <?php include("./sidebar.php"); ?>

    <div class="main-wrapper">
      <?php include("navigation_hader.php"); ?>

      <main class="main users chart-page" id="skip-target">
        <div class="container">
          <h2 class="main-title">User Management</h2>
          <a href="signup.php" class="btn-add">
  <i class="fas fa-plus"></i> Add User
</a>


          <?php
          // Database configuration file
          include('include/config.php');

          // Query to get user data
          $userQuery = "SELECT userid, user_name, email, phone, user_type, station FROM user";
          $userResult = $conn->query($userQuery);
          ?>

          <!-- User Table -->
          <table class="user-table">
            <thead>
              <tr>
                <th>Username</th>
                <th>Email</th>
                <th>Phone Number</th>
                <th>User Type</th>
                <th>station</th>
                <th>Action</th>
              </tr>
            </thead>
            <tbody>
              <?php
              if ($userResult->num_rows > 0) {
                while ($row = $userResult->fetch_assoc()) {
                  echo "<tr>
                          <td>" . htmlspecialchars($row['user_name'] ?? '') . "</td>
<td>" . htmlspecialchars($row['email'] ?? '') . "</td>
<td>" . htmlspecialchars($row['phone'] ?? '') . "</td>
<td>" . htmlspecialchars($row['user_type'] ?? '') . "</td>
<td>" . htmlspecialchars($row['station'] ?? '') . "</td>

                          <td class='action-btn'>
                          <a href='edit_user.php?id=" . $row['userid'] . "' class='edit-btn'><i class='fas fa-edit'></i> Edit</a>
                          <button onclick='deleteUser(" . $row['userid'] . ")'><i class='fas fa-trash-alt'></i> Delete</button>
                           <button onclick='changePassword(" . $row['userid'] . ")'><i class='fas fa-key'></i> Change Password</button>
                        </td>
                        </tr>";
                }
              } else {
                echo "<tr><td colspan='5'>No users found</td></tr>";
              }
              ?>
            </tbody>
          </table>

          <?php
          $conn->close();
          ?>
        </div>
      </main>

      <footer class="footer">
        <div class="container footer--flex">
          <div class="footer-start">
            <p>2025 © SEMT System Dashboard</p>
          </div>
        </div>
      </footer>
    </div>
  </div>

  <script>
    function deleteUser(id) {
      if (confirm('Are you sure you want to delete this user?')) {
        window.location.href = 'delete_user.php?id=' + id;
      }
    }

    function changePassword(id) {
      let oldPassword = prompt("Enter old password:");
      if (oldPassword) {
        let newPassword = prompt("Enter new password:");
        if (newPassword) {
          fetch('change_password.php', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + id + '&old_password=' + encodeURIComponent(oldPassword) + '&new_password=' + encodeURIComponent(newPassword)
          })
          .then(response => response.text())
          .then(data => alert(data));
        }
      }
    }
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
