<!DOCTYPE html>
<html>
<body>
    <?php
        function sum($a, $b, $c) {
            $calc = $a + $b + $c;
            return $calc;
        }
        function average($a, $b, $c) {
            $calc = ($a + $b + $c) / 3;
            return $calc;
        }
        echo "SUM: " . sum(1, 2, 3) . "<br>";
        echo "AVERAGE: " . average(1, 2, 3) . "<br>";
    ?>
</body>
</html>