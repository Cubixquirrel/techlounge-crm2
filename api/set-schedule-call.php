<?php
include_once('../config/db.php');

$sql_select_forms = 'SELECT * FROM forms WHERE schedule_cid = "'.$_GET['cid'].'"';
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->fetch_assoc();
$cid_result = $row_select_forms['schedule_cid'];
$client_id = $row_select_forms['id'];

if ($_GET['cid'] == $cid_result) {
    $schedule_date = $_GET["schedule_date"] . ':00';
    if (isset($_GET["schedule_date"]) && $_GET["schedule_date"] != '') {
        $sql_update_forms = 'UPDATE forms SET schedule_date = "'.$schedule_date.'", is_updated = "true" WHERE id = "'.$client_id.'"';
        $result_update_forms = $conn->query($sql_update_forms);
        if ($result_update_forms) { 
            echo 'Schedule Succesfully.';
        }
    }
}
?>