<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=utf-8');
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'needLogin' => true, 'message' => 'Please log in first']);
    exit;
}

$userId = (int) $_SESSION['user_id'];

$del = $conn->prepare('DELETE FROM cart WHERE user_id = ?');
$del->bind_param('i', $userId);
$del->execute();

echo json_encode(['success' => true, 'cartCount' => 0]);
