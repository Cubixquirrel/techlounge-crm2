<?php
include_once('../config/db.php');
include_once('../classes/login-status.php');

$sql_select_forms = 'SELECT * FROM forms WHERE schedule_cid = "'.$_GET['cid'].'"';
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->fetch_assoc();
$cid_result = $row_select_forms['schedule_cid'];
$client_id = $row_select_forms['id'];

if ($_GET['cid'] == $cid_result) {
    $name = $row_select_forms['name'];
    $mobile = $row_select_forms['mobile'];
    $email = $row_select_forms['email'];

    echo $name . '__%__' . $mobile . '__%__' . $email;
} else {
    echo '__%____%__';
}
?>