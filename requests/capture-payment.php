<?php
include_once('../config/db.php');
include_once('../razorpay/Razorpay.php');

use Razorpay\Api\Api;

$sql_select_forms = 'SELECT * FROM forms WHERE id = "'.$_POST["clientId"].'"';
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->fetch_assoc();
$pay_vendor = $row_select_forms['pay_vendor'];
$payment_id = $row_select_forms['payment_id'];
$amount = $row_select_forms['amount'] * 100;

$sql_select_razorpay_merchant = 'SELECT * FROM razorpay_merchant WHERE merchant_name = "'.$pay_vendor.'"';
$result_select_razorpay_merchant = $conn->query($sql_select_razorpay_merchant);
$row_select_razorpay_merchant = $result_select_razorpay_merchant->fetch_assoc();
$key_id = $row_select_razorpay_merchant['key_id'];
$key_secret = $row_select_razorpay_merchant['key_secret'];

$api = new Api($key_id, $key_secret);

$payment = $api->payment->fetch($payment_id);
$payment->capture(array('amount' => $amount, 'currency' => 'INR'));

$json = file_get_contents('php://input');
$data = json_decode($json);
$status = $data->status;

if ($status == 'captured') {
    echo 'Payment Captured';
}

?>