<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error 404 - Page Not Found</title>
    <style>
        *{
            font-family: 'Poppins', sans-serif;  
        }
        
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            margin: 0;
            height: 100vh; /* Full height of the viewport */
            display: flex;
            flex-direction: column;
            justify-content: center; /* Center vertically */
            align-items: center; /* Center horizontally */
            background-color: #fff; /* Dark background color */
            color: black; /* White text color */
        }
        h1 {
            font-size: 50px;
            margin: 0; /* Remove default margin */
        }
        p {
            font-size: 20px;
            margin: 10px 0; /* Add some margin for spacing */
        }
        img {
            max-width: 20%; /* Responsive width */
            height: auto; /* Maintain aspect ratio */
            margin-top: 17px; /* Space above the GIF */
        }
        /* Responsive Design */
@media (max-width: 768px) {
    h1 {
        font-size: 30px;
    }
    p {
        font-size: 18px;
    }
    img {
        max-width: 70%;
    }
}

@media (max-width: 480px) {
    h1 {
        font-size: 24px;
    }
    p {
        font-size: 16px;
    }
    img {
        max-width: 80%;
    }
}
    </style>
</head>
<body>
    <h1>404 - Page Not Found</h1>
    
    <img src="../img/Bee lounging.gif" alt="404 Animation"> <!-- Add your GIF here -->
    <p>The page you are trying to access is not available.</p>
</body>
</html>
