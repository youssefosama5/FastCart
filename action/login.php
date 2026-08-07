<?php
require_once __DIR__ . '/../config/session.php';
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../pages/login.php');
    exit;
}

$email    = trim($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

function backToLogin($error, $email)
{
    $_SESSION['login_error'] = $error;
    $_SESSION['login_old']   = ['email' => $email];
    header('Location: ../pages/login.php');
    exit;
}

if ($email === '' || $password === '') {
    backToLogin('Please enter your email and password', $email);
}

$stmt = $conn->prepare('SELECT id, name, password FROM users WHERE email = ?');
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id']   = $user['id'];
    $_SESSION['user_name'] = $user['name'];
    header('Location: ../index.php');
    exit;
} else {
    backToLogin('Email or password is incorrect, please check and try again', $email);
}
