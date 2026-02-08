<!-- Xem chi tiết sản phẩm -->
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../../Database/database.php";

// 2. Kiểm tra id sản phẩm
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    die("Sản phẩm không hợp lệ");
}

$product_id = (int) $_GET['id'];

// 3. Lấy thông tin sản phẩm
$stmt = $conn->prepare("
    SELECT id, name, price, quantity, origin, description, image, is_active
    FROM product
    WHERE id = ?
    LIMIT 1
");
$stmt->bind_param("i", $product_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Sản phẩm không tồn tại");
}

$product = $result->fetch_assoc();
