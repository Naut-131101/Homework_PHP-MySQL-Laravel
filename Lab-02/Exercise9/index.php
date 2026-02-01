<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>

<body>
<?php
$products = [
    [
        "name" => "Máy Ảnh Canon SX730 HS (Hàng Nhập Khẩu)-...",
        "image" => "https://camerabox.vn/wp-content/uploads/2025/05/canon-powershot-sx730-hs-4.png",
        "price" => 7690000,
        "old_price" => 9370000,
        "discount" => 18
    ],
    [
        "name" => "Máy Ảnh Canon SX720 HS (Hàng Nhập Khẩu)-...",
        "image" => "https://camerabox.vn/wp-content/uploads/2025/05/canon-powershot-sx730-hs-4.png",
        "price" => 6290000,
        "old_price" => 7870000,
        "discount" => 20
    ],
    [
        "name" => "Máy Ảnh Canon Canon SX620 HS (Hàng Nhập...",
        "image" => "https://camerabox.vn/wp-content/uploads/2025/05/canon-powershot-sx730-hs-4.png",
        "price" => 4890000,
        "old_price" => 6240000,
        "discount" => 22
    ],
    [
        "name" => "Máy Ảnh Canon SX730 HS (Hàng Chính Hãng)-...",
        "image" => "https://camerabox.vn/wp-content/uploads/2025/05/canon-powershot-sx730-hs-4.png",
        "price" => 9170000,
        "old_price" => 10620000,
        "discount" => 14
    ],
    [
        "name" => "Máy Ảnh Canon Powershot G3X (Lê Bảo Minh)",
        "image" => "https://camerabox.vn/wp-content/uploads/2025/05/canon-powershot-sx730-hs-4.png",
        "price" => 16990000,
        "old_price" => 22500000,
        "discount" => 24
    ],
    [
        "name" => "Máy Ảnh Canon G9X Mark II (Hàng Nhập Khẩu)-...",
        "image" => "https://camerabox.vn/wp-content/uploads/2025/05/canon-powershot-sx730-hs-4.png",
        "price" => 9490000,
        "old_price" => 11990000,
        "discount" => 21
    ]
];
?>

<div class="products">
    <?php foreach ($products as $item): ?>
        <div class="product">
            <img src="<?= $item['image'] ?>" alt="">
            <div class="name"><?= $item['name'] ?></div>
            <div class="box">
                <div class="price"><?= number_format($item['price']) ?> đ</div> 
                <div class="old-price"><?= number_format($item['old_price']) ?> đ</div>
                <div class="discount">-<?= $item['discount'] ?>%</div>
            </div>
        </div>
    <?php endforeach; ?>
</div>

</body>
</html>
