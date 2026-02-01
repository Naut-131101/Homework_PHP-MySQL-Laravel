<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student_manager_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_POST["id"];

// sql to delete a record
$sql = "DELETE FROM students WHERE id=$id";

if ($conn->query($sql) === TRUE) {
  header("Location: ../Read/select.php");
} else {
  echo "Error deleting record: " . $conn->error;
}

$conn->close();
?>