<?php
    // 0 0 * * * /usr/bin/php /home/premlata/crm.techlounge.co.in/cron/cron-schedule-call.php >> /home/premlata/cron-schedule-call.log 2>&1

    require_once('../config/db.php');
    require_once('../vendor/autoload.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    date_default_timezone_set('Asia/Kolkata');
    $today = date('d-m-Y H:i:s');

    function generateToken($length = 7) {
        $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
        $token = '';
        while(strlen($token) < $length) {
            $token .= $chars[mt_rand(0, strlen($chars)-1)];
        }
        return $token;
    }

    ini_set('max_execution_time', 3600);

    $sql_select_forms = "SELECT * FROM forms WHERE status = 'Paid' AND stage = 'OTP Not Given' AND delivered_on != '' AND is_updated = '' ORDER BY id DESC";
    $result_select_forms = $conn->query($sql_select_forms);

    if ($result_select_forms->num_rows > 0) {
        while($row_select_forms = $result_select_forms->fetch_assoc()) {
            $id = $row_select_forms['id'];
            $name = strtoupper($row_select_forms['name']);
            $is_cron_issue_count = $row_select_forms['is_cron_issue_count'];
            $date = $row_select_forms['date'];
            $email = filter_var(strtolower($row_select_forms['email']), FILTER_SANITIZE_EMAIL);
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $cid_generated = generateToken(16);
                $website = 'udyamprocessing.co';

                if ($_SERVER['HTTP_HOST'] == 'localhost') {
                    $schedule_link = "http://localhost/".$website."/schedule-call.php?cid=".$cid_generated."";
                } else {
                    $schedule_link = "https://".$website."/schedule-call.php?cid=".$cid_generated."";
                }

                $message = 
                "Dear Sir / Maam,<br><br>
                Greetings of the day !!<br><br>
                As per our records, you had applied for Udyam Registration on ".$date."
                <br><br>
                However the same has not been processed, due to reasons already communicated 
                to you earlier by our representative.
                <br><br>
                We request you to click on the below link & schedule a date & time most suited 
                to you and our representatives should call you around that time to process your 
                application.
                <br><br>
                Note: Keep your aadhaar card & mobile linked with your aadhaar card handy for 
                processing of your application.
                <br><br>
                Schedule date & time by clicking here
                <br>
                ".$schedule_link."
                <br><br>
                Regards,
                <br>
                Team Processing
                ";

                if ($is_cron_issue_count == '') {
                    $submitted_time = strtotime($row_select_forms['delivered_on']) + 259200;
                    $current_time = strtotime($today);            

                    if ($submitted_time < $current_time) {
                        $subject = "Reminder 1 - Follow up on date & time scheduling";
                        $is_cron_issue_count = '1';

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
                            $mail->addAddress(''.$email.'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject .'';
                            $mail->Body    = ''. $message .'';
                            $mail->send();

                            $sql_update_forms = "UPDATE forms SET schedule_cid = '".$cid_generated."', is_cron_issue_count = '".$is_cron_issue_count."' WHERE id = '". $id ."'";
                            $result_update_forms = $conn->query($sql_update_forms);
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                }

                else if ($is_cron_issue_count == '1') {
                    $submitted_time = strtotime($row_select_forms['delivered_on']) + 518400;
                    $current_time = strtotime($today);

                    if ($submitted_time < $current_time) {
                        $subject = "Reminder 2 - Follow up on date & time scheduling";
                        $is_cron_issue_count = '2';

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
                            $mail->addAddress(''.$email.'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject .'';
                            $mail->Body    = ''. $message .'';
                            $mail->send();

                            $sql_update_forms = "UPDATE forms SET schedule_cid = '".$cid_generated."', is_cron_issue_count = '".$is_cron_issue_count."' WHERE id = '". $id ."'";
                            $result_update_forms = $conn->query($sql_update_forms);
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }
                }

                else if ($is_cron_issue_count == '2') {
                    $submitted_time = strtotime($row_select_forms['delivered_on']) + 864000;
                    $current_time = strtotime($today);

                    if ($submitted_time < $current_time) {
                        $subject = "Final Reminder - Follow up on date & time scheduling";
                        $message = 
                        "Dear Sir / Maam,<br><br>
                        Greetings of the day !!<br><br>
                        As per our records, you had applied for Udyam Registration on ".$date."
                        <br><br>
                        However the same has not been processed, due to reasons already communicated 
                        to you earlier by our representative.
                        <br><br>
                        This is the 3rd & final reminder from our end.
                        <br>
                        From now onwards, system generated reminder will stop. However you can still 
                        schedule date & time on the link provided below to you and our representatives 
                        should call you around that time to process your application.
                        <br><br>
                        Note: Keep your aadhaar card & mobile linked with your aadhaar card handy for 
                        processing of your application.
                        <br><br>
                        Schedule date & time by clicking here
                        <br>
                        ".$schedule_link."
                        <br><br>
                        Regards,
                        <br>
                        Team Processing
                        ";
                        $is_cron_issue_count = '3';
                        
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
                            $mail->addAddress(''.$email.'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject .'';
                            $mail->Body    = ''. $message .'';
                            $mail->send();

                            $sql_update_forms = "UPDATE forms SET schedule_cid = '".$cid_generated."', is_cron_issue_count = '".$is_cron_issue_count."' WHERE id = '". $id ."'";
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