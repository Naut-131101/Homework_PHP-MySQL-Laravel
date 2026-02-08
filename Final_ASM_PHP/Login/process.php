<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once __DIR__ . "/../Database/database.php";

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = test_input($_POST["email"]); // Cat bo khoang trang truoc khi dua email vao db
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<script>alert('Invalid email format');</script>";
    }

    $password = $_POST["password"];
    if (strlen($password) < 8) {
        echo "Password must be at least 8 characters long";
        exit;
    }

    $remember = isset($_POST["remember-me"]);

    $stmt = $conn->prepare("SELECT id, name, email, password, role FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        echo "Tài khoản không tồn tại. Vui lòng đăng ký!";
        exit;
    }

    $user = $result->fetch_assoc();

    if (!password_verify($password, $user["password"])) {
        echo "Sai mật khẩu!";
        exit;
    }

    // $_SESSION["user_id"] = $user["id"];
    // $_SESSION["user_name"] = $user["name"];
    // $_SESSION["user_email"] = $user["email"];
    // $_SESSION["role"]      = $user["role"];
    
    $_SESSION['user'] = [
        'id' => $user['id'],
        'name' => $user['name'],
        'email' => $user['email'],
        'role' => $user['role'], // admin | user
    ];

    // 🔐 REMEMBER ME
    if ($remember) {
        $token = bin2hex(random_bytes(32));

        $stmt = $conn->prepare("UPDATE user SET remember_token=? WHERE id=?");
        $stmt->bind_param("si", $token, $user["id"]);
        $stmt->execute();

        setcookie(
            "remember_token",
            $token,
            time() + (86400 * 30), // 30 ngày
            "/",
            "",
            false,
            true // httponly
        );
    }
    $stmt->close();
    $conn->close();

    header("Location: ../Dashboard/index.php");
    exit;
}
