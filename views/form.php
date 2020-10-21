<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../config/db.php');
include_once('../classes/login-status.php');
include_once('../json/website-data.php');

date_default_timezone_set('Asia/Kolkata');
$today = date('d-m-Y');

$page_title = 'Form';

function generateToken($length = 7) {
    $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $token = '';
    while(strlen($token) < $length) {
        $token .= $chars[mt_rand(0, strlen($chars)-1)];
    }
    return $token;
}
$cid_generated = generateToken(16);

$sql_client_id = "SELECT * FROM cid WHERE client_id = '".$_GET['clientId']."' AND form_id = '".$_GET['formId']."'";
$result_client_id = $conn->query($sql_client_id);
$row_client_id = $result_client_id->fetch_assoc();

if ($row_client_id['cid'] == '') {
    $sql_insert_cid = "INSERT INTO cid (cid, client_id, form_id) VALUES ('".$cid_generated."', '".$_GET['clientId']."', '".$_GET['formId']."')";
    $result_insert_cid = $conn->query($sql_insert_cid);
}

$sqlSelectForms = "SELECT * FROM forms WHERE id = '".$_GET['clientId']."'";
$resultSelectForms = $conn->query($sqlSelectForms);
$rowSelectForms = $resultSelectForms->fetch_assoc();

$form_id_array  = array_reverse(preg_split("/\,/", $rowSelectForms["form_id"]));
$business_array = array_reverse(preg_split("/\,/", $rowSelectForms["business_array"]));
$website_array  = array_reverse(preg_split("/\,/", $rowSelectForms["website_array"]));
$amount_array   = array_reverse(preg_split("/\,/", $rowSelectForms["amount_array"]));

$search_key_form_id = array_search($_GET['formId'], $form_id_array);

$hostname = array($website_data)[0][$website_array[$search_key_form_id]]['hostname'];
$username = array($website_data)[0][$website_array[$search_key_form_id]]['username'];
$password = array($website_data)[0][$website_array[$search_key_form_id]]['password'];
$database = array($website_data)[0][$website_array[$search_key_form_id]]['database'];

if ($amount_array[$search_key_form_id] == 'ENQUIRY') {
    $table = array($website_data)[0][$website_array[$search_key_form_id]]['table']['ENQUIRY'];
} else {
    $table = array($website_data)[0][$website_array[$search_key_form_id]]['table'][$business_array[$search_key_form_id]];
}

$remote_conn = new mysqli($hostname, $username, $password, $database);
if ($remote_conn->connect_error) {
    die("Connection failed: " . $remote_conn->connect_error);
}

$select_form = "SELECT * FROM $table WHERE id = '".$form_id_array[$search_key_form_id]."'";
$result_select_form = $remote_conn->query($select_form);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/form.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fonts/style.css">
</head>
<body>
    <div class="loader">
        <div class="spinner-border">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php include_once('../classes/database-count.php'); ?>
    <?php include_once('../components/sidebar.php'); ?>

    <?php include_once('../components/form.php'); ?>

    <script src="../assets/js/logout.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/sidebar.js"></script>
    <script src="../assets/js/form.js"></script>
</body>
</html>