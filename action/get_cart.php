<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=utf-8');
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['items' => [], 'needLogin' => true]);
    exit;
}

$userId = (int) $_SESSION['user_id'];

$stmt = $conn->prepare(
    'SELECT p.id AS id, p.title AS title, p.price AS price, p.img AS img, c.quantity AS qun
     FROM cart c
     JOIN products p ON p.id = c.product_id
     WHERE c.user_id = ?
     ORDER BY c.id DESC'
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $row['price'] = (float) $row['price'];
    $row['qun']   = (int) $row['qun'];
    $items[] = $row;
}

echo json_encode(['items' => $items, 'needLogin' => false]);
