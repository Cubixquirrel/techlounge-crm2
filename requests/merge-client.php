<?php

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

$from_client_id = $_POST['fromClientId'];
$to_client_id = $_POST['toClientId'];

// merge from payment dnf
$sql_select_from_form = 'SELECT * FROM forms WHERE id = "'.$from_client_id.'"';
$result_select_from_form = $conn->query($sql_select_from_form);
$row_select_from_form = $result_select_from_form->fetch_assoc();
// echo $row_select_from_form['mobile'] . "\n";

// merge to master data lead
$sql_select_to_form = 'SELECT * FROM forms WHERE id = "'.$to_client_id.'"';
$result_select_to_form = $conn->query($sql_select_to_form);
$row_select_to_form = $result_select_to_form->fetch_assoc();
// echo $row_select_to_form['mobile'];

if (
    ($row_select_from_form["pay_vendor"] != '') && 
    ($row_select_from_form["payment_id"] != '') && 
    ($row_select_from_form["order_id"] != '')
) {
    $pay_vendor = $row_select_from_form["pay_vendor"];
    $payment_id = $row_select_from_form["payment_id"];
    $order_id = $row_select_from_form["order_id"];
} else {
    $pay_vendor = $row_select_to_form["pay_vendor"];
    $payment_id = $row_select_to_form["payment_id"];
    $order_id = $row_select_to_form["order_id"];
}

if ($row_select_to_form['remarks'] == '') {
    $sql_update_remarks = 'UPDATE forms SET remarks = "Client form has been merged from '.$row_select_from_form["mobile"].' to '.$row_select_to_form["mobile"].'" WHERE id = "'.$row_select_to_form["id"].'"';
} else {
    $sql_update_remarks = 'UPDATE forms SET remarks = "'.$row_select_to_form['remarks'].'__%__Client form has been merged from '.$row_select_from_form["mobile"].' to '.$row_select_to_form["mobile"].'" WHERE id = "'.$row_select_to_form["id"].'"';
}
$result_update_remarks = $conn->query($sql_update_remarks);

$sql_update_form = 
'
UPDATE forms SET 
pay_vendor = "'.$pay_vendor.'", 
payment_id = "'.$payment_id.'", 
order_id = "'.$order_id.'", 
status = "Paid", 
mobile = "'.$row_select_from_form["mobile"].'", 
email = "'.$row_select_from_form["email"].'", 
processor = "'.$row_select_from_form["processor"].'", 
stage = "Pending", 
delivered_on = "'.$row_select_from_form["delivered_on"].'", 
date = "'.$row_select_from_form["date"].'", 
form_date = "'.$row_select_from_form["form_date"].'", 
form_month = "'.$row_select_from_form["form_month"].'"
WHERE 
id = "'.$row_select_to_form["id"].'"
';
$result_update_form = $conn->query($sql_update_form);

if ($result_update_form) {
    $sql_delete_form = 'DELETE FROM forms WHERE id = "'.$row_select_from_form["id"].'"';
    $result_delete_form = $conn->query($sql_delete_form);

    $sql_update_timeline = 'UPDATE timeline SET meta_id = "'.$row_select_to_form["id"].'" WHERE meta_id = "'.$row_select_from_form["id"].'"';
    $result_update_timeline = $conn->query($sql_update_timeline);

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
    '".$row_select_to_form['id']."',
    'comment',
    'Client form has been merged from ".$row_select_from_form['mobile']." to ".$row_select_to_form['mobile']."',
    '".$user_name."',
    '".$form_created_on_date."',
    '".$form_created_on_time."'
    )";
    $result_insert_timeline = $conn->query($sql_insert_timeline);
}

?>