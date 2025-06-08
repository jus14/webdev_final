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
    <title>Appointment Confirmed</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background:rgb(184, 255, 137);
            text-align: center;
            padding-top: 50px;
        }
        .box {
            background: white;
            display: inline-block;
            padding: 30px 50px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
        }
        a {
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        a:hover {
            background: #45a049;
        }
    </style>
</head>
<body>
    <div class="box">
        <h2>Appointment Booked Successfully</h2>
        <p>We'll see you soon!</p>
        <a href="dashboard.php">Back to Dashboard</a>
    </div>
</body>
</html>