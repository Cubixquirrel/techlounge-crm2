<?php

include_once("../config/db.php");
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_date = date('d');
$form_month = date('m');
$form_year = date('Y');

$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

$client_id = $_POST['clientId'];
$status_id = $_POST['statusId'];

$sql_select_complaint_status = 'SELECT * FROM complaint_status WHERE id = "'.$status_id.'"';
$result_select_complaint_status = $conn->query($sql_select_complaint_status);
$row_select_complaint_status = $result_select_complaint_status->fetch_assoc();
$title = $row_select_complaint_status['title'];
$description = $row_select_complaint_status['description'];

$sql_select_forms = 'SELECT * FROM forms WHERE id = "'.$client_id.'"';
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->fetch_assoc();
$client_mobile = $row_select_forms['mobile'];

$sql_select_complaint_forms = 'SELECT * FROM complaint_forms WHERE mobile_number = "'.$client_mobile.'" ORDER BY id DESC LIMIT 1';
$result_select_complaint_forms = $conn->query($sql_select_complaint_forms);
if ($result_select_complaint_forms->num_rows == 1) {
    $row_select_complaint_forms = $result_select_complaint_forms->fetch_assoc();
    $complaint_id = $row_select_complaint_forms['complaint_id'];
    $website = strtolower($row_select_complaint_forms['website']);

    $sql_update_forms = 'UPDATE forms SET complaint_status = "'.$status_id.'" WHERE id = "'.$client_id.'"';
    $result_update_forms = $conn->query($sql_update_forms);
}

$sql =
"
INSERT INTO complaint_timeline (
    meta_id,
    meta_name,
    meta_description,
    meta_user,
    meta_type,
    form_created_on,
    form_created_time
)

VALUES (
    '".$complaint_id."',
    'complaint form',
    'Form Status: ".$title." (".$description.")',
    '".$user_name."',
    'out',
    '".$form_created_on_date."',
    '".$form_created_on_time."'
)
";

if (!$result = $conn->query($sql)) {
    die('There was an error running the query [' . $conn->error . ']');
}
else {
    $post = [
        'meta_id'           => $complaint_id,
        'meta_name'         => 'complaint form',
        'meta_description'  => 'Form Status: '.$title.' ('.$description.')',
        'meta_user'         => 'Agent',
        'form_created_on'   => $form_created_on_date,
        'form_created_time' => $form_created_on_time
    ];
    
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $ch = curl_init('http://localhost/'.$website.'/complaint-api.php');
    } else {
        $ch = curl_init('https://'.$website.'/complaint-api.php');
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
    $response = curl_exec($ch);
    curl_close($ch);
}

?>