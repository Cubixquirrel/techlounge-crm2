<?php

include_once('../config/db.php');

$total_ids = count(explode(',', $_POST['id']));
$i = 0;
foreach (explode(',', $_POST['id']) as $key => $value) {
    $sql_select_forms = 'SELECT * FROM forms WHERE id = "'.$value.'"';
    $result_select_forms = $conn->query($sql_select_forms);
    $row_select_forms = $result_select_forms->fetch_assoc();
    $status = $row_select_forms['status'];
    $name = $row_select_forms['name'];

    if (($_POST['type'] == 'Sales') && ($status == 'Unpaid')) {
        $sql_update_forms = 'UPDATE forms SET assigned_to = "'.$_POST["name"].'" WHERE id = "'.$value.'"';
        $result_update_forms = $conn->query($sql_update_forms);
    } else if (($_POST['type'] == 'Processor') && ($status == 'Paid')) {
        $sql_update_forms = 'UPDATE forms SET processor = "'.$_POST["name"].'" WHERE id = "'.$value.'"';
        $result_update_forms = $conn->query($sql_update_forms);
    } else {
        if (++$i === $total_ids) {
            echo '"'.$name.'" cannot be marked to '.strtolower($_POST["type"]).' "'.$_POST["name"].'" as form is '.strtolower($status).'.';
        } else {
            echo '"'.$name.'" cannot be marked to '.strtolower($_POST["type"]).' "'.$_POST["name"].'" as form is '.strtolower($status).'.<br>';
        }
    }
}

?>