<?php

include_once("../config/db.php");
include_once('../classes/login-status.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_date = date('d');
$form_month = date('m');
$form_year = date('Y');

$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

$message = urlencode($_POST['message']);

$sql_select_form_id = 'SELECT * FROM complaint_forms WHERE id = "'.$_POST['formId'].'"';
$result_select_form_id = $conn->query($sql_select_form_id);
if ($result_select_form_id->num_rows == 1) {
    $row_select_form_id = $result_select_form_id->fetch_assoc();
    $complaint_id = $row_select_form_id['complaint_id'];
}

$sql_update_complaint_forms = 'UPDATE complaint_forms SET stage = "1", form_created_on = "'.$form_created_on.'", form_date = "'.$form_date.'", form_month = "'.$form_month.'", form_year = "'.$form_year.'" WHERE id = "'.$_POST["formId"].'"';
$result_update_complaint_forms = $conn->query($sql_update_complaint_forms);

$sql =
"
INSERT INTO complaint_timeline (
    meta_id,
    meta_name,
    meta_description,
    meta_user,
    meta_type,
    form_created_on,
    form_created_time
)

VALUES (
    '".$complaint_id."',
    'complaint form',
    '".$message."',
    '".$user_name."',
    'out',
    '".$form_created_on_date."',
    '".$form_created_on_time."'
)
";

if(!$result = $conn->query($sql)){
    die('There was an error running the query [' . $conn->error . ']');
}
else
{
    $sql_select_form_id = 'SELECT * FROM complaint_forms WHERE id = "'.$_POST['formId'].'"';
    $result_select_form_id = $conn->query($sql_select_form_id);
    if ($result_select_form_id->num_rows === 1) {
        $row_select_form_id = $result_select_form_id->fetch_assoc();
        $website = strtolower($row_select_form_id['website']);
        $complaint_id = $row_select_form_id['complaint_id'];

        $from_host = strtolower($row_select_form_id['website']);
        $from_name  = strtoupper($row_select_form_id['website']);
        if ($row_select_form_id['website'] == 'EUDYOGAADHAAR.ORG') {
            $from_email = 'noreply@' . strtolower($row_select_form_id['website']);
        }
        else if ($row_select_form_id['website'] == 'UDYOGADHARCERTIFICATE.IN') {
            $from_email = 'no-reply1@' . strtolower($row_select_form_id['website']);
        }
        else {
            $from_email = 'no-reply@' . strtolower($row_select_form_id['website']);
        }
        $to_email = $row_select_form_id['email_id'];

        $post = [
            'meta_id'           => $complaint_id,
            'meta_name'         => 'complaint form',
            'meta_description'  => $message,
            'meta_user'         => 'Agent',
            'form_created_on'   => $form_created_on_date,
            'form_created_time' => $form_created_on_time
        ];
        
        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $ch = curl_init('http://localhost/'.$website.'/complaint-api.php');
        } else {
            $ch = curl_init('https://'.$website.'/complaint-api.php');
        }
        echo 'http://localhost/'.$website.'/complaint-api.php';
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        $response = curl_exec($ch);
        curl_close($ch);

        $mail = new PHPMailer(true); 

        try {
            $mail->isSMTP();
            $mail->Host       = ''.$from_host.'';
            $mail->SMTPAuth   = true;
            $mail->Username   = ''.$from_email.'';
            $mail->Password   = ''; // password
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;
            $mail->setFrom(''.$from_email.'', ''.$from_name.'');
            $mail->addAddress(''.$to_email.'');
        
            $mail->isHTML(true);
        
            $mail->Subject = 'Grievance Reply From '.$from_name.'';
            $mail->Body    = ''.urldecode($message).'';
            $mail->send();

            echo 'Message updated.';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }
}

?>