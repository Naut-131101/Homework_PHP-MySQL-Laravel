<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once __DIR__ . "/../../Database/database.php";

if ($_SESSION['user']['role'] !== 'admin') {
    die("Không có quyền");
}

$name = $_POST['name'];
$price = $_POST['price'];
$quantity = $_POST['quantity'];
$category_id = $_POST['category_id'];

// ================== UPLOAD ẢNH ==================
if (!isset($_FILES['image']) || $_FILES['image']['error'] !== 0) {
    die("Upload ảnh thất bại");
}

$uploadDir = __DIR__ . "/../../Asset/Image-Product/";

$originalName = $_FILES['image']['name'];
$ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

$allowExt = ['jpg', 'jpeg', 'png', 'webp'];
if (!$ext || !in_array($ext, $allowExt)) {
    die("Ảnh không hợp lệ hoặc thiếu đuôi (jpg, png, webp)");
}

$fileName = uniqid("product_") . "." . $ext;
$targetPath = $uploadDir . $fileName;

if (!move_uploaded_file($_FILES['image']['tmp_name'], $targetPath)) {
    die("Không thể lưu ảnh");
}

// lưu DB
$imagePath = "Asset/Image-Product/" . $fileName;

// ================== INSERT DB ==================
$sql = "
    INSERT INTO product (name, price, quantity, image, category_id, is_active)
    VALUES (?, ?, ?, ?, ?, 1)
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("siisi", $name, $price, $quantity, $imagePath, $category_id);
$stmt->execute();

header("Location: ../../Dashboard/index.php");
exit;
