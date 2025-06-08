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

$sql = "SELECT id FROM appointments WHERE id = ? AND user_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $appointment_id, $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: dashboard.php");
    exit;
}

$del_sql = "DELETE FROM appointments WHERE id = ? AND user_id = ?";
$del_stmt = $conn->prepare($del_sql);
$del_stmt->bind_param("ii", $appointment_id, $user_id);
if ($del_stmt->execute()) {
    header("Location: dashboard.php?msg=Appointment cancelled successfully");
    exit;
} else {
    echo "Failed to cancel appointment.";
}
?>