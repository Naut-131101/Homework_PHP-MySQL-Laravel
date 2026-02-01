<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .button {
            background-color: #4CAF50;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <h1>Student management application</h1>
    <a href="form.php">Add New Student</a>
    <br><br>

    Bộ lọc:
    Giới tính
    <a class="button-gender" href="index.php?gender=1">Nam</a>
    <a class="button-gender" href="index.php?gender=2">Nữ</a>
    <a class=" button-gender" href="index.php?gender=3">Khác</a>
    <br><br>

    <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_management_db_25";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $limit = 10;
    $page = $_GET['page'] ?? 1;
    $offset = ($page - 1) * $limit;
    $gender = $_GET['gender'] ?? null; // thêm ?? null
    $keyword = "Thị";

    $sql = "SELECT id, name, gender FROM students limit $limit offset $offset";


    //%Thị%
    if ($gender) {
        // $gender = (int)$gender;
        $sql = "SELECT id, name, gender FROM students WHERE gender = $gender and name LIKE '%$keyword%' limit $limit offset $offset";
    }

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"] . " - Name: " . $row["name"] . " - Gender: " . $row["gender"] . " <a href='edit.php?id=" . $row["id"] . "&name=" . $row["name"] . "'>Edit</a><br>";
        }
    } else {
        echo "0 results";
    }
    $conn->close();
    ?>

    <div class="pagination">
        <a class="button" href="index.php?page=1">1</a>
        <a class="button" href="index.php?page=2">2</a>
        <a class=" button" href="index.php?page=3">3</a>
    </div>
</body>

</html>