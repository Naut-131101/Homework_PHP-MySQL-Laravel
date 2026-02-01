<!DOCTYPE html>
<html>
<body>
    <?php
        function is_str_lowercase($str1) {
            $sc = 0;
            while($sc < strlen($str1)) {
                if(ord($str1[$sc]) >= ord('A') && ord($str1[$sc]) <= ord('Z')) {
                    return false;
                }
                $sc++;
            }
            return true;
        }
        var_dump(is_str_lowercase("hello"));
        echo "<br>";
        var_dump(is_str_lowercase("Hello"));
    ?>
</body>
</html>