<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register</title>
  <style>
    .register  {
      display:block;
      justify-self: center;
      border: 1px solid black;
      padding: 10px 20px;
      background-color: greenyellow;
      border-radius: 12px;
      width: 300px;
    }

    .register h2 {
      margin: 0;
      font-size: 20px;
      text-align: center;
    }

    .register p {
      margin: 0;
      font-size: 16px;
    }

    form {
      justify-content: center;
      font-size: 14px;
      padding-top: 20px;
    }

    .input-text {
      background-color: whitesmoke;
      display: flex;
      text-align: left;
      justify-self: stretch;
      margin: 0;
      padding: 2px;
    }
    .input-submit {
      background-color: burlywood;
      padding: 0px 50px;
      justify-self: center;
      display: flex;
    }

  </style>
</head>
<body>
  <?php
    $name = $age = $email = $phone = $address = $gender = "";
    $nameErr = $ageErr = $emailErr = $phoneErr = $addressErr = $genderErr = "";
    $action = test_input($_SERVER["PHP_SELF"]);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Check name
      if(empty($_POST["name"])) {
        $nameErr = "Name is required";
      } else {
        $name = test_input($_POST["name"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) { // Dieu kien check ten
          $nameErr = "Only letters and white space allowed";
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
          if ($age >= 100 || $age = 0) {
            $ageErr = "Invalid your age";
          }
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
      // Check phone
      if(empty($_POST["phone"])) {
        $phoneErr = "Phone is required";
      } else {
        $phone = test_input($_POST["phone"]);
        if (!preg_match('/^0\d{9}$/', $phone)) { // Dieu kien check phone
          $phoneErr = "Only number (0-9) & correct your phone allowed";
        }
      }
      // Check address
      if(empty($_POST["address"])) {
        $addressErr = "Address is required";
      } else {
        $address = test_input($_POST["address"]);
        if (!preg_match("/^[a-zA-Z0-9- ]*$/",$address)) { // Dieu kien check dia chi
          $addressErr = "Only letters and white space allowed";
        }
      }
      // Check gender
      if(empty($_POST["gender"])) {
        $genderErr = "Gender is required";
      } else {
        $gender = test_input($_POST["gender"]);
      }

      //Check action no error
      if(empty($nameErr) && empty($ageErr) && empty($emailErr) && empty($phoneErr) && empty($addressErr) && empty($genderErr)) {
        $action = "welcome.php";
      }
    }

    function test_input($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }
  ?>    
  <div class="register">
    <h2>Đăng kí thông tin sinh viên</h2>
    <p><span class="error" style="color: red;">Notice: * is required</span></p>
    <div class="form-register">
      <form action="<?php echo $action;?>" method="post">
        Name: <input class="input-text" type="text" name="name" value="<?php echo $name;?>">
        <span class="error" style="color: red;">* <?php echo "$nameErr";?></span>
        <br><br>
        Age: <input class="input-text" type="text" name="age" value="<?php echo $age;?>">
        <span class="error" style="color: red;">* <?php echo "$ageErr";?></span>
        <br><br>
        Email: <input class="input-text" type="text" name="email" value="<?php echo $email;?>">
        <span class="error" style="color: red;">* <?php echo "$emailErr";?></span>
        <br><br>
        Phone: <input class="input-text" type="text" name="phone" value="<?php echo $phone;?>">
        <span class="error" style="color: red;">* <?php echo "$phoneErr";?></span>
        <br><br>
        Address: <input class="input-text" type="text" name="address" value="<?php echo $address;?>">
        <span class="error" style="color: red;">* <?php echo "$addressErr";?></span>
        <br><br>
        Gender:
        <input class="input-radio" type="radio" name="gender" <?php if (isset($gender) && $gender=="female") echo "checked";?> value="Female">Female
        <input class="input-radio" type="radio" name="gender" <?php if (isset($gender) && $gender=="male") echo "checked";?> value="Male">Male
        <span class="error" style="color: red;">* <?php echo "$genderErr";?></span>
        <br><br>
        <input class="input-submit" type="submit" name="submit" value="Submit">
      </form>
    </div>
  </div>
</body>
</html>