<?php
    // 0 0 * * * /usr/bin/php /home/premlata/crm.techlounge.co.in/cron/cron-aadhaar-issue.php >> /home/premlata/cron-aadhaar-issue.log 2>&1

    require_once('../config/db.php');
    require_once('../vendor/autoload.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    date_default_timezone_set('Asia/Kolkata');
    $today = date('d-m-Y H:i:s');

    ini_set('max_execution_time', 3600);

    $sql_select_forms = "SELECT * FROM forms WHERE status = 'Paid' AND stage = 'Aadhaar Issue' AND delivered_on != '' AND is_updated = '' ORDER BY id DESC";
    $result_select_forms = $conn->query($sql_select_forms);

    if ($result_select_forms->num_rows > 0) {
        while($row_select_forms = $result_select_forms->fetch_assoc()) {
            $id = strtoupper($row_select_forms['id']);
            $name = strtoupper($row_select_forms['name']);
            $is_cron_issue_count = $row_select_forms['is_cron_issue_count'];
            $email = filter_var(strtolower($row_select_forms['email']), FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $from_host  = strtolower($row_select_forms['website']);
                $from_name  = $row_select_forms['website'];
                if ($row_select_forms['website'] == 'EUDYOGAADHAAR.ORG') {
                    $from_email = 'noreply@' . strtolower($row_select_forms['website']);
                } else if ($row_select_forms['website'] == 'UDYOGADHARCERTIFICATE.IN') {
                    $from_email = 'no-reply1@' . strtolower($row_select_forms['website']);
                } else {
                    $from_email = 'no-reply@' . strtolower($row_select_forms['website']);
                }
                $to_email = $row_select_forms['email'];

                $sql_select_cid = "SELECT * FROM edit_form_link WHERE panel_form_id = '".$id."' ORDER BY id DESC LIMIT 1";
                $result_select_cid = $conn->query($sql_select_cid);
                $row_select_cid = $result_select_cid->fetch_assoc();
                $cid = $row_select_cid['full_link'];

                $message = 
                "Dear Sir / Maam,<br><br>
                Greetings of the day !!<br><br>
                This is a follow up on your Udyam Registration Application.
                <br><br>
                In the earlier email, it was notified to you that your application for registration 
                is put on hold because:
                <br>
                a) Your mobile number was not linked to your aadhaar, or<br>
                b) Your name in the application could not be validated against the name in 
                aadhaar database.
                <br><br>
                If you have got your aadhaar updated / mobile number linked with aadhaar, 
                please upload your latest aadhaar on the link provided below.
                <br><br>
                ".$cid."
                <br><br>
                Your application shall be processed on priority after submission of the aadhaar.
                <br>
                <br>
                Regards,
                <br>
                Team Processing
                ";

                if ($is_cron_issue_count == '') {
                    $submitted_time = strtotime($row_select_forms['delivered_on']) + 864000;
                    $current_time = strtotime($today);            

                    if ($submitted_time < $current_time) {
                        $subject = "Reminder 1 - Follow up on Aadhaar Issue";
                        $is_cron_issue_count = '1';

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

                            $mail->Subject = ''. $subject .'';
                            $mail->Body    = ''. $message .'';
                            $mail->send();

                            $sql_update_forms = "UPDATE forms SET is_cron_issue_count = '".$is_cron_issue_count."' WHERE id = '". $id ."'";
                            $result_update_forms = $conn->query($sql_update_forms);
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                }

                else if ($is_cron_issue_count == '1') {
                    $submitted_time = strtotime($row_select_forms['delivered_on']) + 1728000;
                    $current_time = strtotime($today);

                    if ($submitted_time < $current_time) {
                        $subject = "Reminder 2 - Follow up on Aadhaar Issue";
                        $is_cron_issue_count = '2';

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

                            $mail->Subject = ''. $subject .'';
                            $mail->Body    = ''. $message .'';
                            $mail->send();

                            $sql_update_forms = "UPDATE forms SET is_cron_issue_count = '".$is_cron_issue_count."' WHERE id = '". $id ."'";
                            $result_update_forms = $conn->query($sql_update_forms);
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                }

                else if ($is_cron_issue_count == '2') {
                    $submitted_time = strtotime($row_select_forms['delivered_on']) + 2160000;
                    $current_time = strtotime($today);

                    if ($submitted_time < $current_time) {
                        $subject = "Final Reminder - Follow up on Aadhaar Issue";
                        $message = 
                        "Dear Sir / Maam,<br><br>
                        Greetings of the day !!<br><br>                        
                        This is the 3rd & final reminder from our end.
                        <br>
                        From now onwards, system generated reminder will stop. However you can still 
                        upload your aadhaar on the link provided to process your application.
                        <br><br>
                        In the earlier email, it was notified to you that your application for registration 
                        is put on hold because:
                        <br>
                        a) Your mobile number was not linked to your aadhaar, or<br>
                        b) Your name in the application could not be validated against the name in 
                        aadhaar database.
                        <br><br>
                        If you have got your aadhaar updated / mobile number linked with aadhaar, 
                        please upload your latest aadhaar on the link provided below.
                        <br><br>
                        ".$cid."
                        <br><br>
                        Your application shall be processed on priority after submission of the aadhaar.
                        <br>
                        <br>
                        Regards,
                        <br>
                        Team Processing
                        ";
                        $is_cron_issue_count = '3';
                        
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

                            $mail->Subject = ''. $subject .'';
                            $mail->Body    = ''. $message .'';
                            $mail->send();

                            $sql_update_forms = "UPDATE forms SET is_cron_issue_count = '".$is_cron_issue_count."' WHERE id = '". $id ."'";
                            $result_update_forms = $conn->query($sql_update_forms);
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                }

                echo $name . " - " . $is_cron_issue_count . "\n";
            }
        }
    }
?>