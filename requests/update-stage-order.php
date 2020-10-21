<?php

include_once('../config/db.php');

if ($_POST['stage']) {
    $stages = explode('__%__', $_POST['stage']);
    foreach ($stages as $key => $value) {
        $stage = explode(',', $value);
        $stage_id = $stage[0];
        $stage_order = $stage[1];

        $sql = 'UPDATE business SET stage_order = "'.$stage_order.'" WHERE id = "'.$stage_id.'"';
        $result = $conn->query($sql);
    }
}
?>