<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
header('Content-Type: application/json; charset=utf-8');
require_once __DIR__ . "/../../Database/database.php";

if (!isset($_POST['product_id'])) {
    header("Location: /Dashboard/index.php");
    exit;
}

$productId = (int)($_POST['product_id'] ?? 0);

if ($productId <= 0) {
    echo json_encode(['success' => false, 'message' => 'ID không hợp lệ']);
    exit;
}

// Lấy sản phẩm
$sql = "SELECT id, name, price, image FROM product WHERE id = $productId AND is_active = 1";
$result = $conn->query($sql);

if ($result->num_rows === 0) {
    echo json_encode(['success' => false, 'message' => 'Sản phẩm không tồn tại']);
    exit;
}

$product = $result->fetch_assoc();

// Khởi tạo giỏ
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Nếu đã có → tăng số lượng
if (isset($_SESSION['cart'][$productId])) {
    $_SESSION['cart'][$productId]['quantity']++;
} else {
    $_SESSION['cart'][$productId] = [
        'id' => $product['id'],
        'name' => $product['name'],
        'price' => $product['price'],
        'image' => $product['image'],
        'quantity' => 1
    ];
}

echo json_encode([
    'success' => true,
    'message' => 'Đã thêm vào giỏ hàng'
]);
