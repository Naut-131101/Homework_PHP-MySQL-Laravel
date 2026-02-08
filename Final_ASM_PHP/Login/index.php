<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bear Shop</title>
    <link rel="stylesheet" href="../Css/login.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <div class="header-brand">
                <a href="../Login/index.php"><img class="logo-brand" src="../Asset/Image-Brand/logo_brand.png" alt="Logo Brand"></a>
                <div class="header-content">
                    <h1>Bear Shop</h1>
                    <p>Welcome to our website - This is Bear, not Beer!</p>
                </div>
            </div>
            <div class="header-menu">
                <ul>
                    <li><a href="../Login/index.php">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Location</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <form action="process.php" method="post">
            <div class="form-container">
                <div class="form-header">
                    <h1>Login</h1>
                </div>
                <div class="form-main">
                    <!-- Email -->
                    <div class="email">
                        <label for="email"><strong>Email</strong></label><br>
                        <input id="email" type="email" placeholder="Enter your email" name="email" required>
                    </div>
                    <!-- Password -->
                    <div class="password">
                        <label for="password"><strong>Password</strong></label><br>
                        <input id="password" type="password" placeholder="Enter your password" name="password" required>
                    </div>
                    <!-- Remember Me & Forgot Password -->
                    <div class="rmb-me-fg-psw">
                        <div class="remember-me">
                            <input id="remember-me" type="checkbox" checked="check" name="remember-me">
                            <label for="remember-me">Remember me</label>
                        </div>
                        <div class="forgot-password">
                            <a href="#"><strong>Forgot password?</strong></a>
                        </div>
                    </div>
                    <div class="btn-login">
                        <button id="btn-login" type="submit" name="btn-login"><strong>Login</strong></button>
                    </div>
                </div>
                <div class="form-footer">
                    <a href="../Register/index.php">Create new account? <strong>Sign up</strong></a>
                </div>
            </div>
        </form>
    </main>

    <footer>
        <div class="footer-end">
            <p>&copy; Dont copy right | 2026 | Bear Shop Website | Áp dụng các chính sách bảo mật theo quy định.</p>
        </div>
    </footer>
</body>

</html>