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
    <link rel="stylesheet" href="../Css/register.css">
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
        <?php
        $avatar = $name = $age = $gender = $address = $phone = $email = $password = "";
        $avatarErr = $nameErr = $ageErr = $genderErr = $addressErr = $phoneErr = $emailErr = $passwordErr = "";
        $action = test_input($_SERVER["PHP_SELF"]);

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // check avatar

            // Check name
            if (empty($_POST["name"])) {
                $nameErr = "Name is required";
            } else {
                $name = test_input($_POST["name"]);
                if (!preg_match("/^[a-zA-Z- ]*$/", $name)) { // Dieu kien check ten
                    $nameErr = "Only english letters and white space allowed";
                }
            }

            // Check age
            if (empty($_POST["age"])) {
                $ageErr = "Age is required";
            } else {
                $age = test_input($_POST["age"]);
                if (!preg_match("/^[0-9]*$/", $age)) { // Dieu kien check tuoi
                    $ageErr = "Only number (0-9) allowed";
                } else {
                    if ($age <= 0 || $age > 100) {
                        $ageErr = "Invalid your age";
                    }
                }
            }

            // Check gender
            if (empty($_POST["gender"])) {
                $genderErr = "Gender is required";
            } else {
                $gender = test_input($_POST["gender"]);
            }

            // Check address
            if (empty($_POST["address"])) {
                $addressErr = "Address is required";
            } else {
                $address = test_input($_POST["address"]);
                if (!preg_match("/^[a-zA-Z0-9- ]*$/", $address)) { // Dieu kien check dia chi
                    $addressErr = "Only english letters and white space allowed";
                }
            }

            // check phone
            if (empty($_POST["phone"])) {
                $phoneErr = "phone is required";
            } else {
                $phone = test_input($_POST["phone"]);
                if (!preg_match("/^[0-9]*$/", $phone)) { // Dieu kien check tuoi
                    $ageErr = "Only number (0-9) allowed";
                }
            }

            // Check email
            if (empty($_POST["email"])) {
                $emailErr = "Email is required";
            } else {
                $email = test_input($_POST["email"]);
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Dieu kien check email
                    $emailErr = "Invalid email format";
                }
            }

            // Check password
            if (empty($_POST["password"])) {
                $passwordErr = "Password is required";
            } else {
                $password = test_input($_POST["password"]);
                if (!preg_match("/^[a-zA-Z-0-9]*$/", $password)) { // Dieu kien check ten
                    $passwordErr = "Only english letters and white space allowed";
                }
                if (strlen($password) < 8) {
                    echo "<script>alert('Password must be at least 8 characters long');</script>";
                }
            }

            //Check action no error
            if (empty($nameErr) && empty($ageErr) && empty($genderErr) && empty($addressErr) && empty($phoneErr) && empty($emailErr) && empty($passwordErr)) {
                $action = "process.php";
            }
        }

        function test_input($data)
        {
            $data = trim($data);
            $data = stripslashes($data);
            $data = htmlspecialchars($data);
            return $data;
        }
        ?>

        <script>
            function previewAvatar(input) {
                if (input.files && input.files[0]) {
                    document.getElementById("fileName").innerText = input.files[0].name;

                    const reader = new FileReader();
                    reader.onload = function(e) {
                        document.getElementById('avatarPreview').src = e.target.result;
                    };
                    reader.readAsDataURL(input.files[0]);
                }
            }

            function openFileChooser() {
                document.getElementById('avatarInput').click();
            }
        </script>


        <form action="<?php echo $action; ?>" method="post" enctype="multipart/form-data">
            <div class="form-container">
                <div class="form-header">
                    <h1>Sign Up</h1>
                </div>
                <div class="form-main">
                    <!-- Avatar -->
                    <div class="avatar">
                        <label for="avatar"><strong>Avatar</strong></label>
                        <span class="error" style="color: red;">* <?php echo "$avatarErr"; ?></span><br>
                        <div class="avatar-url">
                            <img id="avatarPreview"
                                src="../Asset/Image-User/default.png">
                            <input id="avatarInput" type="file" name="avatar" accept="image/*" onchange="previewAvatar(this)" hidden>
                            <button type="button" class="btn-upload" onclick="openFileChooser()">
                                Chọn ảnh đại diện
                            </button>
                            <p id="fileName">Chưa chọn ảnh</p>
                        </div>
                    </div>
                    <!-- Name -->
                    <div class="name">
                        <label for="name"><strong>Name</strong></label>
                        <span class="error" style="color: red;">* <?php echo "$nameErr"; ?></span><br>
                        <input type="text" placeholder="Enter your name" name="name" value="<?php echo $name; ?>">

                    </div>
                    <!-- Age -->
                    <div class="age">
                        <label for="age"><strong>Age</strong></label>
                        <span class="error" style="color: red;">* <?php echo "$ageErr"; ?></span><br>
                        <input type="text" placeholder="Enter your age" name="age" value="<?php echo $age; ?>">
                    </div>
                    <!-- Gender no require -->
                    <div class="gender">
                        <label for="gender"><strong>Gender: </strong></label>
                        <span class="gender-optionals">
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "male") echo "checked"; ?> value="Male"> Male
                            <input type="radio" name="gender" <?php if (isset($gender) && $gender == "female") echo "checked"; ?> value="Female"> Female
                        </span>
                        <span class="error" style="color: red;">* <?php echo "$genderErr"; ?></span>
                    </div>

                    <!-- Address -->
                    <div class="address">
                        <label for="address"><strong>Address</strong></label>
                        <span class="error" style="color: red;">* <?php echo "$addressErr"; ?></span><br>
                        <input type="text" placeholder="Enter your address" name="address" value="<?php echo $address; ?>">
                    </div>

                    <!-- Phone -->
                    <div class="phone">
                        <label for="phone"><strong>Phone</strong></label>
                        <span class="error" style="color: red;">* <?php echo "$phoneErr"; ?></span><br>
                        <input type="text" placeholder="Enter your phone" name="phone" value="<?php echo $phone; ?>">
                    </div>

                    <!-- Email -->
                    <div class="email">
                        <label for="email"><strong>Email</strong></label>
                        <span class="error" style="color: red;">* <?php echo "$emailErr"; ?></span><br>
                        <input type="email" placeholder="Enter your email" name="email" value="<?php echo $email; ?>">
                    </div>

                    <!-- Password -->
                    <div class="password">
                        <label for="password"><strong>Password</strong></label>
                        <span class="error" style="color: red;">* <?php echo "$passwordErr"; ?></span><br>
                        <input type="password" placeholder="Enter your password" name="password" value="<?php echo $password; ?>"><br><br><br>
                    </div>
                    <div class="btn-signup">
                        <button type="submit"><strong>Sign up</strong></button>
                    </div>
                </div>
                <div class="form-footer">
                    <a href="../Login">Have already account? <strong>Log in</strong></a>
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