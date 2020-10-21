<?php

include_once('../config/db.php');
include_once('../classes/xmlapi.php');

date_default_timezone_set('Asia/Kolkata');
$campaign_date = date('d-m-Y H:i:s');

if (
    (($_POST['campaignName']) != '') && (($_POST['campaignScheduleTime']) != '') && (($_POST['campaignEmailGroup']) != '') && 
    (($_POST['campaignEmailGroupType']) != '') && (($_POST['campaignFromEmail']) != '') && (($_POST['campaignSubject']) != '') && (($_POST['campaignMessage']) != '')
) {
    $campaign_name = ucwords($_POST['campaignName']);
    $campaign_schedule_time = $_POST['campaignScheduleTime'];
    $campaign_email_group = $_POST['campaignEmailGroup'];
    $campaign_email_group_type = $_POST['campaignEmailGroupType'];
    $campaign_from_email = $_POST['campaignFromEmail'];
    $campaign_subject = $_POST['campaignSubject'];
    $campaign_message = urlencode($_POST['campaignMessage']);

    $sql_insert_campaign = 
    '
    INSERT INTO campaign (
        campaign_name, campaign_schedule_time, campaign_email_group, campaign_email_group_type, campaign_from_email, 
        campaign_subject, campaign_message, campaign_date
    ) VALUES (
        "'.$campaign_name.'", "'.$campaign_schedule_time.'", "'.$campaign_email_group.'", "'.$campaign_email_group_type.'", 
        "'.$campaign_from_email.'", "'.$campaign_subject.'", "'.$campaign_message.'", "'.$campaign_date.'"
    )
    ';
    $result_insert_campaign = $conn->query($sql_insert_campaign);
    $campaign_insert_id = $conn->insert_id;

    if ($result_insert_campaign) {
        $sql_select_campaign_unsubscribe_lists = 'SELECT * FROM campaign_unsubscribe_lists';
        $result_select_campaign_unsubscribe_lists = $conn->query($sql_select_campaign_unsubscribe_lists);
        while ($row_select_campaign_unsubscribe_lists = $result_select_campaign_unsubscribe_lists->fetch_assoc()) {
            $unsubscribe_email = $row_select_campaign_unsubscribe_lists['email'];
            // echo $unsubscribe_email;

            $sql_select_forms = 'SELECT * FROM forms WHERE email != "'.$unsubscribe_email.'" AND business = "'.$campaign_email_group.'" AND status = "'.$campaign_email_group_type.'" ORDER BY email ASC';
            $result_select_forms = $conn->query($sql_select_forms);
            if ($result_select_forms->num_rows > 0) {
                while ($row_select_forms = $result_select_forms->fetch_assoc()) {
                    $email = filter_var(strtolower($row_select_forms['email']), FILTER_SANITIZE_EMAIL);
                    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $sql_insert_campaign_email = 
                        "
                            INSERT INTO `campaign_email` (
                                campaign_id, form_id, business, email_id
                            ) 
                            VALUES (
                                '".$campaign_insert_id."', '".$row_select_forms['id']."', '".$campaign_email_group."', '".$email."'
                            )
                        ";
                        $result_insert_campaign_email = $conn->query($sql_insert_campaign_email);

                        if (!$result_insert_campaign_email) {
                            $status = '';
                            exit;
                        } else {
                            $status = 'true';
                        }
                    }
                }
            }
        }

        if ($status == 'true') {
            if ($_SERVER['HTTP_HOST'] == 'localhost') {
                $original_file = file_get_contents('http://localhost/crm2.techlounge.co.in/cron/campaign_cron.txt');
            } else {
                $original_file = file_get_contents('https://crm2.techlounge.co.in/cron/campaign_cron.txt');
            }
            $campaign_file_name = str_replace(' ', '_', $campaign_name);
            $file_name = strtolower($campaign_file_name) . '_' . $campaign_insert_id . '.php';
            $file = fopen('../cron/campaign/'.$file_name, 'w') or die('Unable to open file!');
            $file_text = '<?php $campaign_id = "'.$campaign_insert_id.'"; ?>' . $original_file;
            fwrite($file, $file_text);
            fclose($file);

            $file_log = fopen('../cron/campaign/'.strtolower($campaign_file_name).'_'.$campaign_insert_id.'_cron.log', 'w') or die('Unable to open file!');

            if ($campaign_schedule_time == 'Once Per Day') {
                $minute = '0'; $hour = '0'; $day = '*'; $month = '*'; $weekday = '*';
            } else if ($campaign_schedule_time == 'Twice Per Day') {
                $minute = '0'; $hour = '0,12'; $day = '*'; $month = '*'; $weekday = '*';
            } else if ($campaign_schedule_time == 'Once Per Week') {
                $minute = '0'; $hour = '0'; $day = '*'; $month = '*'; $weekday = '0';
            } else if ($campaign_schedule_time == 'Once Per Month') {
                $minute = '0'; $hour = '0'; $day = '1'; $month = '*'; $weekday = '*';
            }

            $xmlapi_1 = new xmlapi($ip_1);
            $xmlapi_1->set_port('2083');
            $xmlapi_1->password_auth($account_1, $password_1);
            $xmlapi_1->set_output('array');
            $cron_properties = array(
                'command'        => '/usr/bin/php /home/premlata/crm2.techlounge.co.in/cron/campaign/'.$file_name.' >> /home/premlata/crm2.techlounge.co.in/cron/campaign/'.strtolower($campaign_file_name).'_'.$campaign_insert_id.'_cron.log 2>&1',
                'minute'         => $minute,
                'hour'           => $hour,
                'day'            => $day,
                'month'          => $month,
                'weekday'        => $weekday
            );
            $cron_result = $xmlapi_1->api2_query($account_1, 'Cron', 'add_line', $cron_properties);

            echo 'true';
        }
    }
}