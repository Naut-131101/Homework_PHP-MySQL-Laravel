<html>
    <style>
        table, th, td {
            border:1px solid black;
        }
    </style>
<body>
    <h1>Welcome <?php echo $_POST["name"]; ?></h1>
    <p>Chúng tôi luôn chào đón bạn!!! Newbie</p>
    <?php
        $myfile = fopen("Amin_DSSV.txt", "a") or die("Unable to open file!");
        $txt = "Full Name: " . $_POST["name"] . "\n";
        fwrite($myfile, $txt);
        $txt = "Age: " . $_POST["age"] . "\n";
        fwrite($myfile, $txt);
        $txt = "Email: " . $_POST["email"] . "\n";
        fwrite($myfile, $txt);
        $txt = "Phone: " . $_POST["phone"] . "\n";
        fwrite($myfile, $txt);
        $txt = "Address: " . $_POST["address"] . "\n";
        fwrite($myfile, $txt);
        $txt = "Gender: " . $_POST["gender"] . "\n\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    ?>
</body>
</html>