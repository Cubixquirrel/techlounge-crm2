<?php

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

if (($_POST['type'] == 'sms') && ($_POST['clientId'] != '') && ($_POST['messageId'] != '')) {
    
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
    '".$_POST['clientId']."',
    '".$_POST['type']."',
    '".$_POST['messageId']."',
    '".$user_name."',
    '".$form_created_on_date."',
    '".$form_created_on_time."'
    )";

    if(!$result = $conn->query($sql)){
        die('There was an error running the query [' . $conn->error . ']');
    }
    else
    {
        echo 'Data Inserted';
    }

}

else if (($_POST['type'] == 'email') && ($_POST['clientId'] !== '') && ($_POST['messageId'] != '')) {

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
    '".$_POST['clientId']."',
    '".$_POST['type']."',
    '".$_POST['messageId']."',
    '".$user_name."',
    '".$form_created_on_date."',
    '".$form_created_on_time."'
    )";

    if(!$result = $conn->query($sql)){
        die('There was an error running the query [' . $conn->error . ']');
    }
    else
    {
        echo 'Data Inserted';
    }

}

else if (($_POST['type'] == 'whatsapp') && ($_POST['clientId'] !== '') && ($_POST['messageId'] != '')) {

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
    '".$_POST['clientId']."',
    '".$_POST['type']."',
    '".$_POST['messageId']."',
    '".$user_name."',
    '".$form_created_on_date."',
    '".$form_created_on_time."'
    )";

    if(!$result = $conn->query($sql)){
        die('There was an error running the query [' . $conn->error . ']');
    }
    else
    {
        echo 'Data Inserted';
    }

}