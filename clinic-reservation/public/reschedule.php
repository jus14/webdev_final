<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user']['id'];

if (!isset($_GET['id'])) {
    header("Location: dashboard.php");
    exit;
}

$appointment_id = (int)$_GET['id'];

$sql = "SELECT a.*, d.name AS doctor_name, d.specialty, d.start_time, d.end_time
        FROM appointments a
        JOIN doctors d ON a.doctor_id = d.id
        WHERE a.id = ? AND a.user_id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $appointment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: dashboard.php");
    exit;
}

$appointment = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $date = $_POST['appointment_date'];
    $hour = (int)$_POST['hour'];
    $minute = (int)$_POST['minute'];
    $ampm = $_POST['ampm'];

    if ($ampm === 'PM' && $hour != 12) $hour += 12;
    if ($ampm === 'AM' && $hour == 12) $hour = 0;

    $time = sprintf('%02d:%02d:00', $hour, $minute);

    $selected_datetime = strtotime($date . ' ' . $time);
    $current_datetime = time();

    if ($selected_datetime < $current_datetime) {
        $error = "You cannot reschedule to a past date.";
    }
    elseif ($time < $appointment['end_time']) {
        $error = "selected time is outside the doctor's available hours ({$appointment['start_time']} - {$appointment['end_time']}).";
    } else {
        $conflict_sql = "SELECT id FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ? AND id != ?";
        $conflict_stmt = $conn->prepare($conflict_sql);
        $conflict_stmt->bind_param("issi", $appointment['doctor_id'], $date, $time, $appointment_id);
        $conflict_stmt->execute();
        $conflict_result = $conflict_stmt->get_result();

        if ($conflict_result->num_rows > 0) {
            $error = "The selected time slot is already booked for this doctor.";
        } else {
            $update_sql = "UPDATE appointments SET appointment_date = ?, appointment_time = ? WHERE id = ? AND user_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ssii", $date, $time, $appointment_id, $user_id);
            if ($update_stmt->execute()) {
                header("Location: dashboard.php?msg=Appointment updated successfully");
                exit;
            } else {
                $error = "Failed to update appointment.";
            }
        }
    }
}


$timeObj = DateTime::createFromFormat('H:i:s', $appointment['appointment_time']);
$default_hour = (int)$timeObj->format('g');
$default_minute = (int)$timeObj->format('i');
$default_ampm = $timeObj->format('A');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reschedule Appointment</title>
    <link rel="stylesheet" href="reschedule.css">
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-image: url('clinic3.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h2 {
            margin-bottom: 25px;
            color: #222;
        }

        form table {
            margin: 0 auto;
            border-collapse: separate;
            border-spacing: 12px 20px;
            width: 380px;
            background: #fff;
            padding: 25px 30px;
            border-radius: 10px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        form table td {
            vertical-align: middle;
            text-align: left;
        }

        label {
            font-weight: 600;
            color: #444;
        }

        input[type="date"],
        select {
            width: 100%;
            padding: 8px 10px;
            font-size: 15px;
            border-radius: 6px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }

        button {
            background-color: #e91e63;
            color: white;
            font-weight: 700;
            padding: 12px 0;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }

        button:hover {
            background-color: #c2185b;
        }

        .error {
            color: #d32f2f;
            font-weight: 600;
            text-align: center;
            padding-bottom: 10px;
        }

        .back-link {
            color: #e91e63;
            font-weight: 600;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <h2>Reschedule Appointment with <?= htmlspecialchars($appointment['doctor_name']) ?> (<?= htmlspecialchars($appointment['specialty']) ?>)</h2>

    <form method="POST" action="">
        <table>
            <?php if (!empty($error)): ?>
            <tr>
                <td colspan="2" class="error"><?= htmlspecialchars($error) ?></td>
            </tr>
            <?php endif; ?>
            <tr>
                <td><label for="appointment_date">Date:</label></td>
                <td><input type="date" name="appointment_date" id="appointment_date" value="<?= htmlspecialchars($appointment['appointment_date']) ?>" required></td>
            </tr>
            <tr>
                <td><label>Time:</label></td>
                <td>
                    <select name="hour" required>
                        <?php 
                        $start_hour_24 = (int)substr($appointment['start_time'], 0, 2);
                        $end_hour_24 = (int)substr($appointment['end_time'], 0, 2);

                        for ($h = 1; $h <= 12; $h++):
                            foreach (['AM', 'PM'] as $ampm_option) {
                                $converted_hour = $h;
                                if ($ampm_option === 'PM' && $h != 12) $converted_hour += 12;
                                if ($ampm_option === 'AM' && $h == 12) $converted_hour = 0;

                                if ($converted_hour >= $start_hour_24 && $converted_hour <= $end_hour_24):
                                    $selected = ($default_hour == $h && $default_ampm == $ampm_option) ? 'selected' : '';
                        ?>
                                <option value="<?= $h ?>" <?= $selected ?>><?= $h ?> <?= $ampm_option ?></option>
                        <?php
                                endif;
                            }
                        endfor;
                        ?>
                    </select> :

                    <select name="minute" required>
                        <?php for ($m = 0; $m < 60; $m++): 
                            $selected = ($default_minute == $m) ? 'selected' : '';
                        ?>
                            <option value="<?= str_pad($m, 2, '0', STR_PAD_LEFT) ?>" <?= $selected ?>><?= str_pad($m, 2, '0', STR_PAD_LEFT) ?></option>
                        <?php endfor; ?>
                    </select>

                    <select name="ampm" required>
                        <option value="AM" <?= ($default_ampm === 'AM') ? 'selected' : '' ?>>AM</option>
                        <option value="PM" <?= ($default_ampm === 'PM') ? 'selected' : '' ?>>PM</option>
                    </select>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <button type="submit">Update Appointment</button>
                </td>
            </tr>
            <tr>
                <td colspan="2" style="text-align:center;">
                    <a href="dashboard.php" class="back-link">Back to Dashboard</a>
                </td>
            </tr>
        </table>
    </form>
</body>
</html>