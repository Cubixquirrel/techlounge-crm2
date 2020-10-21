<div class="start-campaign-form">
    <div class="start-campaign-form-group">
        <input type="text" placeholder="Campaign Name" id="campaign-name" autocomplete="off">
    </div>

    <div class="start-campaign-form-group">
        <select id="campaign-schedule-time">
            <option value="">Select Schedule Time</option>
            <option value="" disabled>--------------------------</option>
            <option value="Once Per Day">Once Per Day</option>
            <option value="Twice Per Day">Twice Per Day</option>
            <option value="Once Per Week">Once Per Week</option>
            <option value="Once Per Month">Once Per Month</option>
        </select>
    </div>

    <div class="start-campaign-form-group">
        <select id="campaign-email-group">
            <option value="">Select Email Group</option>
            <option value="" disabled>--------------------------</option>
            <?php
                $sql_select_users_team = 'SELECT * FROM users_team ORDER BY team ASC';
                $result_select_users_team = $conn->query($sql_select_users_team);
                if ($result_select_users_team->num_rows > 0) {
                    while ($row_select_users_team = $result_select_users_team->fetch_assoc()) {
                        $team = $row_select_users_team['team'];
                        ?><option value="<?php echo $team; ?>"><?php echo $team; ?></option><?php
                    }
                }
            ?>
        </select>
    </div>

    <div class="start-campaign-form-group">
        <select id="campaign-email-group-type">
            <option value="">Select Email Group Type</option>
            <option value="" disabled>--------------------------</option>
            <option value="Paid">Paid</option>
            <option value="Unpaid">Unpaid</option>
        </select>
    </div>

    <div class="start-campaign-form-group">
        <select id="campaign-from-email">
            <option value="">Select From Email</option>
            <option value="" disabled>--------------------------</option>
            <?php
                $sql_select_email_lists = 'SELECT * FROM campaign_email_lists ORDER BY email_id ASC';
                $result_select_email_lists = $conn->query($sql_select_email_lists);
                if ($result_select_email_lists->num_rows > 0) {
                    while ($row_select_email_lists = $result_select_email_lists->fetch_assoc()) {
                        $email_id = $row_select_email_lists['email_id'];
                        ?><option value="<?php echo $email_id; ?>"><?php echo $email_id; ?></option><?php
                    }
                }
            ?>
        </select>
        <span class="add-email" onclick="openAddEmail()">+ Add Email</span>
    </div>

    <div class="start-campaign-form-group">
        <input type="text" placeholder="Campaign Subject" id="campaign-subject" autocomplete="off">
    </div>

    <button class="copy-button" onclick="previewMail()">Copy Unsubscribe Link</button>

    <div class="start-campaign-form-group">
        <textarea placeholder="Mail Body" id="campaign-message" cols="30" rows="10" autocomplete="off"></textarea>
    </div>

    <button class="preview-button" onclick="previewMail()">Preview</button>
    <button class="send-button" onclick="sendCampaign()">Send</button>

    <div class="preview-mail-box"></div>
</div>