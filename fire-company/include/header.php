<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
            * {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            margin-top: 0px; /* Add space for the fixed navbar */
        }

        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 20px;
            background-color: #333;
            color: #fff;
            width: 100%;
            height: 80px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
            transition: top 0.3s;
        }

        .navbar img {
            height: 70px;
            width: auto;
            margin-right: 20px;
        }

        .navbar h1 {
            font-size: 1.7em;
            color: #fff;
            letter-spacing: 0.1em;
        }

        .nav-user-name {
            color: #fff;
            font-size: 16px;
        }

        /* Responsive Design */
        @media screen and (max-width: 768px) {
            .navbar {
                flex-direction: column;
                height: 80px;
                padding: 15px;
            }

            .navbar h1 {
                font-size: 1.5em;
                margin-top: 10px;
                text-align: center;
            }

            .navbar img {
                height: 70px;
                margin-right: 0;
                margin-bottom: 10px;
            }

            .nav-user-name {
                font-size: 14px;
                text-align: center;
                margin-top: 10px;
            }
        }

        @media screen and (max-width: 480px) {
            .navbar {
                padding: 10px 15px;
                height: 80px;
            }

            .navbar h1 {
                font-size: 1.3em;
            }

            .navbar img {
                height: 70px;
            }

            .nav-user-name {
                font-size: 12px;
            }
        }
    </style>
</head>
<body>
    <div class="navbar">
        <div style="display: flex; align-items: center;">
            <a href='index.php'><img src="../img/slr.gif" alt="Logo"></a>
            <h1>SEMT System</h1>
        </div>
        
    </div>
</body>
</html>
