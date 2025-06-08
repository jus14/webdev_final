<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>invalid Date</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(255, 131, 141);
            color: #721c24;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .conflict-box {
            background-color: #f5c6cb;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(114, 28, 36, 0.3);
            text-align: center;
            max-width: 400px;
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #721c24;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background: #501215;
        }
    </style>
</head>
<body>
    <div class="conflict-box">
        <h2>Out of date!</h2>
        <p>The selected date is already in the past.</p>
        <p>Please don't go back in the past, choose a different date.</p>
        <a href="book.php">Back to Booking</a>
    </div>
</body>
</html>