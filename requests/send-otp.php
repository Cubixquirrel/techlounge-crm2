<?php

include_once('../config/db.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

$sql_select_website = "SELECT * FROM forms WHERE id = '".$_POST['clientId']."'";
$result_select_website = $conn->query($sql_select_website);
if ($result_select_website->num_rows > 0) {
    $row_select_website = $result_select_website->fetch_assoc();
    $to_email = $row_select_website['email'];
};

$subject = 'Your Udyam Registration Verification Link';
$mail_message = 
"
Dear Sir/Ma'am,<br>
Click on link to verify you Aadhaar<br>
".$_POST['link']."
<br><br>
Regards,<br>
Team Processing
";

$sms_message = 
"
Dear Sir/Maam,
Click on link to verify you Aadhaar
".$_POST['link']."
";

$sql = "SELECT mobile FROM forms WHERE id = ".$_POST['clientId']."";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$mobile = intval($row['mobile']);

$url = 'http://198.24.149.4/API/pushsms.aspx?loginID='.$sms_user.'&password='.$sms_password.'&mobile='.$mobile.'&text='.urlencode($sms_message).'&senderid=TXCARE&route_id=2&Unicode=0';

$ch = curl_init();
  
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_exec($ch);

$mail = new PHPMailer(true); 
  
try {
    $mail->isSMTP();
    $mail->Host       = 'udyamprocessing.co';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'no-reply@udyamprocessing.co';
    $mail->Password   = ''; // password
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;
    $mail->setFrom('no-reply@udyamprocessing.co', 'Udyam Processing');
    $mail->addAddress(''.$to_email.'');

    $mail->isHTML(true);

    $mail->Subject = ''.$subject.'';
    $mail->Body    = ''.$mail_message.'';
    $mail->send();
    echo "Message sent.";
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}