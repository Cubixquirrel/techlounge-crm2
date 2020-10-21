<?php
$form_id = $_GET['formId'];
$sql_select_complaint = "SELECT * FROM complaint_forms WHERE id = '".$form_id."'";
$result_select_complaint = $conn->query($sql_select_complaint);
$row_select_complaint = $result_select_complaint->fetch_assoc();
$complaint_id = $row_select_complaint['complaint_id'];
?>

<div class="complaint-header">
    <div class="complaint-client-details">
        <span>Complaint ID: <?php echo $row_select_complaint['complaint_id']; ?></span>
        <span>Mobile Number: <?php echo $row_select_complaint['mobile_number']; ?></span>
        <span>Email Id: <?php echo $row_select_complaint['email_id']; ?></span>
        <span>Website: <?php echo $row_select_complaint['website']; ?></span>
    </div>

    <?php
    if ($row_select_complaint['status'] == 'true') {
        ?><button class="close-button" id="close-button">Closed</button><?php
    } else {
        ?><button class="close-button" id="close-button" onclick="closeComplaint('<?php echo $form_id; ?>')">Close Complaint</button><?php
    }
    ?>
</div>

<div class="complaint-main">
<?php
    $sql = "SELECT * FROM complaint_timeline WHERE meta_id = '".$complaint_id."' ORDER BY id ASC";
    $result = $conn->query($sql);

    $timeline = '<div class="timeline">';

    if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $timeline .= '<span class="time-label">';
        $timeline .= ''.$row['form_created_on'].' - '.$row['form_created_time'].'';
        $timeline .= '</span>';

        if ($row['meta_name'] == 'complaint form') {
        $timeline .= '<div>';
            $timeline .= '<div class="timeline-item">';
            $timeline .= '<span class="timeline-header">'.$row['meta_user'].'</span>';
            $timeline .= '<div class="timeline-body">';
                $timeline .= ''.urldecode($row['meta_description']).'';
            $timeline .= '</div>';
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
</div>

<?php
if ($row_select_complaint['status'] != 'true') {
    ?>
    <div class="complaint-footer">
        <textarea class="message" id="message" placeholder="Enter your reply here..." rows="3"></textarea>    
        <button type="button" class="send-button" id="send-button" onclick="sendComplaintMessage('<?php echo $form_id; ?>')">Send</button>        
    </div>
    <?php
} else {
    ?>
    <div class="complaint-footer disabled">
        <textarea class="message" id="message" placeholder="Enter your reply here..." rows="3" disabled></textarea>    
        <button type="button" class="send-button" id="send-button" disabled>Send</button>        
    </div>
    <?php  
}
?>