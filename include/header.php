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



/* Mobile Styling */
@media screen and (max-width: 768px) {
            .container1 {
                padding: 0 0.5em;

            }

            .header-text {
                font-size: 1.4em; /* Smaller font size on mobile */
                text-align: center; /* Center the header text */
                flex: 1;
                margin-top: 10px;
            }

            .logo img {
                height: 60px; /* Slightly smaller logo */
            }

            .user-info {
                justify-content: center; /* Center user info on mobile */
                margin-top: 10px;
            }

            .logout-link {
                margin-left: 0;
            }

            .site-header {
                height: auto;
            }
        }

        @media screen and (max-width: 480px) {
            .header-text {
                font-size: 1.2em; /* Even smaller font size on very small screens */
            }

            .logo img {
                height: 50px; /* Further reduce logo size on very small screens */
            }

            .user-info {
                font-size: 14px; /* Smaller font size for user info */
            }

            .logout-link {
                font-size: 16px; /* Smaller logout icon font size */
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
$logo_link = 'index.php'; // Default link for non-logged-in users

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
