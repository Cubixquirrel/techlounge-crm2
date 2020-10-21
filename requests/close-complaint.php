<?php

include_once("../config/db.php");

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_date = date('d');
$form_month = date('m');
$form_year = date('Y');

$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

$sql_update_complaint = 'UPDATE complaint_forms SET status = "true" WHERE id = "'.$_POST['formId'].'"';

if(!$result_update_complaint = $conn->query($sql_update_complaint)){
    die('There was an error running the query [' . $conn->error . ']');
}
else
{
    $sql_select_form_id = 'SELECT * FROM complaint_forms WHERE id = "'.$_POST['formId'].'"';
    $result_select_form_id = $conn->query($sql_select_form_id);
    if ($result_select_form_id->num_rows == 1) {
        $row_select_form_id = $result_select_form_id->fetch_assoc();
        $website = strtolower($row_select_form_id['website']);
        $complaint_id = $row_select_form_id['complaint_id'];

        $sql_update_complaint_forms = 'UPDATE complaint_forms SET stage = "3", form_created_on = "'.$form_created_on.'", form_date = "'.$form_date.'", form_month = "'.$form_month.'", form_year = "'.$form_year.'" WHERE id = "'.$_POST["formId"].'"';
        $result_update_complaint_forms = $conn->query($sql_update_complaint_forms);

        $post = [
            'complaint_id' => $complaint_id
        ];
        
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $ch = curl_init('http://localhost/'.$website.'/complaint-closed-api.php');
        } else {
            $ch = curl_init('https://'.$website.'/complaint-closed-api.php');
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        curl_close($ch);
        echo $response;
    }
}

?>