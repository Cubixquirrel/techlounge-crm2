<?php
    $sql_select_forms = 'SELECT * FROM forms WHERE id = "'.$_GET["clientId"].'"';
    $result_select_forms = $conn->query($sql_select_forms);
    $row_select_forms = $result_select_forms->fetch_assoc();
    $mobile = $row_select_forms['mobile'];
?>
<div class="form-main-container">
    <div class="action-bar">
        <?php
        $sql_select_cid = "SELECT * FROM edit_form_link WHERE form_id = '".$_GET['formId']."' AND panel_form_id = '".$_GET['clientId']."'";
        $result_select_cid = $conn->query($sql_select_cid);
        $row_select_cid = $result_select_cid->fetch_assoc();
        $cid = $row_select_cid['full_link'];

        $sql_client_id = "SELECT * FROM cid WHERE client_id = '".$_GET['clientId']."' AND form_id = '".$_GET['formId']."'";
        $result_client_id = $conn->query($sql_client_id);
        $row_client_id = $result_client_id->fetch_assoc();

        $client_id = $row_client_id['id'];
        $cid_result = $row_client_id['cid'];
        $website = 'udyamprocessing.co';

        if ($_SERVER['HTTP_HOST'] == 'localhost') {
            $first_otp_link = "http://localhost/".$website."/otp-first-verification.php?cid=".$cid_result."";
            $final_otp_link = "http://localhost/".$website."/otp-final-verification.php?cid=".$cid_result."";
        } else {
            $first_otp_link = "https://".$website."/otp-first-verification.php?cid=".$cid_result."";
            $final_otp_link = "https://".$website."/otp-final-verification.php?cid=".$cid_result."";
        }
        ?>

        <?php
        if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Processor', explode(',', $row_select_user['user_role'])))) {
            if ($row_select_forms['business'] == 'MSME') {
                ?>
                <div class="msme-action">
                    <span onclick="sendFirstOTP('<?php echo $_GET['clientId']; ?>', '<?php echo $_GET['formId']; ?>', '<?php echo $first_otp_link; ?>')" class="first-otp-button msme-action-button">Send First OTP Email / SMS</span>
                    <a href="whatsapp://send?phone=91<?php echo intval($row_select_forms['mobile']); ?>&text=Please click on link to submit OTP <?php echo $first_otp_link; ?>" target="_blank" class="first-otp-whatsapp-button msme-action-button">Send WhatsApp</a>
                    <span onclick="copyFirstOTP('<?php echo $first_otp_link; ?>')" class="first-otp-link msme-action-button">Copy OTP Link</span>
                    <span class="copied-first-box"></span>

                    <span onclick="sendFinalOTP('<?php echo $_GET['clientId']; ?>', '<?php echo $_GET['formId']; ?>', '<?php echo $first_otp_link; ?>')" class="final-otp-button msme-action-button">Send Final OTP Email / SMS</span>
                    <a href="whatsapp://send?phone=91<?php echo intval($row_select_forms['mobile']); ?>&text=Please click on link to submit OTP <?php echo $final_otp_link; ?>" target="_blank" class="final-otp-whatsapp-button msme-action-button">Send WhatsApp</a>
                    <span onclick="copyFinalOTP('<?php echo $final_otp_link; ?>')" class="final-otp-link msme-action-button">Copy OTP Link</span>
                    <span class="copied-final-box"></span>

                    <span onclick="setClipboard('<?php echo $cid; ?>')" class="msme-action-button">Copy Edit Link</span>
                    <span class="copied-box"></span>
                </div>
                <?php
            }
        }
        ?>
    </div>

    <?php
    if ($_SERVER['HTTP_HOST'] == 'localhost') {
        $referer_link_paid      = 'http://localhost/crm2.techlounge.co.in/views/paid.php';
        $referer_link_pending   = 'http://localhost/crm2.techlounge.co.in/views/pending.php';
    } else {
        $referer_link_paid      = 'https://crm2.techlounge.co.in/views/paid.php';
        $referer_link_pending   = 'https://crm2.techlounge.co.in/views/pending.php';
    }
    if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Processor', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="form-action">
            <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Processor', explode(',', $row_select_user['user_role'])))) { ?>
                <div class="view-complaint-box">
                    <span class="view-complaint-button msme-action-button" onclick="viewComplaint()">View Complaint</span>

                    <div class="view-complaint-inner-box" style="display: none;">
                        <?php
                            $sql_select_complaint_forms = 'SELECT * FROM complaint_forms WHERE mobile_number = "'.$mobile.'" ORDER BY id DESC';
                            $result_select_complaint_forms = $conn->query($sql_select_complaint_forms);
                            if ($result_select_complaint_forms->num_rows > 0) {
                                while($row_select_complaint_forms = $result_select_complaint_forms->fetch_assoc()) {
                                    $id = $row_select_complaint_forms['id'];
                                    $complaint_id = $row_select_complaint_forms['complaint_id'];
                                    ?><span><a href="../views/timeline-complaint.php?formId=<?php echo $id; ?>"><?php echo $complaint_id; ?></a></span><?php
                                }
                            } else {
                                ?><span>No complaint available</span><?php
                            }
                        ?>
                    </div>
                </div>
            <?php } ?>

            <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Processor', explode(',', $row_select_user['user_role'])))) { ?>
            <form action='../views/call.php' method='POST'>
                <input type='hidden' value='<?php echo $_GET["clientId"]; ?>' name='id'/>
                <button type='submit' class='call-button msme-action-button' name='call_button' value='call_button'>Call</button>
            </form>
            <?php } ?>
            
            <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Processor', explode(',', $row_select_user['user_role'])))) { ?>
                <?php if ((strtok($_SERVER['HTTP_REFERER'], '?') == $referer_link_paid) OR (strtok($_SERVER['HTTP_REFERER'], '?') == $referer_link_pending)) { ?>
                    <a href="../views/send-email.php?clientId=<?php echo $_GET["clientId"]; ?>&formId=<?php echo $_GET["formId"]; ?>" class="msme-action-button">Send Email</a>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>
    
    <div class="form-bar">
    <?php
        while($row_select_form = $result_select_form->fetch_assoc()) {
            if ($row_client_id['first_otp'] != '' OR $row_client_id['final_otp'] != '') {
            ?>
            <div class="form-otp">
                <div class="form-otp-left">
                    <span class="otp-display-box">
                        First OTP : 
                        <?php 
                        if ($row_client_id['first_otp'] == '') {
                            echo '******'; 
                        } else {
                            echo $row_client_id['first_otp'];
                            ?><span onclick="copyOTP('<?php echo $row_client_id['first_otp']; ?>')" class="copy-otp-button">Copy OTP</span><?php
                        }
                        ?>
                    </span>
                </div> 
                <div class="form-otp-right">
                    <span class="otp-display-box">
                        Final OTP : 
                        <?php 
                        if ($row_client_id['final_otp'] == '') {
                            echo '******'; 
                        } else {
                            echo $row_client_id['final_otp'];
                            ?><span onclick="copyOTP('<?php echo $row_client_id['final_otp']; ?>')" class="copy-otp-button">Copy OTP</span><?php
                        }
                        ?>
                    </span>
                </div>
            </div>
            <?php
            }
            ?>

            <div class="form-main">
            <?php
            foreach($row_select_form as $key => $value) {
                if ($value != '') {
                    $key_spaces = str_replace('_', ' ', $key);

                    if (ucwords($key_spaces) == "Wpcf Xml Link") {
                        ?>
                        <div class="form-group">
                            <label class="form-label"><?php echo ucwords($key_spaces); ?>: </label>
                            <span class="form-value"><a href="<?php echo $value; ?>" download="<?php echo $rowSelectForms['id'].'_passport_application.xml'; ?>">Download XML</a></span>
                        </div>
                        <?php
                    } else {
                        if (ucwords($key_spaces) == "Mobile Number") {
                            ?>
                            <div class="form-group">
                                <label class="form-label"><?php echo ucwords($key_spaces); ?>: </label>
                                <span class="form-value" id="mobile-number"><?php echo $value; ?></span>
                            </div>
                            <?php
                        } else {
                            ?>
                            <div class="form-group">
                                <label class="form-label"><?php echo ucwords($key_spaces); ?>: </label>
                                <span class="form-value"><?php echo $value; ?></span>
                            </div>
                            <?php
                        }
                    }
                }
            }
            ?>
            </div>

            <div class="form-image-main">
            <?php
            $images = array();
            foreach($row_select_form as $key => $value) {
                if (preg_match_all('#\bhttps?://[^,\s()<>]+(?:\([\w\d]+\)|([^,[:punct:]\s]|/))#', $value, $link)) {
                    $images[] = $link[0][0];
                }
            }

            foreach ($images as $key => $value) {
                ?><img class="form-image-single" src="<?php echo $value; ?>"><?php
                ?><a class="form-image-download" href="<?php echo $value; ?>" download="">Download</a><?php
            }

            if ($images == null) {
                ?><span class="form-image-empty">No Image Available</span><?php
            }
            ?>
            </div>
            <?php
        }
    ?>
    </div>
</div>