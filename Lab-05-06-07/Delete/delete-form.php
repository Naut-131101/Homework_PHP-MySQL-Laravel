<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Xóa thông tin sinh viên</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../Read/select.php">Xem DSSV</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <form action="./delete.php" method="post">
            <!-- ID -->
            <label for="id">ID muốn xóa: </label>
            <input type="number" name="id">
            <button type="submit">Xóa</button>
        </form>
    </main>
</body>
</html>