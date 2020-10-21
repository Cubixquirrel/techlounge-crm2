<?php
include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$today = date('d-m-Y H:i:s');

$stage = 'OTP Not Given';
$processor = $user_name;

if (($processor == 'Amit Khirwal') OR ($processor == 'RK Thakur') OR ($processor == 'Fahad Razi')) {
    $sql_select_forms = "SELECT * FROM forms WHERE status = 'Paid' AND stage = '".$stage."' AND delivered_on != '' AND schedule_date != '' ORDER BY schedule_date ASC";    
} else {
    $sql_select_forms = "SELECT * FROM forms WHERE status = 'Paid' AND processor = '".$processor."' AND stage = '".$stage."' AND delivered_on != '' AND schedule_date != '' ORDER BY schedule_date ASC";
}
$result_select_forms = $conn->query($sql_select_forms);
while($row_select_forms = $result_select_forms->fetch_assoc()) {
    $schedule_date = $row_select_forms['schedule_date'];
    $current_date  = $today;

    if (
        (strtotime($current_date) > strtotime($schedule_date) - 300) && 
        (strtotime($current_date) < strtotime($schedule_date))
    ) {
        $client_id = $row_select_forms['id'];
        $name = $row_select_forms['name'];
        $mobile = $row_select_forms['mobile'];

        $time_left = floor(((strtotime($schedule_date) - strtotime($current_date)) / 60) + 1);

        echo 
        $client_id . '__%__' . 
        $name . '__%__' . 
        $mobile . '__%__' . 
        $schedule_date . '__%__' . 
        $time_left . '__%%__';
    }
}
?>