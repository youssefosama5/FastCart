<?php
require_once __DIR__ . '/../config/session.php';
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/register.php');
    exit;
}

$name     = trim($_POST['name'] ?? '');
$email    = trim($_POST['email'] ?? '');
$phone    = trim($_POST['phone'] ?? '');
$password = $_POST['password'] ?? '';

$egyptPhonePattern = '/^01[0125][0-9]{8}$/';

function backToRegister($error, $name, $email, $phone)
{
    $_SESSION['register_error'] = $error;
    $_SESSION['register_old']   = ['name' => $name, 'email' => $email, 'phone' => $phone];
    header('Location: ../pages/register.php');
    exit;
}

if ($name === '' || $email === '' || $phone === '' || $password === '') {
    backToRegister('Please fill in all required fields', $name, $email, $phone);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    backToRegister('Email format is not valid', $name, $email, $phone);
}

if (!preg_match($egyptPhonePattern, $phone)) {
    backToRegister('Phone number must be a valid Egyptian number: starts with 010, 011, 012 or 015 and is exactly 11 digits', $name, $email, $phone);
}

if (strlen($password) < 6) {
    backToRegister('Password must be at least 6 characters', $name, $email, $phone);
}

$stmt = $conn->prepare('SELECT id FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    backToRegister('This email is already registered — try logging in instead', $name, $email, $phone);
}
$stmt->close();

$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare('INSERT INTO users (name, email, phone, password) VALUES (?, ?, ?, ?)');
$stmt->bind_param('ssss', $name, $email, $phone, $hashedPassword);

if ($stmt->execute()) {
    $_SESSION['user_id']   = $stmt->insert_id;
    $_SESSION['user_name'] = $name;
    header('Location: ../index.php');
    exit;
} else {
    backToRegister('Something went wrong during registration, please try again', $name, $email, $phone);
}
