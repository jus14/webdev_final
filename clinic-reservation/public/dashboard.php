<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user = $_SESSION['user'];
$user_id = $user['id'];

$first_name = isset($user['first_name']) ? $user['first_name'] : '';
$last_name = isset($user['last_name']) ? $user['last_name'] : '';
$middle_initial = isset($user['middle_initial']) ? $user['middle_initial'] : '';

$user_name = htmlspecialchars("$last_name, $first_name " . strtoupper($middle_initial));

$today = date('Y-m-d');

$sql = "SELECT a.id, a.appointment_date, a.appointment_time, d.name AS doctor_name, d.specialty 
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.id
        WHERE a.user_id = ? AND a.appointment_date >= ?
        ORDER BY a.appointment_date, a.appointment_time";

$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $user_id, $today);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <link rel="stylesheet" href="dashboard.css">
    <style>
    
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('clinic2.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .container {
            max-width: 900px;
            margin: 30px auto 50px auto;
            padding: 30px 40px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #ddd;
            box-sizing: border-box;
        }

        h2, h3 {
            text-align: center;
            color: #333;
        }

        .styled-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .styled-table th,
        .styled-table td {
            padding: 10px;
            border: 1px solid #ccc;
            text-align: center;
        }

        .styled-table th {
            background-color: #f2f2f2;
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 15px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #45a049;
        }

        .btn.logout {
            background-color: #f44336;
        }

        .btn.logout:hover {
            background-color: #da190b;
        }

        .btn.cancel {
            background-color: #e57373;
        }

        .btn.cancel:hover {
            background-color: #d32f2f;
        }

        .btn.small {
            padding: 5px 10px;
            font-size: 0.9em;
        }

        .dashboard-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }

        a {
            font-size: 14px;
            color: #007bff;
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <div class="header">
        <h2 class="welcome-text">Welcome, <?= $user_name ?></h2>
    </div>

    <div class="container">
        <h3>Your Upcoming Appointments</h3>

        <?php if ($result->num_rows === 0): ?>
            <p>You have no upcoming appointments. <a href="book.php" class="link">Book one now</a></p>
        <?php else: ?>
            <table class="styled-table">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Doctor</th>
                        <th>Specialty</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($appt = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($appt['appointment_date']) ?></td>
                        <td>
                            <?php
                            $timeObj = DateTime::createFromFormat('H:i:s', $appt['appointment_time']);
                            echo $timeObj ? $timeObj->format('g:i A') : $appt['appointment_time'];
                            ?>
                        </td>
                        <td><?= htmlspecialchars($appt['doctor_name']) ?></td>
                        <td><?= htmlspecialchars($appt['specialty']) ?></td>
                        <td>
                            <a href="reschedule.php?id=<?= $appt['id'] ?>" class="btn small">Reschedule</a>
                            <a href="cancel_appointment.php?id=<?= $appt['id'] ?>" class="btn cancel small" onclick="return confirm('Are you sure you want to cancel this appointment?');">Cancel</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php endif; ?>

        <div class="dashboard-links">
            <a href="book.php" class="btn">Book Appointment</a>
            <a href="logout.php" class="btn logout">Logout</a>
        </div>
    </div>

</body>
</html>