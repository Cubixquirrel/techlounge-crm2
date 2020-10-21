<?php
include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

$form_id = $_GET['formId'];
$link = $_GET['link'];

$sql_update_form = 'UPDATE forms SET stage = "Temporarily Pending", delivered_on = "'.$form_created_on.'", is_assigned = "", is_follow_up = "", is_comment = "" WHERE id = "'.$form_id.'"';
$result_update_form = $conn->query($sql_update_form);

if ($result_update_form) {
    $sql_select_remarks = 'SELECT * FROM forms WHERE id = "'.$form_id.'"';
    $result_select_remarks = $conn->query($sql_select_remarks);
    $row_select_remarks = $result_select_remarks->fetch_assoc();

    $new_remarks = 'Automated marked & mailed to Temporarily Pending as client has incomplete uploads.<br><br>Link to upload document:<br>'.$link.'';

    if ($row_select_remarks['remarks'] == '') {
        $sql_update_remarks = 'UPDATE forms SET remarks = "'.$new_remarks.'" WHERE id = "'.$form_id.'"';
    } else {
        $sql_update_remarks = 'UPDATE forms SET remarks = "'.$row_select_remarks["remarks"].'__%__'.$new_remarks.'" WHERE id = "'.$form_id.'"';
    }
    $result_update_remarks = $conn->query($sql_update_remarks);

    $sql ="
    INSERT INTO timeline (
    meta_id,
    meta_name,
    meta_description,
    meta_user,
    form_created_on,
    form_created_time
    )

    VALUES (
    '".$form_id."',
    'stage',
    'Temporarily Pending__%__".$new_remarks."',
    '***',
    '".$form_created_on_date."',
    '".$form_created_on_time."'
    )";

    if(!$result = $conn->query($sql)) {
        die('There was an error running the query [' . $conn->error . ']');
    }
    else {
        echo 'Form Updated.';
    }
}
?>