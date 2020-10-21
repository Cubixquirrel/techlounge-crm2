<?php

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

foreach (explode(',', $_POST['id']) as $key => $value) {
    $sql_select_forms = 'SELECT * FROM forms WHERE id = "'.$value.'"';
    $result_select_forms = $conn->query($sql_select_forms);
    $row_select_forms = $result_select_forms->fetch_assoc();
    $remarks = $row_select_forms['remarks'];

    if ($remarks == '') {
        $sql_update_forms = 
        '
        UPDATE forms SET 
        processor = "'.$user_name.'", stage = "'.$_POST["stage"].'", 
        delivered_on = "'.$form_created_on.'", remarks = "'.$_POST["remarks"].'", 
        is_follow_up = "", is_comment = "", is_assigned = "", is_updated = "" 
        WHERE id = "'.$value.'"
        ';
    } else {
        $sql_update_forms = 
        '
        UPDATE forms SET 
        processor = "'.$user_name.'", stage = "'.$_POST["stage"].'", 
        delivered_on = "'.$form_created_on.'", remarks = "'.$remarks.'__%__'.$_POST["remarks"].'", 
        is_follow_up = "", is_comment = "", is_assigned = "", is_updated = "" 
        WHERE id = "'.$value.'"
        ';
    }
    $result_update_forms = $conn->query($sql_update_forms);

    $sql_insert_timeline = 
    "
    INSERT INTO timeline (
    meta_id,
    meta_name,
    meta_description,
    meta_user,
    form_created_on,
    form_created_time
    )

    VALUES (
    '".$value."',
    'stage-mark',
    '".$_POST['stage']."__%__".$_POST['remarks']."',
    '".$user_name."',
    '$form_created_on_date',
    '$form_created_on_time'
    )
    ";
    $result_insert_timeline = $conn->query($sql_insert_timeline);

    if ($result_insert_timeline) {
        echo 'Marked successfully';
    }
}

?>