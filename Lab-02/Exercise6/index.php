<!DOCTYPE html>
<html>
<body>
    <?php
        function array_not_unique($my_array) {
            $same = array(); # 'same' is an empty array
            natcasesort($my_array);
            reset($my_array);
            $old_key = NULL;
            $old_value = NULL;

            foreach($my_array as $key => $value) {
                if($value === NULL) {
                    continue;
                } else {
                    if($old_value == $value) {
                        $same[$old_key] = $old_value;
                        $same[$key] = $value;
                    } 
                    $old_value = $value;
                    $old_key = $key;
                    continue;
                }
            }
            return $same;
        };

        $arr = array('A', 'b', 'a', 'C', 'b');
        $result = array_not_unique($arr);
        var_dump($result);
    ?>
</body>
</html>