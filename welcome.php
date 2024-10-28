<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to Ribs Circle</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            text-align: center;
        }

        h1 {
            font-size: 3em;
            margin-bottom: 20px;
            color: #e67e22;
        }

        p {
            font-size: 1.2em;
            margin-bottom: 30px;
            padding: 0 20px;
        }

        .buttons {
            margin: 20px 0;
        }

        .buttons button {
            padding: 15px 30px;
            font-size: 1em;
            background-color: #e67e22;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
            margin: 0 10px;
        }

        .buttons button:hover {
            background-color: #d35400;
        }

        .social-media-icons {
            margin-top: 30px;
        }

        .social-media-icons a {
            margin: 0 15px;
            font-size: 1.5em;
            color: #333;
            text-decoration: none;
        }

        .footer {
            margin-top: 50px;
            font-size: 0.9em;
            color: #666;
        }
    </style>
    <script>
        function checkLoginAndRedirect(url) {
    console.log('Button clicked'); // Add this line
    const userId = localStorage.getItem('userId');
    console.log('UserId:', userId); // Add this line
    if (!userId) {
        window.location.href = 'login/login.php';
    } else {
        window.location.href = url;
    }
}

    </script>
</head>

<body>
    <h1>Welcome to Ribs Circle!</h1>
    <p>Discover the best local food experience with us. We can't wait to serve you!</p>
    <div class="buttons">
        <button onclick="checkLoginAndRedirect('index.php')">View Menu</button>
        <button onclick="checkLoginAndRedirect('reservations.php')">Make a Reservation</button>
    </div>
    <div class="social-media-icons">
        <a href="#"><i class="fab fa-facebook-f"></i></a>
        <a href="#"><i class="fab fa-tiktok"></i></a>
        <a href="#"><i class="fab fa-instagram"></i></a>
    </div>
    <div class="footer">
        <p>&copy; 2024 Ribs Circle. All rights reserved.</p>
    </div>
</body>

</html>
