<?php

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');

foreach (explode(',', $_POST['id']) as $key => $value) {
    $sql_update_forms = 'UPDATE users SET is_hold = "false" WHERE user_id = "'.$value.'"';
    $result_update_forms = $conn->query($sql_update_forms);
    echo 'Unblocked successfully.';
}

?>