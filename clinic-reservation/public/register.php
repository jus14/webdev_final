<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    <link rel="stylesheet" href="index-register.css">

</head>
<body>
<?php require 'components/header.php'; ?>
<div class="page-content">
    <div class="container">
        <h2>Register</h2>
        <form action="../actions/handle_register.php" method="POST">

            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>

            <input type="text" name="middle_initial" placeholder="Middle Initial" maxlength="1" required>
            <input type="number" name="age" placeholder="Age" min="0" required>

            <input type="date" name="birthdate" required>

            <select name="gender" required>
                <option value="" disabled selected>Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>

            <input type="text" name="contact_number" placeholder="Contact Number" required>

            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Register</button>
        </form>
        <p><a href="index.php">Already have an account? Login</a></p>
    </div>
</div>
<?php require 'components/footer.php'; ?>
</body>
</html>