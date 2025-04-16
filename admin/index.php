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

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

  <!-- Custom styles -->
  <link rel="stylesheet" href="./css/style.min.css">

  <style>
    /* Increased size of stat-cards and center content */
    .stat-cards-item {
      display: flex;
      flex-direction: column; /* Align items in a column */
      justify-content: center; /* Center horizontally */
      align-items: center; /* Center vertically */
      background-color: #fff;
      /*padding-left: 130px;*/
      padding: 30px; /* Increased padding */
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      margin-bottom: 30px; /* Increased margin for spacing */
      margin-left:20px;
      transition: transform 0.3s ease;
      height: 150px; /* Set a fixed height for the cards */
      width: 400px;
    }

    /* On hover, make the card slightly larger */
    .stat-cards-item:hover {
      transform: scale(1.05);
    }

    /* Increased size of icons */
    .stat-cards-icon {
      font-size: 50px; /* Increased font size */
      color: #14a7fd;
      background-color: rgba(20, 167, 253, 0.1);
      padding: 20px; /* Increased padding for the icon */
      border-radius: 50%;
      display: inline-flex;
      justify-content: center;
      align-items: center;
      margin-bottom: 10px; /* Add spacing below the icon */
    }

    /* Increased font size of stat card text */
    .stat-cards-info__num {
      font-size: 36px; /* Adjusted number size */
      font-weight: bold;
      margin: 0;
      color: #333;
    }

    .stat-cards-info__title {
      font-size: 20px; /* Adjusted title size */
      color: #666;
      text-align: center; /* Center align the title text */
    }
    
    /* Increased the row gap */
    .row.stat-cards {
      gap: 200px; /* Adjusted gap between cards */
    }

    .send-reminder-btn {
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: #14a7fd; /* Primary color */
      color: #fff;
      margin-left: 450px;
      margin-top: 100px;
      font-size: 20px;
      font-weight: bold;
      padding: 15px 30px;
      border: none;
      border-radius: 8px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
    }

    .send-reminder-btn i {
      margin-right: 10px; /* Space between icon and text */
      font-size: 24px;
    }

    .send-reminder-btn:hover {
      background-color: red;
      transform: translateY(-3px);
    }

    @media (max-width: 768px) {
  .row.stat-cards {
    flex-direction: column;
    align-items: center;
  }
  
  .stat-cards-item {
    width: 90%;
  }

  .sidebar, .navigation_hader {
    text-align: center;
    padding: 10px;
  }
}

  </style>
</head>

<body>
  <div class="layer"></div>
  <!-- ! Body -->
  <a class="skip-link sr-only" href="#skip-target">Skip to content</a>
  <div class="page-flex">

    <?php include("sidebar.php"); ?>

    <div class="main-wrapper">
      <?php include("navigation_hader.php"); ?>

      <!-- ! Main -->
      <main class="main users chart-page" id="skip-target">
        <div class="container">
          <h2 class="main-title">Dashboard</h2>

          <?php
          // Database configuration file
          include('../include/config.php');

          // Query to get the total number of users
          $userCountQuery = "SELECT COUNT(*) AS userCount FROM user";
          $userCountResult = $conn->query($userCountQuery);
          $userCount = ($userCountResult->num_rows > 0) ? $userCountResult->fetch_assoc()['userCount'] : 0;

          // Query to get the total balance (replace `balance_column` with actual column name for balance)
          $balanceTotalQuery = "SELECT COUNT(*) AS balanceTotal FROM weight_scales"; // Adjust the query based on your database
          $balanceTotalResult = $conn->query($balanceTotalQuery);
          $balanceTotal = ($balanceTotalResult->num_rows > 0) ? $balanceTotalResult->fetch_assoc()['balanceTotal'] : 0;

          // Query to get the total number of fire incidents (replace `fire_column` with actual column name for fire)
          $fireCountQuery = "SELECT COUNT(*) AS fireCount FROM fire_extinguishers"; // Adjust the query based on your database
          $fireCountResult = $conn->query($fireCountQuery);
          $fireCount = ($fireCountResult->num_rows > 0) ? $fireCountResult->fetch_assoc()['fireCount'] : 0;

          // Close connection
          $conn->close();
          ?>

          <!-- Stat Cards -->
          <div class="row stat-cards justify-content-center">
            <!-- User Total Card -->
            <div class="stat-cards-item">
              <div class="stat-cards-icon">
                <i class="fas fa-users"></i>
              </div>
              <div class="stat-cards-info">
                <p class="stat-cards-info__num"><?php echo $userCount; ?></p>
                <p class="stat-cards-info__title">User Total</p>
              </div>
            </div>

      
      

        </div>
      </main>
      <!-- ! Footer -->
      <footer class="footer">
        <div class="container footer--flex">
          <div class="footer-start">
            <p>2025 © SEMT System Dashboard <a href="elegant-dashboard.com" target="_blank"
                rel="noopener noreferrer"></a></p>
          </div>
        </div>
      </footer>
    </div>
  </div>
  <!-- Chart library -->
  <script src="./plugins/chart.min.js"></script>
  <!-- Icons library -->
  <script src="plugins/feather.min.js"></script>
  <!-- Custom scripts -->
  <script src="js/script.js"></script>

  <script>
    // Browser detection
    function detectBrowser() {
        var userAgent = navigator.userAgent;

        // Check for specific browsers and hide content
        if (userAgent.indexOf("Chrome") > -1) {
            console.log("Chrome detected. Displaying content.");
            return; // Chrome, do nothing
        } else if (userAgent.indexOf("Firefox") > -1) {
            console.log("Firefox detected. Displaying content.");
            return; // Firefox, do nothing
        } else if (userAgent.indexOf("Safari") > -1 && userAgent.indexOf("Chrome") === -1) {
            console.log("Safari detected. Hiding content.");
            document.getElementById('content').classList.add('hidden'); // Hide content for Safari
        } else if (userAgent.indexOf("MSIE") > -1 || userAgent.indexOf("Trident") > -1) {
            console.log("Internet Explorer detected. Hiding content.");
            document.getElementById('content').classList.add('hidden'); // Hide content for IE
        } else if (userAgent.indexOf("Edge") > -1) {
            console.log("Edge detected. Hiding content.");
            document.getElementById('content').classList.add('hidden'); // Hide content for Edge
        } else {
            console.log("Unknown browser. Hiding content.");
            document.getElementById('content').classList.add('hidden'); // Hide content for any other browser
        }
    }

    // Call the browser detection function on page load
    window.onload = detectBrowser;
  </script>
</body>

</html>
