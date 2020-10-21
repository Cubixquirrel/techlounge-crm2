<?php
    $sql_select_timeline = "SELECT * FROM timeline WHERE meta_id = ".$_GET['clientId']." ORDER BY id DESC";
    $result_select_timeline = $conn->query($sql_select_timeline);

    $timeline = '<div class="timeline">';

    $count = 0;
    if ($result_select_timeline->num_rows > 0) {
        while($row_select_timeline = $result_select_timeline->fetch_assoc()) {
            $timeline .= '<div class="time-label">';
                $timeline .= ''.$row_select_timeline['form_created_on'].' - '.$row_select_timeline['form_created_time'].'';
            $timeline .= '</span>';
            $timeline .= '</div>';
            
            if (($row_select_timeline['meta_name'] == 'form') && ($row_select_timeline['meta_description'] == 'New form submitted')) {                                        
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_description'].'</span>';
                $timeline .= '<div class="timeline-body">';
                    $timeline .= ''.$return_form[$count++].'';
                $timeline .= '</div>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if (($row_select_timeline['meta_name'] == 'form') && ($row_select_timeline['meta_description'] != 'New form submitted')) {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_description'].'</span>';
                $timeline .= '<div class="timeline-body">';

                    $sql_select_forms = "SELECT * FROM forms WHERE id = ".$_GET['clientId']."";
                    $result_select_forms = $conn->query($sql_select_forms);
                    $row_select_forms = $result_select_forms->fetch_assoc();

                    $timeline .= 'Merchant: '.$row_select_forms['pay_vendor'].' <br>';
                    $timeline .= 'Payment Id: '.$row_select_forms['payment_id'].' <br>';
                    $timeline .= 'Order Id: '.$row_select_forms['order_id'].'<br>';
                    $timeline .= 'Amount Paid: '.$row_select_forms['amount'].'';

                $timeline .= '</div>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'assign') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' assigned this client to '.$row_select_timeline['meta_description'].'.</span>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'campaign-mail') {
                $timeline .= '<div>';
                    $timeline .= '<div class="timeline-item">';
                        $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' has been sent to this client.</span>';
                        $timeline .= '<div class="timeline-body">';
                        $timeline .= 'Campaign Subject: '.$row_select_timeline['meta_description'].'';
                        $timeline .= '</div>';
                    $timeline .= '</div>';
                $timeline .= '</div>';
                }

            if ($row_select_timeline['meta_name'] == 'stage-mail') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $meta_description = explode("__%__", $row_select_timeline['meta_description']);
                    $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' mailed '.$meta_description[0].' to client.</span>';
                    $timeline .= '<div class="timeline-body">';
                    $timeline .= '<span>Remarks: '.$meta_description[1].'</span>';
                    $meta_description_2 = explode("_%_", $meta_description[2]);
                    foreach ($meta_description_2 as $key => $value) {
                        if ($value != '') {
                        $timeline .= '<span>Attachments: <a href="'.$value.'" download>'.$value.'</a></span>';
                        }
                    }
                    $timeline .= '</div>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'stage-mark') {
                $timeline .= '<div>';
                    $timeline .= '<div class="timeline-item">';
                    $meta_description = explode("__%__",$row_select_timeline['meta_description']);
                        $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' marked this client as '.$meta_description[0].'.</span>';
                        $timeline .= '<div class="timeline-body">';
                        $timeline .= 'Remarks: '.$meta_description[1].'';
                        $timeline .= '</div>';
                    $timeline .= '</div>';
                $timeline .= '</div>';
                }

            if ($row_select_timeline['meta_name'] == 'comment') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' added follow up comment.</span>';
                $timeline .= '<div class="timeline-body">';
                    $timeline .= ''.$row_select_timeline['meta_description'].'';
                $timeline .= '</div>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }
            
            if ($row_select_timeline['meta_name'] == 'sms') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' has sent an sms</span>';
                $timeline .= '<div class="timeline-body">';
                    $sql_select = "SELECT * FROM ".$row_select_timeline['meta_name']." WHERE id = ".$row_select_timeline['meta_description']."";
                    $result_select = $conn->query($sql_select);
                    $row_select = $result_select->fetch_assoc();
                    $timeline .= ''.$row_select['message'].'';
                $timeline .= '</div>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'email') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' has sent an email</span>';
                $timeline .= '<div class="timeline-body">';
                    $sql_select = "SELECT * FROM ".$row_select_timeline['meta_name']." WHERE id = ".$row_select_timeline['meta_description']."";
                    $result_select = $conn->query($sql_select);
                    $row_select = $result_select->fetch_assoc();
                    $timeline .= ''.$row_select['message'].'';
                $timeline .= '</div>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'whatsapp') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' has sent an whatsapp</span>';
                $timeline .= '<div class="timeline-body">';
                    $sql_select = "SELECT * FROM ".$row_select_timeline['meta_name']." WHERE id = ".$row_select_timeline['meta_description']."";
                    $result_select = $conn->query($sql_select);
                    $row_select = $result_select->fetch_assoc();
                    $timeline .= ''.$row_select['message'].'';
                $timeline .= '</div>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'dropped') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' dropped this client</span>';
                $timeline .= '<div class="timeline-body">';
                    $timeline .= ''.$row_select_timeline['meta_description'].'';
                $timeline .= '</div>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'restored') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' restored this client</span>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'mark_as_paid') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' marked this client as sales</span>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }

            if ($row_select_timeline['meta_name'] == 'mark_as_unpaid') {
            $timeline .= '<div>';
                $timeline .= '<div class="timeline-item">';
                $timeline .= '<span class="timeline-header">'.$row_select_timeline['meta_user'].' removed this client as sales</span>';
                $timeline .= '</div>';
            $timeline .= '</div>';
            }
            
        }
    }

    else {
    $timeline .= 
    '
    <span class="empty-box">
        No complaint timeline found.
    </span>
    ';
    };

    $timeline .= '</div>';
    print $timeline;
?>