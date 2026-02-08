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

$cart = $_SESSION['cart'] ?? [];

/* ===== PAGINATION ===== */
$perPage = 5;
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

$cartItems = array_values($cart); // reset key
$totalItems = count($cartItems);
$totalPages = max(1, ceil($totalItems / $perPage));

$offset = ($currentPage - 1) * $perPage;
$itemsOnPage = array_slice($cartItems, $offset, $perPage);

/* ===== TOTAL PRICE (TOÀN BỘ GIỎ) ===== */
$total = 0;
foreach ($cartItems as $item) {
    $total += $item['price'] * $item['quantity'];
}

/* ===== THANH TOÁN TIỀN MẶT (mysqli chuẩn) ===== */
if (isset($_POST['pay_cash']) && !empty($cart)) {

    $userId = $user['id'];
    $total = 0;

    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    try {
        // BẮT ĐẦU TRANSACTION
        $conn->begin_transaction();

        /* 1. INSERT ORDERS */
        $stmt = $conn->prepare("
            INSERT INTO orders (user_id, total_price, payment_method, status)
            VALUES (?, ?, 'Tiền mặt', 'Đang chuẩn bị')
        ");
        $stmt->bind_param("id", $userId, $total);
        $stmt->execute();

        // LẤY ORDER ID
        $orderId = $conn->insert_id;

        /* 2. INSERT ORDER ITEMS */
        $stmtItem = $conn->prepare("
            INSERT INTO order_items (order_id, product_name, price, quantity)
            VALUES (?, ?, ?, ?)
        ");

        foreach ($cart as $item) {
            $stmtItem->bind_param(
                "isdi",
                $orderId,
                $item['name'],
                $item['price'],
                $item['quantity']
            );
            $stmtItem->execute();
        }

        // COMMIT
        $conn->commit();

        // 3. XÓA GIỎ HÀNG
        unset($_SESSION['cart']);

        header("Location: ../Order/list.php");
        exit;
    } catch (Exception $e) {
        $conn->rollback();
        die("Lỗi thanh toán: " . $e->getMessage());
    }
}



/* THANH TOÁN THẺ */
if (isset($_POST['pay_bank'])) {
    $bankMessage = "NOTICE: Chức năng thanh toán thẻ ngân hàng đang được phát triển.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bear_shop</title>
    <link rel="stylesheet" href="../../Css/cart.css">
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
                        <li><a href="../Order/list.php">Đơn hàng</a></li>
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

    <div class="body-main">
        <div class="section-main">
            <div class="header-cart-select">
                <h1>Giỏ hàng của bạn</h1>
                <!-- THÔNG BÁO -->
                <?php if (!empty($successMessage)): ?>
                    <p style="color:green; font-size:1.5rem; margin:5px 0;">
                        <?= $successMessage ?>
                    </p>
                <?php endif; ?>
                <?php if (!empty($bankMessage)): ?>
                    <p style="color:orange; font-size:1.5rem; margin:5px 0;">
                        <?= $bankMessage ?>
                    </p>
                <?php endif; ?>
                <div class="payment-select-container">
                    <!-- NÚT THANH TOÁN (CHỈ HIỆN KHI CÓ HÀNG) -->
                    <div class="pay-select">
                        <?php if (!empty($cartItems)): ?>
                            <div id="paymentBox" class="payment-box">
                                <p><strong>Chọn phương thức thanh toán</strong></p>
                                <form method="POST">
                                    <button type="submit" name="pay_cash" class="pay-btn">
                                        Tiền mặt
                                    </button>
                                    <button type="submit" name="pay_bank" class="pay-btn">
                                        Thẻ ngân hàng
                                    </button>
                                </form>
                            </div>
                            <button class="btn-checkout" onclick="togglePayment()">
                                Thanh toán
                            </button>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <hr><br>

            <?php if (empty($cartItems)): ?>
                <p>Giỏ hàng trống</p>
            <?php else: ?>
                <div class="cart-list">
                    <table border="2" cellspacing="0">
                        <tr>
                            <th>Ảnh</th>
                            <th>Tên</th>
                            <th>Loại</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tạm tính</th>
                        </tr>
                        <?php foreach ($itemsOnPage as $item):
                            $sub = $item['price'] * $item['quantity'];
                        ?>
                            <tr>
                                <td>
                                    <img src="/VTC-Academy_PHP-Laravel/Final_ASM_PHP/<?= $item['image'] ?>" width="100">
                                </td>
                                <td><?= htmlspecialchars($item['name']) ?></td>
                                <td>Sản phẩm</td>
                                <td><?= number_format($item['price']) ?> VNĐ</td>
                                <td>
                                    <form action="update.php" method="post">
                                        <input type="hidden" name="id" value="<?= $item['id'] ?>">
                                        <input type="number" name="quantity" value="<?= $item['quantity'] ?>" min="1">
                                        <button>Cập nhật</button>
                                    </form>
                                </td>
                                <td><?= number_format($sub) ?> VNĐ</td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="5"><strong>Tổng tiền</strong></td>
                            <td><strong><?= number_format($total) ?> VNĐ</strong></td>
                        </tr>
                    </table>
                </div>

                <br>
                <hr>
                <!-- PAGINATION -->
                <?php if ($totalPages > 1): ?>
                    <div class="page-number">
                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i == $currentPage): ?>
                                <strong><?= $i ?></strong>
                            <?php else: ?>
                                <a href="?page=<?= $i ?>"><?= $i ?></a>
                            <?php endif; ?>
                        <?php endfor; ?>
                    </div>
                <?php endif; ?>

            <?php endif; ?>
        </div>
    </div>

    <script>
        function togglePayment() {
            const box = document.getElementById("paymentBox");
            box.style.display = box.style.display === "block" ? "none" : "block";
        }
    </script>


    <footer>
        <div class="footer-end">
            <p>&copy; Dont copy right | 2026 | Bear Shop Website | Áp dụng các chính sách bảo mật theo quy định.</p>
        </div>
    </footer>

</body>

</html>