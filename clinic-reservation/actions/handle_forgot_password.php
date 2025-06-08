<?php
require '../config/db.php';

$email = $_POST['email'] ?? '';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (empty($email)) {
        $error = "Please enter your email.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $success = "A password reset link has been sent to your email.";
        } else {
            $error = "No account found with that email.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Forgot Password</title>
    <style>
        body {
            background: #fff;
            color: #333;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .container {
            background: #f9f9f9;
            padding: 2rem 3rem;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            width: 360px;
            text-align: center;
        }

        h2 {
            margin-bottom: 1.5rem;
            font-weight: 700;
            letter-spacing: 1px;
            color: #2c3e50;
        }

        input[type="email"] {
            width: 100%;
            padding: 0.7rem;
            margin-bottom: 1rem;
            border: 1.5px solid #ccc;
            border-radius: 5px;
            font-size: 1rem;
            transition: border-color 0.3s ease;
        }

        input[type="email"]:focus {
            outline: none;
            border-color: #2980b9;
            box-shadow: 0 0 8px rgba(41, 128, 185, 0.4);
        }

        button {
            background: #2980b9;
            color: #fff;
            border: none;
            padding: 0.8rem 1.5rem;
            font-weight: 700;
            border-radius: 5px;
            cursor: pointer;
            transition: background 0.3s ease;
            width: 100%;
        }

        button:hover {
            background: #1c5980;
        }

        .error, .success {
            margin: 1rem 0;
            padding: 0.7rem;
            border-radius: 5px;
            font-weight: 600;
            font-size: 0.95rem;
        }

        .error {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        .success {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        a {
            color: #2980b9;
            text-decoration: none;
            font-weight: 600;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Forgot Password</h2>

        <?php if ($error): ?>
            <div class="error"><?= htmlspecialchars($error) ?></div>
        <?php elseif ($success): ?>
            <div class="success"><?= htmlspecialchars($success) ?></div>
        <?php endif; ?>

        <form method="POST" action="">
            <input 
                type="email" 
                name="email" 
                placeholder="Enter your email" 
                value="<?= htmlspecialchars($email) ?>" 
                required 
            />
            <button type="submit">Send Reset Link</button>
        </form>

        <p><a href="../public/index.php">Back to login</a></p>
    </div>
</body>
</html>