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
$op        = $_POST['op'] ?? '';

$stmt = $conn->prepare('SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?');
$stmt->bind_param('ii', $userId, $productId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if (!$row) {
    echo json_encode(['success' => false, 'message' => 'This item is not in the cart']);
    exit;
}

$qty = (int) $row['quantity'];
if ($op === 'increase') {
    $qty += 1;
} elseif ($op === 'decrease' && $qty > 1) {
    $qty -= 1;
}

$upd = $conn->prepare('UPDATE cart SET quantity = ? WHERE id = ?');
$upd->bind_param('ii', $qty, $row['id']);
$upd->execute();

echo json_encode(['success' => true, 'quantity' => $qty]);
