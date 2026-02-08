<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../Database/database.php";

if (isset($_FILES['avatar']) && $_FILES['avatar']['error'] === 0) {

    $uploadDir = "../Asset/Image-User/";
    $fileName = time() . "_" . basename($_FILES["avatar"]["name"]);
    $target = $uploadDir . $fileName;

    move_uploaded_file($_FILES["avatar"]["tmp_name"], $target);
    $avatar = "Asset/Image-User/" . $fileName;
}

$name = $_POST["name"];
$age = $_POST["age"];
$gender = $_POST["gender"];
$address = $_POST["address"];
$phone = $_POST["phone"];
$email = $_POST["email"];
$password = password_hash($_POST["password"], PASSWORD_DEFAULT);

$check = $conn->prepare("SELECT id FROM user WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if ($check->num_rows > 0) {
    die("Email đã tồn tại");
}

$stmt = $conn->prepare(
    "INSERT INTO user (avatar, name, age, gender, address, phone, email, password, role)
VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'user')"
);

$stmt->bind_param(
    "ssisssss",
    $avatar,
    $name,
    $age,
    $gender,
    $address,
    $phone,
    $email,
    $password
);
$stmt->execute();
$stmt->close();
$conn->close();

header("Location: ../Login/index.php");
exit;
