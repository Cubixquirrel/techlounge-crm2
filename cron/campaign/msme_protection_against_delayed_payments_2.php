<?php $campaign_id = "2"; ?>
<?php

    require_once('../../config/db.php');
    require_once('../../vendor/autoload.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    date_default_timezone_set('Asia/Kolkata');
    $form_created_on = date('d-m-Y H:i:s');
    
    $form_created_on_date = date('d-m-Y');
    $form_created_on_time = date('H:i:s');

    ini_set('max_execution_time', 3600);

    $sql_select_campaign = 'SELECT * FROM campaign WHERE id = "'.$campaign_id.'"';
    $result_select_campaign = $conn->query($sql_select_campaign);
    $row_select_campaign = $result_select_campaign->fetch_assoc();
    $from_email_id = $row_select_campaign['campaign_from_email'];
    $subject = $row_select_campaign['campaign_subject'];
    $message = urldecode($row_select_campaign['campaign_message']);

    $sql_select_campaign_email_lists = 'SELECT * FROM campaign_email_lists WHERE email_id = "'.$from_email_id.'"';
    $result_select_campaign_email_lists = $conn->query($sql_select_campaign_email_lists);
    $row_select_campaign_email_lists = $result_select_campaign_email_lists->fetch_assoc();
    $host_name = $row_select_campaign_email_lists['domain'];
    $from_email_id = $row_select_campaign_email_lists['email_id'];
    $from_email_id_password = $row_select_campaign_email_lists['password'];
    $from_site_name = strtoupper($host_name);

    $sql_select_campaign_email = 'SELECT * FROM campaign_email WHERE campaign_id = "'.$campaign_id.'" ORDER BY email_id ASC';
    $result_select_campaign_email = $conn->query($sql_select_campaign_email);
    if ($result_select_campaign_email->num_rows > 0) {
        while($row_select_campaign_email = $result_select_campaign_email->fetch_assoc()) {
            $form_id = $row_select_campaign_email['form_id'];
            $to_email_id = $row_select_campaign_email['email_id'];

            $mail = new PHPMailer(true);
                                                
            try {
                $mail->isSMTP();
                $mail->Host       = ''.$host_name.'';
                $mail->SMTPAuth   = true;
                $mail->Username   = ''.$from_email_id.'';
                $mail->Password   = ''.$from_email_id_password.'';
                $mail->SMTPSecure = 'tls';
                $mail->Port       = 587;
            
                $mail->setFrom(''.$from_email_id.'', ''.$from_site_name.'');
                $mail->addAddress(''.$to_email_id.'');
                
                $mail->isHTML(true);

                $mail->Subject = ''.$subject.'';
                $mail->Body    = ''.$message.'';
                $mail->send();

                $sql_insert_timeline = 
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
                '".$form_id."',
                'campaign-mail',
                '".$subject."',
                'Campaign mail',
                '".$form_created_on_date."',
                '".$form_created_on_time."'
                )
                ";
                $result_insert_timeline = $conn->query($sql_insert_timeline);

                echo "Mail sent successfully to ".$to_email_id."\n\n";
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        }
    }

?>