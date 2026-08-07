<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=utf-8');
require '../config/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$name    = trim($_POST['name'] ?? '');
$email   = trim($_POST['email'] ?? '');
$subject = trim($_POST['subject'] ?? '');
$message = trim($_POST['message'] ?? '');

if ($name === '' || $email === '' || $subject === '' || $message === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill in all fields']);
    exit;
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['success' => false, 'message' => 'Email format is not valid']);
    exit;
}

$stmt = $conn->prepare('INSERT INTO contacts (name, email, subject, message) VALUES (?, ?, ?, ?)');
$stmt->bind_param('ssss', $name, $email, $subject, $message);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Your message has been sent successfully, we will get back to you soon']);
} else {
    echo json_encode(['success' => false, 'message' => 'Something went wrong, please try again']);
}
