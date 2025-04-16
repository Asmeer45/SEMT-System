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
            margin-left: 0px;
        }

        .logo {
            display: flex;
            align-items: center;
        }

        .logo img {
            height: 70px; /* Adjust the height of the logo */
            width: auto; /* Keeps the logo's aspect ratio */
            margin-right: 0px; /* Space between the logo and text */
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

/* Responsive Design */
@media (max-width: 1024px) {
    .header-text {
        font-size: 1.3em;
    }

    .logo img {
        height: 70px;
    }

    .logout-link i {
        font-size: 18px;
    }
}

@media (max-width: 768px) {
    .site-header {
        height: 70px;
        padding: 0 15px;
    }

    .header-text {
        font-size: 1.2em;
    }

    .logo img {
        height: 70px;
    }

    .user-info {
        font-size: 14px;
    }

    .logout-link {
        font-size: 16px;
    }
}

@media (max-width: 480px) {
    .site-header {
        height: 80px;


    }

    .container1 {
        flex-direction: column;
        justify-content: space-between;
        margin: 0 ;
        padding: 0;
        width: 100%;
    }

    .logo img {
        height: 70px;
        width: auto;
        margin-left:-70px;

    }

    .header-text {
        margin-top:10px;

        font-size: 20px;
    }

    .user-info {
        font-size: 12px;
    }

    .logout-link i {
        font-size: 16px;
    }
}


    </style>
</head>
<body>
    <header class="site-header">
        <div class="container1">
        <div class="logo">


    <a href="station-dashboard.php" class="logout-link">
        <img src="img/slr.gif" alt="Logo">
    </a>
    <h1 class="header-text">SEMT System</h1>
</div>


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
