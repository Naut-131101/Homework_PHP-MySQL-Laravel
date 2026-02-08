<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../Database/database.php";
if (!isset($_SESSION['user'])) {
    header("Location: /Login/index.php");
    exit;
}

$user = $_SESSION['user'];
$role = $user['role']; // admin | user

/* ================== FILTER & SORT ================== */
$sort = $_GET['sort'] ?? '';
$category = $_GET['category'] ?? '';

$where = "WHERE p.is_active = 1";

if (!empty($category)) {
    $where .= " AND p.category_id = " . intval($category);
}

$orderBy = "ORDER BY p.id DESC";
switch ($sort) {
    case 'price_asc':
        $orderBy = "ORDER BY p.price ASC";
        break;
    case 'price_desc':
        $orderBy = "ORDER BY p.price DESC";
        break;
    case 'name_asc':
        $orderBy = "ORDER BY p.name ASC";
        break;
}

$categorySql = "SELECT id, name FROM category";
$categories = $conn->query($categorySql)->fetch_all(MYSQLI_ASSOC);


/* ================== PAGINATION SETUP ================== */
$perPage = 10;

// trang hiện tại
$currentPage = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;

// đếm tổng sản phẩm
$countSql = "
    SELECT COUNT(*) AS total
    FROM product p
    $where
";
$countResult = $conn->query($countSql);
$totalRows = $countResult->fetch_assoc()['total'];

// tổng số trang
$totalPages = max(1, ceil($totalRows / $perPage));

// offset
$offset = ($currentPage - 1) * $perPage;

// LOAD DANH SÁCH SẢN PHẨM
$sql = "
    SELECT p.*, c.name AS category_name
    FROM product p
    LEFT JOIN category c ON p.category_id = c.id
    $where
    $orderBy
    LIMIT $perPage OFFSET $offset
";
$result = $conn->query($sql);
$products = $result->fetch_all(MYSQLI_ASSOC);

/* ================== PAGINATION RANGE ================== */
$window = 1; // số trang lân cận

