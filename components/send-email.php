<?php
function generateToken($length = 7) {
    $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $token = '';
    while(strlen($token) < $length) {
        $token .= $chars[mt_rand(0, strlen($chars)-1)];
    }
    return $token;
}
$print_gid = generateToken(16);

$sql_select_cid = "SELECT * FROM edit_form_link WHERE form_id = '".$_GET['formId']."' AND panel_form_id = '".$_GET['clientId']."'";
$result_select_cid = $conn->query($sql_select_cid);
$row_select_cid = $result_select_cid->fetch_assoc();
$cid = $row_select_cid['full_link'];

if ($_SERVER['HTTP_HOST'] == 'localhost') {
    $print_link = 'http://localhost/print.udyamprocessing.co/index.php?printGid='.$print_gid;
    $curl_url_form = "http://localhost/crm2.techlounge.co.in/views/form.php?clientId=".$_GET['clientId']."&formId=".$_GET['formId']."&request=click";
    $referer_link_paid = 'http://localhost/crm2.techlounge.co.in/views/paid.php';
} else {
    $print_link = 'https://print.udyamprocessing.co/index.php?printGid='.$print_gid;
    $curl_url_form = "https://crm2.techlounge.co.in/views/form.php?clientId=".$_GET['clientId']."&formId=".$_GET['formId']."&request=click";
    $referer_link_paid = 'https://crm2.techlounge.co.in/views/paid.php';
}

$curl = curl_init();
curl_setopt_array($curl, array(
  CURLOPT_URL => $curl_url_form,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => "GET",
  CURLOPT_HTTPHEADER => array(
    "Referer: ".$referer_link_paid."",
    "Cookie: user_status=true; user_auth=".$_COOKIE['user_auth'].""
  ),
));
$response = curl_exec($curl);
curl_close($curl);

function string_between_two_string($str, $starting_word, $ending_word) { 
    $subtring_start = strpos($str, $starting_word);
    $subtring_start += strlen($starting_word);
    $size = strpos($str, $ending_word, $subtring_start) - $subtring_start;
    return substr($str, $subtring_start, $size);
}
$form_mobile_number = string_between_two_string($response, '<span class="form-value" id="mobile-number">', '</span>');
?>

<form role="form" id="send-email-form" action="../requests/send-email.php" method="POST" enctype="multipart/form-data">
    <div class="card-body">
        <div class="form-group">
            <label>From <span class="text-danger">*</span></label>
            <?php
                $sql_select_forms = "SELECT * FROM forms WHERE id = '".$_GET['clientId']."'";
                $result_select_forms = $conn->query($sql_select_forms);
                if ($result_select_forms->num_rows > 0) {
                    $row_select_forms = $result_select_forms->fetch_assoc();
                    $business = $row_select_forms['business'];
                    if ($row_select_forms['website'] == 'EUDYOGAADHAAR.ORG') {
                        $from = 'noreply@' . strtolower($row_select_forms['website']);
                    }
                    else if ($row_select_forms['website'] == 'UDYOGADHARCERTIFICATE.IN') {
                        $from = 'no-reply1@' . strtolower($row_select_forms['website']);
                    }
                    else {
                        $from = 'no-reply@' . strtolower($row_select_forms['website']);
                    }
                };
            ?>
            <input type="text" class="form-control" value="<?php echo $from; ?>" name="fromEmail" readonly>
        </div> 

        <div class="form-group">
            <label>Subject <span class="text-danger">*</span></label>
            <select id="type" name="type" class="form-control" onchange='updateMessage("<?php echo $print_gid; ?>", "<?php echo $cid; ?>", "<?php echo $print_link; ?>", "<?php echo $form_mobile_number; ?>")'>
                <option value="">-- Select Subject --</option>
                <?php
                    $sql_select_email_processor = "SELECT * FROM email_processor WHERE business_name = '".$business."'";
                    $result_select_email_processor = $conn->query($sql_select_email_processor);
                    if ($result_select_email_processor->num_rows > 0) {
                        while ($row_select_email_processor = $result_select_email_processor->fetch_assoc()) {
                            ?><option value="<?php echo $row_select_email_processor['template_name']; ?>"><?php echo $row_select_email_processor['template_name']; ?></option><?php
                        }
                    }
                ?>
            </select>
        </div>

        <div class="form-group">
            <input type="text" class="form-control" name="subject" placeholder="Subject" readonly>
        </div>

        <div class="form-group">
            <label>Message <span class="text-danger">*</span></label>
            <div contenteditable="false" class="form-control" style="height: 400px; overflow: auto" name="messageDisplay" readonly></div>
            <textarea class="form-control" style="display: none" name="message"></textarea>
        </div>

        <div class="form-group" id="uam" style="display: none;">
            <label>Udyam Registration Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="uam" maxlength="19" minlength="19" onkeyup="updateUAM()">
        </div>

        <div class="form-group" id="dl-application-number" style="display: none;">
            <label>Application Number <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="dlApplicationNumber" onkeyup="updateDlApplicationNumber()">
        </div>

        <div class="form-group" id="date-slot" style="display: none;">
            <label>Date Slot <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="dateSlot" onkeyup="updateDateSlot()">
        </div>

        <div class="form-group" id="login-id-password" style="display: none;">
            <label>Login ID & Password <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="loginIdPassword" onkeyup="updateLoginIdPassword()">
        </div>

        <div class="form-group" id="dl-detail-document" style="display: none;">
            <label>DL Issues <span class="text-danger">*</span></label>
            <input type="text" class="form-control" name="dlDetailDocument" onkeyup="updateDlDetailDocument()">
        </div>

        <div class="form-group">
            <label>Remarks <span class="text-danger">*</span></label>
            <textarea class="form-control" rows="2" name="remarks"></textarea>
        </div>

        <input type="hidden" name="printGid" value="">

        <div class="form-group attachment-div">
            <div class="attachment-file">
                <label>Multiple Attachment</label>
                <input type="file" name="attachment[]" id="attachment" multiple="" onchange="makeFileList();">
            </div>
            <ul id="attachment-list"></ul>
        </div>
    </div>

    <div class="card-footer">
        <input type="hidden" name="businessName" value="<?php echo $business; ?>">
        <input type="hidden" name="clientId" value="<?php echo $_GET['clientId']; ?>">
        <input type="hidden" name="formId" value="<?php echo $_GET['formId']; ?>">
        <button type="submit" class="send-button" id="send-email">Send</button>
    </div>
</form>