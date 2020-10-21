<?php
    // 0 * * * * /usr/bin/php /home/premlata/crm.techlounge.co.in/cron/cron.php >> /home/premlata/cron.log 2>&1
    // last id of cron table is 5424

    require_once('../config/db.php');
    require_once('../vendor/autoload.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    // require_once('../classes/class.verifyEmail.php');

    date_default_timezone_set('Asia/Kolkata');
    $form_date = date('d-m-Y');
    $form_time = date('H:i:s');

    ini_set('max_execution_time', 3600);

    $sql_select_forms = 'SELECT * FROM forms WHERE is_cron = "" GROUP BY email ORDER BY id ASC';
    $result_select_forms = $conn->query($sql_select_forms);

    if ($result_select_forms->num_rows > 0) {
        // $vmail = new verifyEmail();
        // $vmail->setStreamTimeoutWait(20);
        // $vmail->setEmailFrom('no-reply@techlounge.co.in');

        while($row_select_forms = $result_select_forms->fetch_assoc()) {
            if (($row_select_forms['status'] != 'Paid') && ($row_select_forms['type'] != 'Unknown')) {
                $email = filter_var(strtolower($row_select_forms['email']), FILTER_SANITIZE_EMAIL);
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    // if ($vmail->check($email)) {
                        $sql_insert_email_cron = 
                        "
                            INSERT INTO `email_cron` (
                                form_id, 
                                website, 
                                email, 
                                date, 
                                time
                            ) 
                            VALUES (
                                '". $row_select_forms['id'] ."', 
                                '". $row_select_forms['website'] ."', 
                                '". $email ."', 
                                '". $form_date ."', 
                                '". $form_time ."'
                            )
                        ";
                        $result_insert_email_cron = $conn->query($sql_insert_email_cron);
                    // }
                }
            }

            $sql_update_forms = "UPDATE `forms` SET is_cron = 'true' WHERE email = '". $row_select_forms['email'] ."'";
            $result_update_forms = $conn->query($sql_update_forms);
        }
    }

    $sql_select_email_cron = 'SELECT * FROM email_cron ORDER BY id DESC';
    $result_select_email_cron = $conn->query($sql_select_email_cron);

    if ($result_select_email_cron->num_rows > 0) {
        while($row_select_email_cron = $result_select_email_cron->fetch_assoc()) {
            $sql_select_forms = 'SELECT * FROM forms WHERE id = "'. $row_select_email_cron["form_id"] .'"';
            $result_select_forms = $conn->query($sql_select_forms);
            $row_select_forms = $result_select_forms->fetch_assoc();

            if ($row_select_forms["status"] == 'Paid') {
                $sql_delete_email_cron = 'DELETE FROM email_cron WHERE form_id = "'. $row_select_forms["id"] .'"';
                $result_delete_email_cron = $conn->query($sql_delete_email_cron);
            }

            else {
                echo $row_select_email_cron['email'] . "\n\n";

                // Three hour mail
                if ($row_select_email_cron['is_mail'] == '') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 10800;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];

                        include('../cron/template.php');
                        
                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_one .'';
                            $mail->Body    = ''. $message_one .'';
                            $mail->send();

                            echo "Mail sent successfully for three hour.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '0' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day one mail
                else if ($row_select_email_cron['is_mail'] == '0') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 86400;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];

                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_two .'';
                            $mail->Body    = ''. $message_two .'';
                            $mail->send();

                            echo "Mail sent successfully for day one.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '1' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day two mail
                else if ($row_select_email_cron['is_mail'] == '1') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 172800;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];

                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_three .'';
                            $mail->Body    = ''. $message_three .'';
                            $mail->send();

                            echo "Mail sent successfully for day two.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '2' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day three mail
                else if ($row_select_email_cron['is_mail'] == '2') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 259200;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];

                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_four .'';
                            $mail->Body    = ''. $message_four .'';
                            $mail->send();

                            echo "Mail sent successfully for day three.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '3' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day four mail
                else if ($row_select_email_cron['is_mail'] == '3') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 345600;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];

                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_five .'';
                            $mail->Body    = ''. $message_five .'';
                            $mail->send();

                            echo "Mail sent successfully for day four.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '4' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day five mail
                else if ($row_select_email_cron['is_mail'] == '4') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 432000;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];

                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_six .'';
                            $mail->Body    = ''. $message_six .'';
                            $mail->send();

                            echo "Mail sent successfully for day five.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '5' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day six mail
                else if ($row_select_email_cron['is_mail'] == '5') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 518400;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];
                        
                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_seven .'';
                            $mail->Body    = ''. $message_seven .'';
                            $mail->send();

                            echo "Mail sent successfully for day six.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '6' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day seven mail
                else if ($row_select_email_cron['is_mail'] == '6') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 604800;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];
                        
                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_eight .'';
                            $mail->Body    = ''. $message_eight .'';
                            $mail->send();

                            echo "Mail sent successfully for day seven.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '7' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day eight mail
                else if ($row_select_email_cron['is_mail'] == '7') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 691200;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];
                        
                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_nine .'';
                            $mail->Body    = ''. $message_nine .'';
                            $mail->send();

                            echo "Mail sent successfully for day eight.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '8' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day nine mail
                else if ($row_select_email_cron['is_mail'] == '8') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 777600;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];
                        
                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_ten .'';
                            $mail->Body    = ''. $message_ten .'';
                            $mail->send();

                            echo "Mail sent successfully for day nine.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '9' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }

                // Day ten mail
                else if ($row_select_email_cron['is_mail'] == '9') {
                    $new_form_time = strtotime($row_select_email_cron['date'] . ' ' . $row_select_email_cron['time']) + 864000;
                    $current_form_time = strtotime($form_date . ' ' . $form_time);

                    if ($new_form_time > $current_form_time) {}
                    else {
                        $sql_select_email_id = "SELECT * FROM email_id WHERE host_name = '".strtolower($row_select_email_cron['website'])."'";
                        $result_select_email_id = $conn->query($sql_select_email_id);
                        $row_select_email_id = $result_select_email_id->fetch_assoc();

                        $fromHostName = $row_select_email_id['host_name'];
                        $fromSiteName = $row_select_email_id['site_name'];
                        $fromEmail = $row_select_email_id['email_id'];
                        
                        include('../cron/template.php');

                        $mail = new PHPMailer(true);
                                                
                        try {
                            $mail->isSMTP();
                            $mail->Host       = ''.$fromHostName.'';
                            $mail->SMTPAuth   = true;
                            $mail->Username   = ''.$fromEmail.'';
                            $mail->Password   = ''; // password
                            $mail->SMTPSecure = 'tls';
                            $mail->Port       = 587;
                        
                            $mail->setFrom(''.$fromEmail.'', ''.$fromSiteName.'');
                            $mail->addAddress(''.$row_select_email_cron['email'].'');
                            
                            $mail->isHTML(true);

                            $mail->Subject = ''. $subject_eleven .'';
                            $mail->Body    = ''. $message_eleven .'';
                            $mail->send();

                            echo "Mail sent successfully for day ten.\n\n";
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }

                        $sql_update_email_cron = "UPDATE `email_cron` SET is_mail = '10' WHERE email = '". $row_select_email_cron['email'] ."'";
                        $result_update_email_cron = $conn->query($sql_update_email_cron);
                    }
                }
            }
        }
    }
?>