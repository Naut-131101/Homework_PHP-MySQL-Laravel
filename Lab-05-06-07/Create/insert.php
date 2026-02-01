<!-- Quá trình create -->

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

  $name = $_POST["name"];
  $mssv = $_POST["mssv"];
  $age = $_POST["age"];
  $birthday = $_POST["birthday"];
  $phone = $_POST["phone"];
  $email = $_POST["email"];
  $address = $_POST["address"];
  $gender = $_POST["gender"];
  $description = $_POST["description"];

  $sql = "INSERT INTO students (name, mssv, age, birthday, phone, email, address, gender, description) VALUES ('$name', '$mssv', $age, '$birthday', '$phone', '$email', '$address', '$gender', '$description')";
    
  if ($conn->query($sql) === TRUE) {
    header("Location: ../Read/select.php");
  } else {
    echo "Lỗi CREATE: " . $sql . "<br>" . $conn->error;
  }

  $conn->close();
?>