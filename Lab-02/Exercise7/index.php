<!DOCTYPE html>
<html>
<body>
    <?php
        function check_palindrome($string) {
            if($string == strrev($string)) {
                return 1;
            } else { 
                return 0;
            }
        }
        echo check_palindrome("madam");
        echo "<br>";
        echo check_palindrome("hello");
    ?>
</body>
</html>