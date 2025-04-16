<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SEMT System</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@700&family=Dancing+Script:wght@700&display=swap');

        body {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', Arial, sans-serif;
            background: url('img/m13.jpg') no-repeat center center/cover;
            height: 100vh;
            color: #fff;
            background-size: cover;
            background-attachment: fixed;
                        /*background: rgba(0, 0, 0, 0.6); /* Adds a dark overlay */
        }

        .overlay {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.6); /* Adjust darkness */
}
        
        
        .container {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 90%;
            margin-bottom: 70px;
            text-align: center;

            padding: 20px;
        }

        h1 {
            font-size: 3em;
            margin: 0.5em 0;
            line-height: 1.2;
        }

        h1 span {
            font-family: 'Dancing Script', cursive;
            font-size: 1.5em;
            display: block;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 1em;
        }

        .login-btn {
            padding: 0.7em 2em;
            font-size: 1em;
            color: #fff;
            background: #007BFF;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        .login-btn:hover {
            background: #0056b3;
        }

        /* Mobile responsiveness */
        @media screen and (max-width: 768px) {
            h1 {
                font-size: 2.5em;
            }

            h1 span {
                font-size: 1.2em;
            }

            .login-btn {
                padding: 0.6em 1.5em;
                font-size: 0.9em;
            }

            .container {
                padding: 15px;
            }
        }

        @media screen and (max-width: 480px) {
            h1 {
                font-size: 2em;
            }

            h1 span {
                font-size: 1em;
            }

            .login-btn {
                padding: 0.5em 1.2em;
                font-size: 0.8em;
            }

            .container {
                padding: 10px;
            }
        }
    </style>
</head>
<body>
<?php
include('include/header.php');
?>
<div class="overlay">
    <div class="container">
        <h1>
            <span>Welcome to</span>
            Station Equipment <br> Maintenance Tracking System
        </h1>
        <button class="login-btn" onclick="navigateToLogin()">Login</button>
    </div>
    </div>
    <script>
        function navigateToLogin() {
            // Redirect to the login page
            window.location.href = 'login.php';
        }
    </script>
</body>
</html>
