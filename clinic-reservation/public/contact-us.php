<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact Us</title>
    <link rel="stylesheet" href="index-register.css">
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('clinic1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .navbar {
            width: 100%;
            background-color: #ffffff;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            margin: 0 20px;
            font-size: 16px;
        }

        .navbar a:hover {
            color: #007BFF;
        }

        .content {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 40px 20px;
        }

        .contact-box {
            background: #ffffff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }

        .contact-links {
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 20px;
        }

        .contact-links a {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .contact-links a:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="index.php">Login</a>
        <a href="about-us.php">About Us</a>
    </div>

    <div class="content">
        <div class="contact-box">
            <h2>Contact Us</h2>
            <p>
                Have questions, concerns, or just need to get in touch? <br>
                We’re always here to help.
            </p>
            <div class="contact-links">
                <a href="https://youtu.be/QOhmcbfwxnA?si=p3IWp31CWPxsMUcR" target="_blank">Facebook</a>
                <a href="https://youtu.be/kOG0_qjKWEI?si=0YLYSA2MDFD9w1ST" target="_blank">Email</a>
                <a href="https://www.youtube.com/watch?v=dQw4w9WgXcQ" target="_blank">Call Us</a>
            </div>
        </div>
    </div>

</body>
</html>