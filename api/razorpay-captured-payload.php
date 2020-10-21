<?php
// https://crm2.techlounge.co.in/api/razorpay-captured-payload.php
// http://localhost/crm2.techlounge.co.in/api/razorpay-captured-payload.php

include_once('../config/db.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_date = date('d');
$form_month = date('m');
$form_year = date('Y');

$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

$json = file_get_contents('php://input');
$data = json_decode($json);

$account_id = $data->account_id;
$event = $data->event;
$payment_id = $data->payload->payment->entity->id;
$order_id = $data->payload->payment->entity->order_id;
$amount = $data->payload->payment->entity->amount;
$email = $data->payload->payment->entity->email;
$mobile = $data->payload->payment->entity->contact;

$sql_select_razorpay_merchant = 'SELECT * FROM razorpay_merchant WHERE merchant_id = "'.$account_id.'"';
$result_select_razorpay_merchant = $conn->query($sql_select_razorpay_merchant);
$row_select_razorpay_merchant = $result_select_razorpay_merchant->fetch_assoc();

$merchant_name = $row_select_razorpay_merchant['merchant_name'];
$website_name = $row_select_razorpay_merchant['website_name'];
$vendor = $row_select_razorpay_merchant['vendor'];
$website_business = $row_select_razorpay_merchant['business'];

$parsed_amount = $amount / 100;
$parsed_mobile = substr($mobile, 3, 13);

$pay_status = ucwords(str_replace('.', ' ', $event));

$sql_select_forms = "SELECT * FROM forms WHERE (mobile = '".$parsed_mobile."' OR email = '$email') AND status != 'Paid' ORDER BY id DESC LIMIT 1";
$result_select_forms = $conn->query($sql_select_forms);

$sql_select_users = "SELECT * FROM users WHERE FIND_IN_SET('Processor', user_role) AND user_status = 'true' AND is_hold = 'false' AND FIND_IN_SET('".$website_business."', user_team) ORDER BY RAND() LIMIT 1";
$result_select_users = $conn->query($sql_select_users);
if ($result_select_users->num_rows > 0) {
    $row_select_users = $result_select_users->fetch_assoc();
    $assigned_to = $row_select_users['user_name'];
} else {
    $assigned_to = 'Processor Log';
}

// If user is found
if ($result_select_forms->num_rows > 0) {
    $row_select_forms = $result_select_forms->fetch_assoc();
    $stage = 'Pending';

    $sql_update_forms = 
    "
    UPDATE forms SET
    pay_vendor = '".$merchant_name."', pay_status = '".$pay_status."', payment_id = '".$payment_id."', order_id = '".$order_id."',             
    amount = '".$parsed_amount."', status = 'Paid', 
    mobile = '".$parsed_mobile."', email = '".$email."', 
    processor = '".$assigned_to."', stage = '".$stage."', 
    date = '".$form_created_on."', form_date = '".$form_date."', form_month = '".$form_month."', form_year = '".$form_year."' 
    WHERE id = '".$row_select_forms['id']."'
    ";
    $result_update_forms = $conn->query($sql_update_forms);
    $form_id = $row_select_forms['id'];
}

// if user is not found
else {
    $stage = 'DNF';

    $sql_insert_forms = 
    "
    INSERT INTO forms (
    form_id, vendor_array, business_array, website_array, amount_array, status_array,
    pay_vendor, pay_status, payment_id, order_id,
    type, vendor, business, website, amount, status,
    name, mobile, email,
    assigned_to, processor, stage, delivered_on,
    date, form_date, form_month, form_year
    )

    VALUES (
    '-', '-', '-', '-', '-', '-',
    '".$merchant_name."', '".$pay_status."', '".$payment_id."', '".$order_id."',
    'Website', '".$vendor."', '".$website_business."', '".$website_name."', '".$parsed_amount."', 'Paid',
    '-', '".$parsed_mobile."', '".$email."',
    'Sales Log', '".$assigned_to."', '".$stage."', '".$form_created_on."',
    '".$form_created_on."', '".$form_date."', '".$form_month."', '".$form_year."'
    )";
    $result_insert_forms = $conn->query($sql_insert_forms);
    $form_id = $conn->insert_id;
}

$sql_insert_timeline = 
"
INSERT INTO timeline (
meta_id, meta_name, meta_description, meta_user,
form_created_on, form_created_time
)
VALUES (
'".$form_id."', 'form', 'Payment successfull', '-',
'".$form_created_on_date."', '".$form_created_on_time."'
)
";
$result_insert_timeline = $conn->query($sql_insert_timeline);
echo $form_id;
?>