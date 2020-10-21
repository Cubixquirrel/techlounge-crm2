<?php

include_once('../config/db.php');
include_once('../classes/login-status.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require '../vendor/autoload.php';

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');

$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

$sql_select_forms = "SELECT * FROM forms WHERE id = '".$_POST['clientId']."'";
$result_select_forms = $conn->query($sql_select_forms);
if ($result_select_forms->num_rows > 0) {
    $row_select_forms = $result_select_forms->fetch_assoc();
    $from_host  = strtolower($row_select_forms['website']);
    $from_name  = $row_select_forms['website'];
    if ($row_select_forms['website'] == 'EUDYOGAADHAAR.ORG') {
        $from_email = 'noreply@' . strtolower($row_select_forms['website']);
    }
    else if ($row_select_forms['website'] == 'UDYOGADHARCERTIFICATE.IN') {
        $from_email = 'no-reply1@' . strtolower($row_select_forms['website']);
    }
    else {
        $from_email = 'no-reply@' . strtolower($row_select_forms['website']);
    }
    $to_email = $row_select_forms['email'];
};

$type = $_POST['type'];
$subject = $_POST['subject'];
$message = $_POST['message'];
$business_name = $_POST['businessName'];

print_r($_POST);
print_r($_FILES['attachment']['name']);

$mail = new PHPMailer(true); 

$files_array = '';
if(is_array($_FILES)) {
    foreach ($_FILES['attachment']['name'] as $name => $value){
        if(is_uploaded_file($_FILES['attachment']['tmp_name'][$name])) {
        $sourcePath = $_FILES['attachment']['tmp_name'][$name];
        $files_array .= "../uploads-mail/" . $_FILES['attachment']['name'][$name] . "_%_";
        $targetPath = "../uploads-mail/" . $_FILES['attachment']['name'][$name];
            if(move_uploaded_file($sourcePath, $targetPath)) {
                $mail->addAttachment($targetPath);
            }
        }
    }
}
  
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
    $mail->addBcc('udyogaadhaaronline.org@gmail.com');

    $mail->isHTML(true);

    $mail->Subject = ''.$subject.'';
    $mail->Body    = ''.$message.'';
    $mail->send();
    echo "Message sent." . "\n";

    $sql_select_email_processor = 'SELECT * FROM email_processor WHERE template_name = "'.$type.'" AND business_name = "'.$business_name.'"';
    $result_select_email_processor = $conn->query($sql_select_email_processor);
    $row_select_email_processor = $result_select_email_processor->fetch_assoc();
    $template_name = $row_select_email_processor['template_name'];
    $business = $row_select_email_processor['business_name'];
    $stage = $row_select_email_processor['business_stage'];

    if (($_POST['dlApplicationNumber'] != '') && ($_POST['dateSlot'] == '')) {
        $sql_update_forms = "UPDATE forms SET dl_application_number = '".$_POST['dlApplicationNumber']."', date_slot = '', processor = '".$user_name."', stage = '".$stage."', delivered_on = '".$form_created_on."', is_assigned = '', is_follow_up = '', is_comment = '', is_updated = '' WHERE id = '".$_POST['clientId']."'";
    } else if (($_POST['dlApplicationNumber'] != '') && ($_POST['dateSlot'] != '')) {
        $sql_update_forms = "UPDATE forms SET dl_application_number = '".$_POST['dlApplicationNumber']."', date_slot = '".$_POST['dateSlot']."', processor = '".$user_name."', stage = '".$stage."', delivered_on = '".$form_created_on."', is_assigned = '', is_follow_up = '', is_comment = '', is_updated = '' WHERE id = '".$_POST['clientId']."'";
    } else {
        $sql_update_forms = "UPDATE forms SET processor = '".$user_name."', stage = '".$stage."', delivered_on = '".$form_created_on."', is_assigned = '', is_follow_up = '', is_comment = '', is_updated = '' WHERE id = '".$_POST['clientId']."'";
    }
    $result_update_forms = $conn->query($sql_update_forms);

    if ($template_name != 'Print Udyam Registration Certificate') {
        $sql_select_remarks = 'SELECT * FROM forms WHERE id = "'.$_POST["clientId"].'"';
        $result_select_remarks = $conn->query($sql_select_remarks);
        $row_select_remarks = $result_select_remarks->fetch_assoc();
        $email = $row_select_remarks['email'];

        if ($row_select_remarks['remarks'] == '') {
            $sql_update_remarks = 'UPDATE forms SET remarks = "'.$_POST["remarks"].'" WHERE id = "'.$_POST["clientId"].'"';
        } else {
            $sql_update_remarks = 'UPDATE forms SET remarks = "'.$row_select_remarks["remarks"].'__%__'.$_POST["remarks"].'" WHERE id = "'.$_POST["clientId"].'"';
        }
        $result_update_remarks = $conn->query($sql_update_remarks);

        if (isset($_POST['printGid']) && $_POST['printGid'] != '') {
            $print_gid = $_POST['printGid'];
            $uam = $_POST['uam'];
    
            $sql_select_print_gid = 'SELECT * FROM print_gid WHERE print_gid = "'.$print_gid.'"';
            $result_select_print_gid = $conn->query($sql_select_print_gid);
            if ($result_select_print_gid->num_rows == 0) {
                $sql_insert_print_gid = 
                '
                INSERT INTO print_gid (
                    print_gid, uam, client_id
                ) VALUES (
                    "'.$print_gid.'", "'.$uam.'", "'.$_POST["clientId"].'"
                )
                ';
                $result_insert_print_gid = $conn->query($sql_insert_print_gid);
            
                if ($result_insert_print_gid) {
                    echo 'Print GID Inserted.';
                }
            } else {
                echo 'Print GID Already Exists.';
            }

            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                $url = 'http://localhost/print.udyamprocessing.co/api/save-print-gid.php?printGid='.$print_gid.'&uam='.$_POST["uam"].'&email='.$email;
            } else {
                $url = 'https://print.udyamprocessing.co/api/save-print-gid.php?printGid='.$print_gid.'&uam='.$_POST["uam"].'&email='.$email;
            }
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);
    
            echo $response;
        }

        $sql =
        "
        INSERT INTO timeline (
        meta_id,
        meta_name,
        meta_description,
        meta_user,
        form_created_on,
        form_created_time
        )

        VALUES (
        '".$_POST['clientId']."',
        'stage-mail',
        '".$type."__%__".$_POST['remarks']."__%__".$files_array."',
        '".$user_name."',
        '$form_created_on_date',
        '$form_created_on_time'
        )";

        if(!$result = $conn->query($sql)){
            die('There was an error running the query [' . $conn->error . ']');
        }
        else
        {
            echo 'Successfully Marked';
        }
    } else {
        $sql_select_remarks = 'SELECT * FROM forms WHERE id = "'.$_POST["clientId"].'"';
        $result_select_remarks = $conn->query($sql_select_remarks);
        $row_select_remarks = $result_select_remarks->fetch_assoc();
        $email = $row_select_remarks['email'];

        if ($row_select_remarks['remarks'] == '') {
            $sql_update_remarks = 'UPDATE forms SET remarks = "'.$_POST["remarks"].'" WHERE id = "'.$_POST["clientId"].'"';
        } else {
            $sql_update_remarks = 'UPDATE forms SET remarks = "'.$row_select_remarks["remarks"].'__%__'.$_POST["remarks"].'" WHERE id = "'.$_POST["clientId"].'"';
        }
        $result_update_remarks = $conn->query($sql_update_remarks);

        $print_gid = $_POST['printGid'];
        $uam = $_POST['uam'];

        $sql_select_print_gid = 'SELECT * FROM print_gid WHERE print_gid = "'.$print_gid.'"';
        $result_select_print_gid = $conn->query($sql_select_print_gid);
        if ($result_select_print_gid->num_rows == 0) {
            $sql_insert_print_gid = 
            '
            INSERT INTO print_gid (
                print_gid, uam, client_id
            ) VALUES (
                "'.$print_gid.'", "'.$uam.'", "'.$_POST["clientId"].'"
            )
            ';
            $result_insert_print_gid = $conn->query($sql_insert_print_gid);
        
            if ($result_insert_print_gid) {
                echo 'Print GID Inserted.';
            }
        } else {
            echo 'Print GID Already Exists.';
        }

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $url = 'http://localhost/print.udyamprocessing.co/api/save-print-gid.php?printGid='.$print_gid.'&uam='.$_POST["uam"].'&email='.$email;
        } else {
            $url = 'https://print.udyamprocessing.co/api/save-print-gid.php?printGid='.$print_gid.'&uam='.$_POST["uam"].'&email='.$email;
        }
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        curl_close($ch);

        echo $response;

        echo 'Successfully Print Marked';
    }
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}