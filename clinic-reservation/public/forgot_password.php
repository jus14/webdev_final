<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="index-register.css">
</head>
<body>
    <div class="container">
        <h2>Recover Password</h2>
        <form action="../actions/handle_forgot_password.php" method="POST">
            <input type="email" name="email" placeholder="Enter your email" required>
            <button type="submit">Send Reset Link</button>
        </form>
        <p><a href="index.php">Back to login</a></p>
    </div>
</body>
</html>