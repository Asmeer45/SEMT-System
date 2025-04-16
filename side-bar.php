
<?php


// Include the database connection
include("include/config.php");
// Start the session to access the logged-in user's information
//session_start(); 

// Assuming the user is logged in, and their user_type is stored in the session
if (isset($_SESSION['user_name'])) {
    // Get the user type from the session
    $user_type = $_SESSION['user_type'];
    
    // If the user type is 'station_master', fetch the station name from the user table
    if ($user_type == 'station_master') {
        $username = $_SESSION['user_name'];  // Get the logged-in username

        // Query to get the station name from the user table
        $query = "SELECT station FROM user WHERE User_name = '$username' LIMIT 1";
        $result = mysqli_query($conn, $query);

        // Check if the query was successful
        if ($result && mysqli_num_rows($result) > 0) {
            $station = mysqli_fetch_assoc($result);
            $station_name = $station['station'];  // Get the station name
        } else {
            $station_name = "Station not found";  // Fallback message if no station is found
        }
    }
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .header {
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            height: 100%;
            background: #0047ab;
            color: #fff;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
            margin-top: 80px;
        }

        .header h1 {
            margin: 0 0 20px 0;
            font-size: 18px;
            margin-top: 10px;
    text-align:center;
        }

        .nav-tabs {
            display: flex;
            flex-direction: column;
            gap: 10px;
            list-style: none;
            margin: 0;
            padding: 0;
        }

        .nav-tabs li {
            position: relative;
        }

        .nav-tabs a {
            text-decoration: none;
            color: #fff;
            font-size: 16px;
            padding: 10px;
            border-radius: 3px;
            transition: background-color 0.3s ease;
            display: block;
        }

        .nav-tabs a:hover {
            background-color: #003580;
        }

        .dropdown {
            display: none;
            position: absolute;
            left: 100%;
            top: 0;
            background: #003580;
            padding: 10px;
            border-radius: 3px;
            width: 200px;
            list-style: none;
            
        }

        .nav-tabs li:hover .dropdown {
            display: block;
        }

        .dropdown a {
            font-size: 14px;
            padding: 5px 10px;
        }

        .dashboard {
            margin-left: 270px;
            padding: 20px;
        }

/* Ensure stats and other sections adjust to the new layout */
.stats {
    display: flex;
    justify-content: space-between;
    margin: 20px 0;
    flex-wrap: wrap; /* Adjust for smaller screens */
}

/* Responsive Design */
@media screen and (max-width: 768px) {
    .header {
        width: 100%;
        height: auto;
        position: relative;
        padding: 10px;
    }

    .header h1 {
        font-size: 16px;
        text-align: center;
    }

    .nav-tabs {
        flex-direction: row;
        flex-wrap: wrap;
        justify-content: center;
    }

    .nav-tabs li {
        position: relative;
        display: inline-block;
    }

    .nav-tabs a {
        font-size: 14px;
        padding: 8px;
    }

    .dropdown {
        position: relative;
        left: 0;
        top: auto;
        width: 100%;
        background: #003580;
        padding: 5px;
    }

    .dashboard {
        margin-left: 0;
        padding: 10px;
    }
}

@media screen and (max-width: 480px) {
    .header {
        text-align: center;
        margin-top:0px;
        width:100%;
    }

    .nav-tabs {
        flex-direction: column;
        align-items: center;
    }

    .nav-tabs li {
        width: 100%;
        text-align: center;
    }

    .nav-tabs a {
        font-size: 14px;
        padding: 10px;
    }

    .dropdown {
        position: relative;
        width: 100%;
    }

    .dashboard {
        padding: 10px;
    }
}

    </style>
    
</head>
<body>

<header class="header">

</br>
<h1>
    <?php
    //Check if the current page is not index.php or user_login.php
    $current_page = basename($_SERVER['PHP_SELF']);
    if ($current_page != 'index.php' && $current_page != 'login.php' && isset($_SESSION['user_name'])) {
        echo '<span class="username">Welcome, ' . htmlspecialchars($_SESSION['user_name']) . '</span>';
        
        // // Logout icon
        // echo '<a href="logout.php" class="logout-link" title="Logout">';
        // echo '<i class="fas fa-sign-out-alt"></i>';
        // echo '</a>';
    }
    ?></br>
    </br>Dashboard<?php if (isset($station_name)): ?> - <?php echo htmlspecialchars($station_name); ?><?php endif; ?></h1>
    <?php if (isset($station_name)): ?>
        <div class="station-name" align="center" style="font-size: 15px;">
            
        </div>
    <?php endif; ?>
        <nav>
        <ul class="nav-tabs">
            <li><a href="station-dashboard.php">Home</a></li>
            <li>
                <a href="#">Maintenance</a>
                <ul class="dropdown">
                    <li><a href="maintenance-fire.php">Fire-Extinguishers</a></li>
                    <li><a href="maintenance-scale.php">Balances</a></li>
                </ul>
            </li>
            <li>
                <a href="#Repairs">Repairs</a>
                <ul class="dropdown">
                    <li><a href="fire-requests-view.php">Fire-Extinguishers</a></li>
                    <li><a href="scale-requests-view.php">Balances</a></li>
                </ul>
            </li>
            <li>
                <a href="#Quotations">Quotations</a>
                <ul class="dropdown">
                    <li><a href="fire-quotations-view.php">Fire-Extinguishers</a></li>
                    <li><a href="scale-quotation-view.php">Balances</a></li>
                </ul>
            </li>
            <li>
                <a href="#Invoices">Invoices</a>
                <ul class="dropdown">
                    <li><a href="fire-invoice.php">Fire-Extinguishers</a></li>
                    <li><a href="scale-invoice.php">Balances</a></li>
                </ul>
            </li>
            <li><a href="logout.php">Logout</a></li>
            <li>


        </ul>
        </nav><br><br><br><br><br><br><br><br><br><br><br><br>

       

    </header>
    
</body>
</html>