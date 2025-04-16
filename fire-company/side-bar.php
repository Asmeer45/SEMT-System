


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="styles.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        /* Basic styles for the sidebar */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

.sidebar {
    width: 275px;
    height: 100%;
    background-color: #333;
    color: white;
    position: fixed;
    padding: 20px;
    transition: width 0.3s;
    display: flex;
            flex-direction: column;
            justify-content: flex-start;
    margin-top: 80px;
}

.sidebar h2 {
    color: #fff;
    text-align: center;
}

.sidebar a {
    display: block;
    color: #fff;
    text-decoration: none;
    padding: 10px;
    margin: 10px 0;
    background-color: #444;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.sidebar a:hover,
.sidebar a.active {
    background-color: #007bff;
}

.sidebar i {
    display: block;
    margin: 40px auto;
}

/* Media Query for Mobile Devices */
@media (max-width: 768px) {
    .sidebar {
        width: 100%;
        height: auto;
        position: relative;
    }

    .sidebar h2 {
        font-size: 18px;
    }

    .sidebar a {
        padding: 12px;
        font-size: 14px;
    }

    .sidebar i {
        font-size: 2em;
        margin-top: 20px;
    }
}

@media (max-width: 480px) {
    .sidebar {
        width: 100%;
    }

    .sidebar a {
        padding: 15px;
        font-size: 16px;
    }

    .sidebar i {
        font-size: 2.5em;
        margin-top: 20px;
    }
}
</style>
</head>
<body>
    <!-- side-bar.php -->
<div class="sidebar">
    <!-- <h2>Navigation</h2> -->
    <a href="index.php">All Tasks</a>
    <a href="pending.php">Pending Tasks</a>
    <a href="progress.php" >In Progress</a>
    <a href="completed.php">Completed</a>
    <a href="../logout.php">Logout</a>
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <i class="fas fa-fire-extinguisher" style="font-size: 3em; color: red; margin-left: 100px; margin-top: 40px;"></i>
    <h2>Fire Extinguishers</h2>
</div>

<script>
        // Select all navigation links
        const navLinks = document.querySelectorAll('.sidebar a');

        // Check if there's an active link saved in localStorage
        const activeLink = localStorage.getItem('activeLink');

        // If there's a saved active link, set it as active
        if (activeLink) {
            document.querySelector(activeLink).classList.add('active');
        }

        // Add click event listener to each link
        navLinks.forEach(link => {
            link.addEventListener('click', function () {
                // Remove the "active" class from all links
                navLinks.forEach(nav => nav.classList.remove('active'));

                // Add the "active" class to the clicked link
                this.classList.add('active');

                // Save the clicked link's selector in localStorage
                localStorage.setItem('activeLink', `a[href="${this.getAttribute('href')}"]`);
            });
        });
    </script>

</body>
</html>