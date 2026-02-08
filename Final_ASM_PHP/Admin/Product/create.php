<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
    header("Location: /Login/index.php");
    exit;
}

$user = $_SESSION['user'];
$role = $user['role']; // admin | user
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bear Shop</title>
    <link rel="stylesheet" href="../../Css/create_product.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="header-brand">
                <a href="../../Login/index.php"><img class="logo-brand" src="../../Asset/Image-Brand/logo_brand.png" alt="Logo Brand"></a>
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
                        <li><a href="../../User/Cart/list.php">Giỏ hàng</a></li>
                        <li><a href="/User/Order/list.php">Đơn hàng</a></li>
                    <?php endif; ?>

                    <?php if ($role === 'admin'): ?>
                        <li><a href="../../Admin/Product/list.php">Quản lý sản phẩm</a></li>
                        <li><a href="../../Admin/User/list.php">Quản lý user</a></li>
                        <li><a href="../../Admin/Bill/list.php">Quản lý hóa đơn</a></li>
                    <?php endif; ?>

                    <li><a href="../Logout/logout.php">Đăng xuất</a></li>
                </ul>
            </div>
        </nav>
    </header>


    <main>
        <div class="form-container">
            <h2>Thêm sản phẩm</h2>
            <form action="store.php" method="post" enctype="multipart/form-data">
                <div class="name">
                    <label><strong>Tên sản phẩm</strong></label><br>
                    <input type="text" name="name" required>
                </div>
                <div class="price">
                    <label><strong>Giá</strong></label><br>
                    <input type="number" name="price" required>
                </div>
                <div class="quantity">
                    <label><strong>Số lượng</strong></label><br>
                    <input type="number" name="quantity" required>
                </div>
                <div class="image">
                    <label><strong>Ảnh sản phẩm</strong></label>
                    <input type="file" name="image" accept="image/*" required>
                </div>
                <div class="category">
                    <label><strong>Danh mục</strong></label><br>
                    <select name="category_id">
                        <option value="1">Gấu thường</option>
                        <option value="2">Gấu cao cấp</option>
                        <option value="3">Gấu siêu cấp</option>
                    </select>
                </div>
                <button class="btn-summit" type="submit">Lưu</button>
            </form>
        </div>
    </main>

    <footer>
        <div class="footer-end">
            <p>&copy; Dont copy right | 2026 | Bear Shop Website | Áp dụng các chính sách bảo mật theo quy định.</p>
        </div>
    </footer>
</body>

</html>