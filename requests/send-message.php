<?php
include_once('../config/db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');

if (($_POST['type'] == 'sms') && ($_POST['clientId'] != '') && ($_POST['messageId'] != '')) {
    $sql = "SELECT mobile FROM forms WHERE id = ".$_POST['clientId']."";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $mobile = intval($row['mobile']);

    $sql = "SELECT message FROM ".$_POST['type']." WHERE id = ".$_POST['messageId']."";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
	$message = urlencode($row['message']);

	$url = 'http://198.24.149.4/API/pushsms.aspx?loginID='.$sms_user.'&password='.$sms_password.'&mobile='.$mobile.'&text='.$message.'&senderid=TXCARE&route_id=2&Unicode=0';
	$ch = curl_init();	  
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_exec($ch);

    $sql_update_forms = "UPDATE forms SET is_follow_up = 'true', is_comment = '', date = '".$form_created_on."' WHERE id = '".$_POST['clientId']."'";
    $result_update_forms = $conn->query($sql_update_forms);

    echo 'Sent';
}

else if (($_POST['type'] == 'email') && ($_POST['clientId'] !== '') && ($_POST['emailId'] != '') && ($_POST['messageId'] != '')) {
    $sql_select_forms = 'SELECT * FROM forms WHERE id = "'.$_POST["clientId"].'"';
    $result_select_forms = $conn->query($sql_select_forms);
    $row_select_forms = $result_select_forms->fetch_assoc();
    $business = $row_select_forms['business'];
    $website = $row_select_forms['website'];

    $from_host_name = strtolower($website);
    $from_email_id = 'order@'.strtolower($website);
    $to_email_id = $row_select_forms['email'];

    $sql = "SELECT * FROM ".$_POST['type']." WHERE id = ".$_POST['messageId']."";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $template = $row['template'];
    $message = $row['message'];

    $mail = new PHPMailer(true);   
    try {
        $mail->isSMTP();
        $mail->Host       = ''.$from_host_name.'';
        $mail->SMTPAuth   = true;
        $mail->Username   = ''.$from_email_id.'';
        $mail->Password   = ''; // password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
    
        $mail->setFrom(''.$from_email_id.'', ''.$website.'');
        $mail->addAddress(''.$to_email_id.'');
        
        $mail->isHTML(true);

        $mail->Subject = ''.$template.'';
        $mail->Body    = ''.$message.'';
        $mail->send();

        $sql_update_forms = "UPDATE forms SET is_follow_up = 'true', is_comment = '', date = '".$form_created_on."' WHERE id = '".$_POST['clientId']."'";
        $result_update_forms = $conn->query($sql_update_forms);

        echo 'Sent';
    } catch (Exception $e) {
        echo 'Message could not be sent. Mailer Error: {$mail->ErrorInfo}';
    }
}

else if (($_POST['type'] == 'whatsapp') && ($_POST['clientId'] != '') && ($_POST['messageId'] != '')) {
    $sql = "SELECT mobile FROM forms WHERE id = ".$_POST['clientId']."";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $mobile = intval($row['mobile']);

    $sql = "SELECT message FROM ".$_POST['type']." WHERE id = ".$_POST['messageId']."";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $message = urlencode($row['message']);

    $sql_update_forms = "UPDATE forms SET is_follow_up = 'true', is_comment = '', date = '".$form_created_on."' WHERE id = '".$_POST['clientId']."'";
    $result_update_forms = $conn->query($sql_update_forms);

    header("Location: whatsapp://send?phone=91".$mobile."&text=".$message."");
}

?>