<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=utf-8');
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'needLogin' => true, 'message' => 'Please log in first to add to cart']);
    exit;
}

$userId    = (int) $_SESSION['user_id'];
$productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product']);
    exit;
}

$check = $conn->prepare('SELECT title FROM products WHERE id = ?');
$check->bind_param('i', $productId);
$check->execute();
$product = $check->get_result()->fetch_assoc();

if (!$product) {
    echo json_encode(['success' => false, 'message' => 'This product is not available right now']);
    exit;
}

$stmt = $conn->prepare('SELECT id, quantity FROM cart WHERE user_id = ? AND product_id = ?');
$stmt->bind_param('ii', $userId, $productId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row) {
    $newQty = $row['quantity'] + 1;
    $upd = $conn->prepare('UPDATE cart SET quantity = ? WHERE id = ?');
    $upd->bind_param('ii', $newQty, $row['id']);
    $upd->execute();
    $message = 'Cart quantity updated';
} else {
    $ins = $conn->prepare('INSERT INTO cart (user_id, product_id, quantity) VALUES (?, ?, 1)');
    $ins->bind_param('ii', $userId, $productId);
    $ins->execute();
    $message = 'Product added to cart';
}

$countRes  = $conn->prepare('SELECT COUNT(*) AS c FROM cart WHERE user_id = ?');
$countRes->bind_param('i', $userId);
$countRes->execute();
$cartCount = (int) $countRes->get_result()->fetch_assoc()['c'];

echo json_encode(['success' => true, 'message' => $message, 'cartCount' => $cartCount]);
