<?php
require_once __DIR__ . '/../config/session.php';
header('Content-Type: application/json; charset=utf-8');
require '../config/db.php';

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['success' => false, 'needLogin' => true, 'message' => 'Please log in first to place an order']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Invalid request method']);
    exit;
}

$userId      = (int) $_SESSION['user_id'];
$fullName    = trim($_POST['full_name'] ?? '');
$phone       = trim($_POST['phone'] ?? '');
$address     = trim($_POST['address'] ?? '');
$city        = trim($_POST['city'] ?? '');
$postalCode  = trim($_POST['postal_code'] ?? '');
$payment     = trim($_POST['payment_method'] ?? 'cash');

if ($fullName === '' || $phone === '' || $address === '' || $city === '') {
    echo json_encode(['success' => false, 'message' => 'Please fill in all required shipping fields']);
    exit;
}

if (!in_array($payment, ['cash', 'card'], true)) {
    $payment = 'cash';
}

// Get the current cart items with their live product data
$stmt = $conn->prepare(
    'SELECT p.id AS id, p.title AS title, p.price AS price, c.quantity AS qun
     FROM cart c
     JOIN products p ON p.id = c.product_id
     WHERE c.user_id = ?'
);
$stmt->bind_param('i', $userId);
$stmt->execute();
$result = $stmt->get_result();

$items = [];
while ($row = $result->fetch_assoc()) {
    $items[] = $row;
}

if (empty($items)) {
    echo json_encode(['success' => false, 'message' => 'Your cart is empty']);
    exit;
}

$total = 0;
foreach ($items as $item) {
    $total += $item['price'] * $item['qun'];
}

$conn->begin_transaction();

try {
    $orderStmt = $conn->prepare(
        'INSERT INTO orders (user_id, full_name, phone, address, city, postal_code, payment_method, total, status)
         VALUES (?, ?, ?, ?, ?, ?, ?, ?, "pending")'
    );
    $orderStmt->bind_param('issssssd', $userId, $fullName, $phone, $address, $city, $postalCode, $payment, $total);
    $orderStmt->execute();
    $orderId = $orderStmt->insert_id;

    $itemStmt = $conn->prepare(
        'INSERT INTO order_items (order_id, product_id, title, price, quantity) VALUES (?, ?, ?, ?, ?)'
    );
    foreach ($items as $item) {
        $itemStmt->bind_param('iisdi', $orderId, $item['id'], $item['title'], $item['price'], $item['qun']);
        $itemStmt->execute();
    }

    $clearStmt = $conn->prepare('DELETE FROM cart WHERE user_id = ?');
    $clearStmt->bind_param('i', $userId);
    $clearStmt->execute();

    $conn->commit();

    echo json_encode(['success' => true, 'orderId' => $orderId, 'cartCount' => 0, 'message' => 'Your order has been placed successfully, it will arrive soon']);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['success' => false, 'message' => 'Something went wrong while placing your order, please try again']);
}
