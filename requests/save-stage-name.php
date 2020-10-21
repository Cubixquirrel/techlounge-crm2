<?php
include_once('../config/db.php');

if (($_POST['businessId'] != '') && ($_POST['stageId'] != '') && ($_POST['stageName'] != '')) {
    $sql_select_business = 'SELECT * FROM business WHERE id = "'.$_POST["stageId"].'"';
    $result_select_business = $conn->query($sql_select_business);
    $row_select_business = $result_select_business->fetch_assoc();
    $old_stage_name = $row_select_business['stage'];

    $sql_update_business = 'UPDATE business SET stage = "'.$_POST["stageName"].'" WHERE id = "'.$_POST["stageId"].'"';
    $result_update_business = $conn->query($sql_update_business);

    if ($result_update_business) {
        $sql_update_forms = 'UPDATE forms SET stage = "'.$_POST["stageName"].'" WHERE stage = "'.$old_stage_name.'"';
        $result_update_forms = $conn->query($sql_update_forms);        

        if ($result_update_forms) {
            $sql_select_users_team = 'SELECT * FROM users_team WHERE id = "'.$_POST["businessId"].'"';
            $result_select_users_team = $conn->query($sql_select_users_team);
            $row_select_users_team = $result_select_users_team->fetch_assoc();
            $business = $row_select_users_team['team'];

            $sql_update_email_processor = 'UPDATE email_processor SET business_stage = "'.$_POST["stageName"].'" WHERE business_stage = "'.$old_stage_name.'" AND business_name = "'.$business.'"';
            $result_update_email_processor = $conn->query($sql_update_email_processor);

            if ($result_update_email_processor) {
                echo 'Renamed Successfully';
            }
        }
    }
}

?>