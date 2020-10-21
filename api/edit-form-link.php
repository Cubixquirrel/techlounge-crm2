<?php
    include_once('../config/db.php');
    include_once('../classes/login-status.php');

    $sql="
    INSERT INTO edit_form_link (
        form_id,
        panel_form_id,
        full_link
    )

    VALUES (
        '".$_GET["formId"]."',
        '".$_GET["pannel_form_id"]."',
        '".$_GET["fulllink"]."'
    )";

    if(!$result = $conn->query($sql)){
        die('There was an error running the query [' . $conn->error . ']');
    }
?>