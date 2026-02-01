<?php
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

  $id = $_POST["id"];
  $name = $_POST["name"];
  $mssv = $_POST["mssv"];
  $age = $_POST["age"];
  $birthday = $_POST["birthday"];
  $phone = $_POST["phone"];
  $email = $_POST["email"];
  $address = $_POST["address"];
  $gender = $_POST["gender"];
  $description = $_POST["description"];

  /* KIỂM TRA ID CÓ TỒN TẠI KHÔNG? */
  $check = "SELECT id FROM students WHERE id = $id";
  $result = $conn->query($check);

  if ($result->num_rows === 0) {
    echo "ID không tồn tại";
    exit;
  }

  $sql = "UPDATE students SET name='$name', mssv='$mssv', age=$age, birthday='$birthday', phone='$phone', email='$email', address='$address', gender='$gender', description='$description' WHERE id=$id";
    
  if ($conn->query($sql) === TRUE) {
      header("Location: ../Read/select.php");
  } else {
      echo "Lỗi UPDATE: " . $conn->error;
  }

  $conn->close();
?>