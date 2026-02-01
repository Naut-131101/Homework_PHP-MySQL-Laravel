<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trang chủ</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <header>
    <h1>Danh sách quản lí sinh viên</h1>
    <a href="./Read/select.php">Xem DSSV</a>
  </header>
</body>
</html>


<!-- Da comment ben duoi lai -->
<!-- <?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "student_manager_db";

    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
      die("Kết nối thất bại: " . $conn->connect_error);
    }
    
    $sql = "SELECT id, name, mssv, age, birthday, phone, email, address, gender, description FROM students";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        echo "ID: " . $row["id"] . " - Tên: " . $row["name"] . " - MSSV: " . $row["mssv"] . " - Tuổi: " . $row["age"] . " - Ngày sinh: " . $row["birthday"] . " - Sđt: " . $row["phone"] . " - Email: " . $row["email"] . " - Địa chỉ: " . $row["address"] . " - Giới tính: " . $row["gender"] . " - Mô tả: " . $row["description"] . " ";
        echo '<a href="./Update/update-form.php">[Edit]</a>'; 
        echo "<br>";
      }
    }
    $conn->close();
  ?> -->