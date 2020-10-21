<?php
include_once('../config/db.php');

$sql_select_cid = 'SELECT * FROM cid WHERE cid = "'.$_GET['cid'].'"';
$result_select_cid = $conn->query($sql_select_cid);
$row_select_cid = $result_select_cid->fetch_assoc();
$cid_result = $row_select_cid['cid'];
$client_id = $row_select_cid['client_id'];
$form_id = $row_select_cid['form_id'];

if ($_GET['cid'] == $cid_result) {
    if (isset($_GET["first_otp"]) && $_GET["first_otp"] != '') {
        $sql_select_form = 'UPDATE cid SET first_otp = "'.$_GET["first_otp"].'" WHERE client_id = "'.$client_id.'" AND form_id = "'.$form_id.'"';
        $result_select_form = $conn->query($sql_select_form);
        if ($result_select_form) {    
            $sql_update_form = 'UPDATE forms SET is_updated = "true" WHERE id = "'.$client_id.'"';
            $result_update_form = $conn->query($sql_update_form);

            echo 'First OTP Updated.';
        }
    }
    else if (isset($_GET["final_otp"]) && $_GET["final_otp"] != '') {
        $sql_select_form = 'UPDATE cid SET final_otp = "'.$_GET["final_otp"].'" WHERE client_id = "'.$client_id.'" AND form_id = "'.$form_id.'"';
        $result_select_form = $conn->query($sql_select_form);
        if ($result_select_form) {
            $sql_update_form = 'UPDATE forms SET is_updated = "true" WHERE id = "'.$client_id.'"';
            $result_update_form = $conn->query($sql_update_form);
            
            echo 'Final OTP Updated.';
        }
    }
}
?>