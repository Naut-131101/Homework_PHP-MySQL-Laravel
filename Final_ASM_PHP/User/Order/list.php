<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../Database/database.php";

if (!isset($_SESSION['user'])) {
    header("Location: ../../Login/index.php");
    exit;
}
$user = $_SESSION['user'];
$role = $user['role']; // admin | user

$userId = $_SESSION['user']['id'];

/* ===== LẤY DANH SÁCH ĐƠN HÀNG ===== */
$stmt = $conn->prepare("
    SELECT *
    FROM orders
    WHERE user_id = ?
    ORDER BY created_at DESC
");
$stmt->bind_param("i", $userId);
$stmt->execute();

$result = $stmt->get_result();
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bear_shop</title>
    <link rel="stylesheet" href="../../Css/order.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="header-brand">
                <a href="../../Dashboard/index.php"><img class="logo-brand" src="../../Asset/Image-Brand/logo_brand.png" alt="Logo Brand"></a>
                <div class="header-content">
                    <h1>Bear Shop</h1>
                    <p>Xin chào, <?= htmlspecialchars($user['name']) ?></p>
                </div>
            </div>
            <form class="search">
                <input type="text" placeholder="Tìm sản phẩm...">
            </form>
            <div class="header-menu">
                <ul>
                    <?php if ($role === 'user'): ?>
                        <li><a href="../../Dashboard/index.php">Cửa hàng</a></li>
                        <li><a href="https://zalo.me/0792007045" target="_blank" rel="noopener nofollow">Liên hệ</a></li>
                    <?php endif; ?>

                    <?php if ($role === 'admin'): ?>
                        <li><a href="/Admin/Product/list.php">Quản lý sản phẩm</a></li>
                        <li><a href="/Admin/User/list.php">Quản lý user</a></li>
                        <li><a href="/Admin/Bill/list.php">Quản lý hóa đơn</a></li>
                    <?php endif; ?>

                    <li><a href="../../Login/index.php">Đăng xuất</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="main-container">
            <h1>📦 Đơn hàng của bạn</h1>
            <hr><br>
            <div class="order-list">
                <?php if (empty($orders)): ?>
                    <p>Bạn chưa có đơn hàng nào</p>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <div class="order-box">
                            <p><strong>Mã đơn:</strong> #<?= $order['id'] ?></p>
                            <p><strong>Phương thức:</strong> <?= $order['payment_method'] ?></p>
                            <p><strong>Tổng tiền:</strong> <?= number_format($order['total_price']) ?> VND</p>
                            <p><strong>Trạng thái:</strong> <?= $order['status'] ?></p>
                            <p><strong>Ngày đặt:</strong> <?= $order['created_at'] ?></p>
                            <div class="detail-products">
                                <h4>Sản phẩm:</h4>
                                <ul>
                                    <?php
                                    /* ===== LẤY CHI TIẾT ĐƠN HÀNG ===== */
                                    $stmtItem = $conn->prepare("
                                SELECT product_name, price, quantity
                                FROM order_items
                                WHERE order_id = ?
                                                        ");
                                    $stmtItem->bind_param("i", $order['id']);
                                    $stmtItem->execute();
                                    $itemsResult = $stmtItem->get_result();
                                    $items = $itemsResult->fetch_all(MYSQLI_ASSOC);
                                    ?>
                                    <?php foreach ($items as $item): ?>
                                        <li>
                                            <?= htmlspecialchars($item['product_name']) ?> |
                                            Giá: <?= number_format($item['price']) ?> |
                                            SL: <?= $item['quantity'] ?>
                                        </li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                        <hr><br>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer>
        <div class="footer-end">
            <p>&copy; Dont copy right | 2026 | Bear Shop Website | Áp dụng các chính sách bảo mật theo quy định.</p>
        </div>
    </footer>

</body>

</html>