$start = max(2, $currentPage - $window);
$end   = min($totalPages - 1, $currentPage + $window);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bear_shop</title>
    <link rel="stylesheet" href="../Css/dashboard.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="header-brand">
                <a href="../Dashboard/index.php"><img class="logo-brand" src="../Asset/Image-Brand/logo_brand.png" alt="Logo Brand"></a>
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
                        <li><a href="../User/Cart/list.php">Giỏ hàng</a></li>
                        <li><a href="../User/Order/list.php">Đơn hàng</a></li>
                    <?php endif; ?>

                    <?php if ($role === 'admin'): ?>
                        <li><a href="/Admin/Product/list.php">Quản lý sản phẩm</a></li>
                        <li><a href="/Admin/User/list.php">Quản lý user</a></li>
                        <li><a href="../Admin/Bill/list.php">Quản lý hóa đơn</a></li>
                    <?php endif; ?>

                    <li><a href="../Login/index.php">Đăng xuất</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="section-main">
            <!-- Danh sách sản phẩm -->
            <h1>Danh sách sản phẩm</h1>
            <div class="header-list">
                <?php
                $query = $_GET;
                unset($query['page']);
                $baseUrl = '?' . http_build_query($query);

                ?>
                <!-- Phân trang -->
                <ul class="pagination">
                    <?php
                    // Trang 1
                    echo '<li><a href="' . $baseUrl . '&page=1">1</a></li>';

                    if ($start > 2) {
                        echo '<li class="dots">...</li>';
                    }

                    for ($i = $start; $i <= $end; $i++) {
                        if ($i == $currentPage) {
                            echo '<li class="active">' . $i . '</li>';
                        } else {
                            echo '<li><a href="' . $baseUrl . '&page=' . $i . '">' . $i . '</a></li>';
                        }
                    }

                    if ($end < $totalPages - 1) {
                        echo '<li class="dots">...</li>';
                    }

                    if ($totalPages > 1) {
                        echo '<li><a href="' . $baseUrl . '&page=' . $totalPages . '">' . $totalPages . '</a></li>';
                    }
                    ?>
                </ul>

                <!-- Button Them SP -->
                <?php if ($role === 'admin'): ?>
                    <div class="admin-toolbar">
                        <a href="../Admin/Product/create.php" class="btn-add">
                            Thêm sản phẩm
                        </a>
                    </div>
                <?php endif; ?>
            </div>

            <hr><br>

            <form method="GET" class="filter-bar">
                <select name="sort" onchange="this.form.submit()">
                    <option value="">-- Sắp xếp --</option>
                    <option value="price_asc" <?= ($_GET['sort'] ?? '') == 'price_asc' ? 'selected' : '' ?>>Giá tăng dần</option>
                    <option value="price_desc" <?= ($_GET['sort'] ?? '') == 'price_desc' ? 'selected' : '' ?>>Giá giảm dần</option>
                    <option value="name_asc" <?= ($_GET['sort'] ?? '') == 'name_asc' ? 'selected' : '' ?>>Tên A - Z</option>
                </select>

                <select name="category" onchange="this.form.submit()">
                    <option value="">-- Loại sản phẩm --</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= ($_GET['category'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                            <?= $cat['name'] ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </form>


            <div class="product-list">
                <?php if (empty($products)): ?>
                    <p class="empty">⚠️ Chưa có sản phẩm nào</p>
                <?php endif; ?>
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img
                            src="/VTC-Academy_PHP-Laravel/Final_ASM_PHP/<?= htmlspecialchars($product['image']) ?>"
                            alt="<?= htmlspecialchars($product['name']) ?>"
                            class="product-image">
                        <h3><?= htmlspecialchars($product['name']) ?></h3>
                        <div class="content">
                            <div class="content-left">
                                <p class="category">
                                    <strong>Loại:</strong>
                                    <?= $product['category_name']
                                        ? htmlspecialchars($product['category_name'])
                                        : 'Chưa phân loại' ?>
                                </p>
                                <p class="price">
                                    <strong>Giá:</strong> <?= number_format($product['price']) ?> VNĐ
                                </p>
                                <p>
                                    <strong>Tồn kho:</strong> <?= $product['quantity'] ?>
                                </p>
                                <?php if ($product['quantity'] <= 0 || !$product['is_active']): ?>
                                    <p class="out">❌ Hết hàng</p>
                                <?php endif; ?>
                            </div>
                            <div class="content-right">
                                <!-- AI CŨNG XEM CHI TIẾT -->
                                <a class="detail" href="/User/Product/detail.php?id=<?= $product['id'] ?>">
                                    Chi tiết
                                </a>
                                <!-- USER -->
                                <?php if ($role === 'user' && $product['quantity'] > 0 && $product['is_active']): ?>
                                    <button
                                        type="button"
                                        class="btn-cart-add"
                                        data-id="<?= $product['id'] ?>">
                                        Thêm giỏ
                                    </button>
                                <?php endif; ?>
                                <!-- ADMIN -->
                                <?php if ($role === 'admin'): ?>
                                    <div class="admin-action">
                                        <a class="detail" href="/Admin/Product/update.php?id=<?= $product['id'] ?>">Sửa</a>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn-cart-add').forEach(btn => {
                btn.addEventListener('click', function() {
                    const productId = this.dataset.id;

                    fetch('../User/Cart/add.php', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/x-www-form-urlencoded'
                            },
                            body: 'product_id=' + productId
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                this.textContent = '✔ Đã thêm';
                                this.disabled = true;
                                this.classList.add('added');
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(err => {
                            alert('Lỗi kết nối');
                            console.error(err);
                        });
                });
            });
        });
    </script>

    <footer>
        <div class="footer-end">
            <p>&copy; Dont copy right | 2026 | Bear Shop Website | Áp dụng các chính sách bảo mật theo quy định.</p>
        </div>
    </footer>
</body>

</html>