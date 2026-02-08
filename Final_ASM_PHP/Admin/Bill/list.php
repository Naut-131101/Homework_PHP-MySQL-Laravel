<!-- Xem danh sách thanh toán -->

<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once "../../Database/database.php";

/* ===== CHECK LOGIN + ROLE ===== */
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /Login/index.php");
    exit;
}

$user = $_SESSION['user'];
$role = $user['role']; // admin | user

/* ===== LẤY TOÀN BỘ ĐƠN HÀNG + USER ===== */
$sql = "
    SELECT 
        o.id,
        o.total_price,
        o.payment_method,
        o.status,
        o.created_at,
        u.name AS user_name,
        u.email
    FROM orders o
    JOIN user u ON o.user_id = u.id
    ORDER BY o.created_at DESC
";

$result = $conn->query($sql);
$orders = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bear_shop</title>
    <link rel="stylesheet" href="../../Css/bill.css">
    <!-- <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #999;
            padding: 8px;
            text-align: center;
        }
        th {
            background: #eee;
        }
        .order-items {
            text-align: left;
            font-size: 0.9rem;
        }
    </style> -->
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
                        <li><a href="../../Dashboard/index.php">Cửa hàng</a></li>
                        <li><a href="/Admin/Product/list.php">Quản lý sản phẩm</a></li>
                        <li><a href="/Admin/User/list.php">Quản lý user</a></li>
                    <?php endif; ?>

                    <li><a href="../../Login/index.php">Đăng xuất</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="main-container">
            <h1>📦 Quản lý toàn bộ đơn hàng</h1>
            <hr><br>
            <div class="bill-list">
                <?php if (empty($orders)): ?>
                    <p>Chưa có đơn hàng nào</p>
                <?php else: ?>
                    <table>
                        <tr>
                            <th>Mã đơn</th>
                            <th>Khách hàng</th>
                            <th>Sản phẩm</th>
                            <th>Tổng tiền</th>
                            <th>Thanh toán</th>
                            <th>Trạng thái</th>
                            <th>Ngày đặt</th>
                        </tr>
                        <?php foreach ($orders as $order): ?>
                            <tr>
                                <td>#<?= $order['id'] ?></td>
                                <td>
                                    <?= htmlspecialchars($order['user_name']) ?><br>
                                    <small><?= htmlspecialchars($order['email']) ?></small>
                                </td>
                                <td class="order-items">
                                    <?php
                                    $stmtItem = $conn->prepare("
                                SELECT product_name, price, quantity
                                FROM order_items
                                WHERE order_id = ?
                            ");
                                    $stmtItem->bind_param("i", $order['id']);
                                    $stmtItem->execute();
                                    $items = $stmtItem->get_result()->fetch_all(MYSQLI_ASSOC);
                                    ?>
                                    <?php foreach ($items as $item): ?>
                                        • <?= htmlspecialchars($item['product_name']) ?>
                                        (<?= number_format($item['price']) ?> × <?= $item['quantity'] ?>)
                                        <br>
                                    <?php endforeach; ?>
                                </td>
                                <td><?= number_format($order['total_price']) ?> VND</td>
                                <td><?= $order['payment_method'] ?></td>
                                <td><?= $order['status'] ?></td>
                                <td><?= $order['created_at'] ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </table>
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