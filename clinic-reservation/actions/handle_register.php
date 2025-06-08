<?php
require '../config/db.php';

$first_name = trim($_POST['first_name']);
$last_name = trim($_POST['last_name']);
$middle_initial = trim($_POST['middle_initial']);
$age = (int)$_POST['age'];
$birthdate = $_POST['birthdate'];
$gender = $_POST['gender'];
$contact_number = trim($_POST['contact_number']);
$email = trim($_POST['email']);
$password = password_hash($_POST['password'], PASSWORD_BCRYPT);

$sql = "INSERT INTO users 
    (first_name, last_name, middle_initial, age, birthdate, gender, contact_number, email, password)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param(
    "sssisssss",
    $first_name,
    $last_name,
    $middle_initial,
    $age,
    $birthdate,
    $gender,
    $contact_number,
    $email,
    $password
);

if ($stmt->execute()) {
    header("Location: ../public/index.php");
    exit;
} else {
    echo "Error: " . $stmt->error;
}
?>