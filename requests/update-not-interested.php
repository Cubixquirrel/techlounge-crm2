<?php

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

if (($_POST['type'] == 'comment') && ($_POST['clientId'] !== '') && ($_POST['message'] != '')) {
    $sql =
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
    '".$_POST['clientId']."',
    'dropped',
    '".$_POST['message']."',
    '".$user_name."',
    '".$form_created_on_date."',
    '".$form_created_on_time."'
    )
    ";

    if(!$result = $conn->query($sql)){
        die('There was an error running the query [' . $conn->error . ']');
    }
    else {
        $sqlUpdate = "UPDATE forms SET dropped = 'true', dropped_by = '".$user_name."', date = '".$form_created_on."' WHERE id = '".$_POST['clientId']."'";
        $resultUpdate = $conn->query($sqlUpdate);

        echo 'Data Dropped';
    }
}

?>