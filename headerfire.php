<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Website Header</title>
    <link rel="stylesheet" href="styles.css">

     <!-- Include Google Fonts -->
     <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    
     <!-- FontAwesome for Icons -->
     <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />

    <style>
        /* styles.css */

        body{
            margin: 0;
            
        }

        .site-header {
            background-color: #333;
            color: #fff;
            padding: 0;
            width: 100%;
            height: 80px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: top 0.3s; /* Smooth transition for hiding/showing */
        }

        .container1 {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1em;
            display: flex;
            align-items: center;
            justify-content: space-between; /* Distribute space between elements */
            margin-left: 12px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 70px; /* Adjust the height of the logo */
            width: auto; /* Keeps the logo's aspect ratio */
            margin-right: 12px; /* Space between the logo and text */
        }

        .header-text {
            font-size: 1.7em;
            margin: 0;
            color: #fff;
            letter-spacing: 0.1em;
        }

        .logout-link img {
            transition: opacity 0.3s ease;
        }

        .logout-link:hover img {
            opacity: 0.8; /* Slight fade effect when hovering over the image */
        }

        body::before {
            content: "";
            display: block;
            height: 80px; /* Height of the header */
        }

        .user-info {
    position: relative;
    display: inline-flex;
    right: -260px;
    align-items: right;
    color: #fff;
    font-size: 16px;
}

.logout-link {
    margin-left: 30px;
    color:rgb(249, 248, 248);
    font-size: 18px;
    text-decoration:none;
}

.logout-link i {
    cursor: pointer;
    transition: opacity 0.3s ease;
}

.logout-link i:hover {
    opacity: 0.8; /* Hover effect */
}

/* Responsive Styles */
@media screen and (max-width: 1024px) {
    .header-text {
        font-size: 1.5em;
    }
    .logo img {
        height: 60px;
    }
}

@media screen and (max-width: 768px) {
    .site-header {
        flex-direction: column;
        height: auto;
        padding: 10px 0;
    }
    
    .container1 {
        flex-direction: column;
        text-align: center;
    }
    
    .header-text {
        font-size: 1.4em;
        margin-top: 5px;
    }
    
    .logo img {
        height: 55px;
    }
    
    .user-info {
        flex-direction: column;
        align: center;
        font-size: 12px;
        margin-top: 10px;
    }
    
    .logout-link {
    display: flex;
    align-items: center;
    justify-content: center;
    
}


}

@media screen and (max-width: 480px) {
    .header-text {
        font-size: 1.2em;
    }
    
    .logo img {
        height: 50px;
    }
    
    .user-info {
        font-size: 12px;
        text-align: center;
        left: 0;
    }
    
    .logout-link {
        font-size: 14px;
        
    }

    .logout-link img {
        max-width: 60px; /* Further reduce size for very small screens */
    }
}


    </style>
</head>
<body>
    <header class="site-header">
        <div class="container1">
        <div class="logo">
        <?php


// Redirect based on user type when clicking the logo
$logo_link = 'fire-company/index.php'; // Default link for non-logged-in users

// if (isset($_SESSION['user_type'])) {
//     switch ($_SESSION['user_type']) {
//         case 'user':
//             $logo_link = 'seat_booking.php';
//             break;
//             case 'com_super_admin':
//                 $logo_link = 'super_admin_home.php';
//                 break;
//         case 'super_admin':
//             $logo_link = 'super_admin_home.php';
//             break;
//     }
// }
?>

    <a href="<?php echo $logo_link; ?>" class="logout-link">
        <img src="img/slr.gif" alt="Logo">
    </a>
    <h1 class="header-text">SEMT System</h1>
</div>

<div class="user-info">
<a href="<?php echo $logo_link; ?>" class="logout-link">
    <?php
    //Check if the current page is not index.php or user_login.php
    $current_page = basename($_SERVER['PHP_SELF']);
    if ($current_page != 'index.php' && $current_page != 'login.php' && isset($_SESSION['user_name'])) {
        echo '<span class="username">Welcome, ' . htmlspecialchars($_SESSION['user_name']) . '</span>';
        
        // Logout icon
        echo '<a href="logout.php" class="logout-link" title="Logout">';
        echo '<i class="fas fa-sign-out-alt"></i>';
        echo '</a>';
    }
    ?>
</div>

        
    </header>

    <!-- <script>
        let lastScrollTop = 0;
        const header = document.querySelector('.site-header');

        window.addEventListener('scroll', function() {
            let currentScroll = window.pageYOffset || document.documentElement.scrollTop;

            if (currentScroll > lastScrollTop) {
                // Scroll Down
                header.style.top = "-80px"; // Adjust based on header height
            } else {
                // Scroll Up
                header.style.top = "0";
            }

            lastScrollTop = currentScroll <= 0 ? 0 : currentScroll;
        });
    </script> -->

   


</body>
</html>
