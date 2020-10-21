<?php
include_once('../config/db.php');
include_once('../classes/login-status.php');

$sql_select_cid = 'SELECT * FROM cid WHERE cid = "'.$_GET['cid'].'"';
$result_select_cid = $conn->query($sql_select_cid);
$row_select_cid = $result_select_cid->fetch_assoc();
$cid_result = $row_select_cid['cid'];
$client_id = $row_select_cid['client_id'];

if ($_GET['cid'] == $cid_result) {
    $sql_select_id = 'SELECT * FROM forms WHERE id = "'.$client_id.'"';
    $result_select_id = $conn->query($sql_select_id);
    $row_select_id = $result_select_id->fetch_assoc();

    $name = $row_select_id['name'];
    $mobile = $row_select_id['mobile'];
    $email = $row_select_id['email'];

    echo $name . '__%__' . $mobile . '__%__' . $email;
} else {
    echo '__%____%__';
}
?>