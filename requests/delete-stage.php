<?php
include_once('../config/db.php');

if (($_POST['businessId'] != '') && ($_POST['stageId'] != '')) {
    $sql_select_business = 'SELECT * FROM business WHERE id = "'.$_POST["stageId"].'"';
    $result_select_business = $conn->query($sql_select_business);
    $row_select_business = $result_select_business->fetch_assoc();
    $stage = $row_select_business['stage'];

    $sql_delete_business = 'DELETE FROM business WHERE id = "'.$_POST["stageId"].'"';
    $result_delete_business = $conn->query($sql_delete_business);

    if ($result_delete_business) {
        $sql_select_users_team = 'SELECT * FROM users_team WHERE id = "'.$_POST["businessId"].'"';
        $result_select_users_team = $conn->query($sql_select_users_team);
        $row_select_users_team = $result_select_users_team->fetch_assoc();
        $business = $row_select_users_team['team'];

        $sql_delete_email_processor = 'DELETE FROM email_processor WHERE business_stage = "'.$stage.'" AND business_name = "'.$business.'"';
        $result_delete_email_processor = $conn->query($sql_delete_email_processor);

        if ($result_delete_email_processor) {
            echo 'Deleted Successfully';
        }
    }
}

?>