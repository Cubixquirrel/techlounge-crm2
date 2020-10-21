<?php
// https://crm2.techlounge.co.in/api/razorpay-payload.php
// http://localhost/crm2.techlounge.co.in/api/razorpay-payload.php

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

if (($event == 'payment.authorized') OR ($event == 'payment.failed')) {
    $sql_select_forms = "SELECT * FROM forms WHERE (mobile = '".$parsed_mobile."' OR email = '$email') AND status != 'Paid' ORDER BY id DESC LIMIT 1";
} else if (($event == 'refund.created') OR ($event == 'refund.processed') OR ($event == 'payment.dispute.created') OR ($event == 'payment.dispute.won') OR ($event == 'payment.dispute.lost') OR ($event == 'payment.dispute.closed')) {
    $sql_select_forms = "SELECT * FROM forms WHERE payment_id = '".$payment_id."'";
}
$result_select_forms = $conn->query($sql_select_forms);

// If user is found
if ($result_select_forms->num_rows > 0) {
    $row_select_forms = $result_select_forms->fetch_assoc();
    $sql_update_forms = 
    "
    UPDATE forms SET
    pay_vendor = '".$merchant_name."', pay_status = '".$pay_status."', payment_id = '".$payment_id."', order_id = '".$order_id."', 
    amount = '".$parsed_amount."', 
    mobile = '".$parsed_mobile."', email = '".$email."', 
    date = '".$form_created_on."', form_date = '".$form_date."', form_month = '".$form_month."', form_year = '".$form_year."' 
    WHERE id = '".$row_select_forms['id']."'
    ";
    $result_update_forms = $conn->query($sql_update_forms);
    $form_id = $row_select_forms['id'];
}

// if user is not found
else {
    $sql_insert_forms = 
    "
    INSERT INTO forms (
    form_id, vendor_array, business_array, website_array, amount_array, status_array,
    pay_vendor, pay_status, payment_id, order_id,
    type, vendor, business, website, amount, status, 
    name, mobile, email,
    assigned_to, 
    date, form_date, form_month, form_year
    )

    VALUES (
    '-', '-', '-', '-', '-', '-',
    '".$merchant_name."', '".$pay_status."', '".$payment_id."', '".$order_id."',
    'Website', '".$vendor."', '".$website_business."', '".$website_name."', '".$parsed_amount."', 'Unpaid', 
    '-', '".$parsed_mobile."', '".$email."',
    'Sales Log', 
    '".$form_created_on."', '".$form_date."', '".$form_month."', '".$form_year."'
    )";
    $result_insert_forms = $conn->query($sql_insert_forms);
    $form_id = $conn->insert_id;
}
echo $form_id;
?>