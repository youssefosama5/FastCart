<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=utf-8');
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'needLogin' => true, 'message' => 'Please log in first']);
    exit;
}

$userId    = (int) $_SESSION['user_id'];
$productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

$del = $conn->prepare('DELETE FROM cart WHERE user_id = ? AND product_id = ?');
$del->bind_param('ii', $userId, $productId);
$del->execute();

$countRes = $conn->prepare('SELECT COUNT(*) AS c FROM cart WHERE user_id = ?');
$countRes->bind_param('i', $userId);
$countRes->execute();
$cartCount = (int) $countRes->get_result()->fetch_assoc()['c'];

echo json_encode(['success' => true, 'cartCount' => $cartCount]);
