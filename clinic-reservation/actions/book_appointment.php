<?php
session_start();
require '../config/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: ../public/index.php");
    exit;
}

$user_id = $_SESSION['user']['id'];
$doctor_id = $_POST['doctor_id'];
$date = $_POST['appointment_date'];
$hour = (int)$_POST['hour'];
$minute = (int)$_POST['minute'];
$ampm = $_POST['ampm'];

if ($ampm === 'PM' && $hour != 12) $hour += 12;
if ($ampm === 'AM' && $hour == 12) $hour = 0;

$time = sprintf('%02d:%02d:00', $hour, $minute);

$appointment_datetime_str = ($date . ' ' . $time);
$appointment_datetime = strtotime($appointment_datetime_str);
$current_datetime = time();

if ($appointment_datetime < $current_datetime) {
    header("Location: ../public/invalid_time.php");
    exit;
}

$check_sql = "SELECT * FROM appointments WHERE doctor_id = ? AND appointment_date = ? AND appointment_time = ?";
$check_stmt = $conn->prepare($check_sql);
$check_stmt->bind_param("iss", $doctor_id, $date, $time);
$check_stmt->execute();
$check_result = $check_stmt->get_result();

if ($check_result->num_rows > 0) {
    header("Location: ../public/booking_conflict.php");
    exit;
}

$sql = "INSERT INTO appointments (user_id, doctor_id, appointment_date, appointment_time)
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("iiss", $user_id, $doctor_id, $date, $time);

if ($stmt->execute()) {
    header("Location: ../public/appointment_success.php");
    exit;
} else {
    echo "An error occurred while booking your appointment: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>  