<div class="table-main-container campaign-container">
    <div class="campaign-header">
        <span class="header-action-button" onclick="startCampaign()">Start Campaign</span>
    </div>
</div>

<?php
$sql_select_campaign = 'SELECT * FROM campaign ORDER BY STR_TO_DATE(campaign_date, "%d-%m-%Y %T") DESC';
$result_select_campaign = $conn->query($sql_select_campaign);
while($row_select_campaign = $result_select_campaign->fetch_assoc()) {
    $campaign_date = urldecode($row_select_campaign['campaign_date']);
    $campaign_name = $row_select_campaign['campaign_name'];
    $campaign_schedule_time = $row_select_campaign['campaign_schedule_time'];
    $campaign_email_group = urldecode($row_select_campaign['campaign_email_group']);
    $campaign_email_group_type = urldecode($row_select_campaign['campaign_email_group_type']);
    $campaign_from_email = urldecode($row_select_campaign['campaign_from_email']);
    $campaign_subject = urldecode($row_select_campaign['campaign_subject']);
    ?>
    <div class="table-body-container campaign-body-container">
        <div class="campaign-inner-container">                   
                <div class="campaign-first-inner-container">
                    <div class="campaign-inner-left">
                        <span class="campaign-date"><?php echo $campaign_date; ?></span>
                        <span class="campaign-name"><?php echo $campaign_name; ?></span>
                        <span class="campaign-schedule-time"><?php echo $campaign_schedule_time; ?></span>
                    </div>

                    <div class="campaign-inner-right">
                        <div class="orange-box">
                            <span class="campaign-email-group"><?php echo $campaign_email_group; ?></span>
                            <span class="campaign-email-group-type"><?php echo $campaign_email_group_type; ?></span>
                        </div>
                    </div>
                </div>

                <div class="campaign-seccond-inner-container">
                    <span class="campaign-from-email">Sent From: <span><?php echo $campaign_from_email; ?></span></span>
                    <span class="campaign-subject">Subject: <?php echo $campaign_subject; ?></span>
                </div>
        </div>
    </div>
    <?php
}
?>