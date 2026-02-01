<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <header>
        <h1>Nhập thông tin sinh viên</h1>
        <nav>
            <ul>
                <li><a href="../index.php">Home</a></li>
                <li><a href="../Read/select.php">Xem DSSV</a></li>
            </ul>
        </nav>
    </header>
    <main>
        <?php
            $name = $mssv = $age = $birthday = $phone = $email = $address = $gender = $description = "";
            $nameErr = $mssvErr = $ageErr = $birthdayErr = $phoneErr = $emailErr = $addressErr = $genderErr = $descriptionErr = "";
            $action = test_input($_SERVER["PHP_SELF"]);

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                // Check name
                if(empty($_POST["name"])) {
                    $nameErr = "Name is required";
                } else {
                    $name = test_input($_POST["name"]);
                    if (!preg_match("/^[a-zA-Z- ]*$/",$name)) { // Dieu kien check ten
                        $nameErr = "Only english letters and white space allowed";
                    }
                }
                // Check mssv
                if(empty($_POST["mssv"])) {
                    $mssvErr = "Mssv is required";
                } else {
                    $mssv = test_input($_POST["mssv"]);
                    if (!preg_match("/^[a-zA-Z0-9]*$/",$mssv)) { // Dieu kien check tuoi
                        $mssvErr = "Only english letters and number (0-9) allowed";
                    }
                }
                // Check age
                if(empty($_POST["age"])) {
                    $ageErr = "Age is required";
                } else {
                    $age = test_input($_POST["age"]);
                    if (!preg_match("/^[0-9]*$/",$age)) { // Dieu kien check tuoi
                    $ageErr = "Only number (0-9) allowed";
                    } else {
                        if ($age > 100 && $age <= 0) {
                            $ageErr = "Invalid your age";
                        }
                    }
                }

                // Check birthday//////////////////////////////////////////////////////////////////////////////////////
                if(empty($_POST["birthday"])) {
                    $birthdayErr = "Birthday is required";
                } else {
                    $birthday = test_input($_POST["birthday"]);
                }

                // Check phone
                if(empty($_POST["phone"])) {
                    $phoneErr = "Phone is required";
                } else {
                    $phone = test_input($_POST["phone"]);
                    if (!preg_match('/^0\d{9}$/', $phone)) { // Dieu kien check phone
                        $phoneErr = "Only number (0-9) & correct your phone allowed";
                    }
                }

                // Check email
                if(empty($_POST["email"])) {
                    $emailErr = "Email is required";
                } else {
                    $email = test_input($_POST["email"]);
                    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) { // Dieu kien check email
                    $emailErr = "Invalid email format";
                    }
                }
            
                // Check address
                if(empty($_POST["address"])) {
                    $addressErr = "Address is required";
                } else {
                    $address = test_input($_POST["address"]);
                    if (!preg_match("/^[a-zA-Z0-9- ]*$/",$address)) { // Dieu kien check dia chi
                        $addressErr = "Only english letters and white space allowed";
                    }
                }
                // Check gender
                if(empty($_POST["gender"])) {
                    $genderErr = "Gender is required";
                } else {
                    $gender = test_input($_POST["gender"]);
                }

                //Check action no error
                if(empty($nameErr) && empty($mssvErr) && empty($ageErr) && empty($birthdayErr) && empty($phoneErr) && empty($emailErr) && empty($addressErr) && empty($genderErr) && empty($descriptionErr)) {
                    $action = "insert.php";
                }
            }

            function test_input($data) {
                $data = trim($data);
                $data = stripslashes($data);
                $data = htmlspecialchars($data);
                return $data;
            }
        ?>  

        <form action="<?php echo $action;?>" method="post">
            <!-- Name -->
            <div id="name">
                <label for="name">Tên: </label><br>
                <input type="text" name="name" value="<?php echo $name;?>">
                <span class="error" style="color: red;">* <br> <?php echo "$nameErr";?></span>
            </div>
            <!-- MSSV -->
            <div id="mssv">
                <label for="mssv">MSSV: </label><br>
                <input type="text" name="mssv" value="<?php echo $mssv;?>">
                <span class="error" style="color: red;">* <br> <?php echo "$mssvErr";?></span>
            </div>
            <!-- Age -->
            <div id="age">
                <label for="age">Tuổi: </label><br>
                <input type="number" name="age" value="<?php echo $age;?>">
                <span class="error" style="color: red;">* <br> <?php echo "$ageErr";?></span>
            </div>
            <!-- Birthday -->
            <div id="birthday">
                <label for="birthday">Ngày sinh: </label><br>
                <input type="date" name="birthday" value="<?php echo $birthday;?>">
                <span class="error" style="color: red;">* <br> <?php echo "$birthdayErr";?></span>
            </div>
            <!-- Phone -->
            <div id="phone">
                <label for="phone">SĐT: </label><br>
                <input type="text" name="phone" value="<?php echo $phone;?>">
                <span class="error" style="color: red;">* <br> <?php echo "$phoneErr";?></span>
            </div>
            <!-- Email -->
            <div id="email">
                <label for="email">Email: </label><br>
                <input type="text" name="email" value="<?php echo $email;?>">
                <span class="error" style="color: red;">* <br> <?php echo "$emailErr";?></span>
            </div>
            <!-- Address -->
            <div id="address">
                <label for="address">Địa chỉ: </label><br>
                <input type="text" name="address" value="<?php echo $address;?>">
                <span class="error" style="color: red;">* <br> <?php echo "$addressErr";?></span>
            </div>
            <!-- Gender -->
            <div id="gender">
                <label for="gender">Giới tính: </label><br>
                <div class="gender-optionals">
                    <input type="checkbox" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="Male">Nam
                    <input type="checkbox" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="Female">Nữ
                </div>
                <span class="error" style="color: red;">* <br> <?php echo "$genderErr";?></span>
            </div>
            <!-- Description -->
            <div id="description">
                <label for="description">Mô tả: </label>
                <span class="error" style="color: red;">* <?php echo "$descriptionErr";?></span>
                <textarea name="description" cols="30" rows="10" value="<?php echo $description;?>"></textarea>
            </div>
            <button type="submit" name="submit" value="Sumit">Thêm</button>
        </form>
    </main>
</body>
</html>