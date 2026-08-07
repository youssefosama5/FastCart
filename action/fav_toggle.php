<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=utf-8');
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'needLogin' => true, 'message' => 'Please log in first to add to favorites']);
    exit;
}

$userId    = (int) $_SESSION['user_id'];
$productId = isset($_POST['product_id']) ? (int) $_POST['product_id'] : 0;

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'Invalid product']);
    exit;
}

$stmt = $conn->prepare('SELECT id FROM favorites WHERE user_id = ? AND product_id = ?');
$stmt->bind_param('ii', $userId, $productId);
$stmt->execute();
$row = $stmt->get_result()->fetch_assoc();

if ($row) {
    $del = $conn->prepare('DELETE FROM favorites WHERE id = ?');
    $del->bind_param('i', $row['id']);
    $del->execute();
    $added = false;
} else {
    $check = $conn->prepare('SELECT id FROM products WHERE id = ?');
    $check->bind_param('i', $productId);
    $check->execute();
    $product = $check->get_result()->fetch_assoc();

    if (!$product) {
        echo json_encode(['success' => false, 'message' => 'This product is not available right now']);
        exit;
    }

    $ins = $conn->prepare('INSERT INTO favorites (user_id, product_id) VALUES (?, ?)');
    $ins->bind_param('ii', $userId, $productId);
    $ins->execute();
    $added = true;
}

$countRes = $conn->prepare('SELECT COUNT(*) AS c FROM favorites WHERE user_id = ?');
$countRes->bind_param('i', $userId);
$countRes->execute();
$favCount = (int) $countRes->get_result()->fetch_assoc()['c'];

$message = $added ? 'Product added to favorites' : 'Product removed from favorites';

echo json_encode(['success' => true, 'added' => $added, 'favCount' => $favCount, 'message' => $message]);
