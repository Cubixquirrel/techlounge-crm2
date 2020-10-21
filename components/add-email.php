<div class="add-email-form">
    <div class="add-email-form-group">
        <select id="domain">
            <option value="">Select Domain</option>
            <option value="" disabled>--------------------------</option>
            <?php
                $sql_select_forms = 'SELECT * FROM `forms` GROUP BY website ORDER BY website ASC';
                $result_select_forms = $conn->query($sql_select_forms);
                if ($result_select_forms->num_rows > 0) {
                    while ($row_select_forms = $result_select_forms->fetch_assoc()) {
                        if ($row_select_forms["website"] != '') {
                            $website = strtolower($row_select_forms['website']);
                            ?><option value="<?php echo $website; ?>"><?php echo $website; ?></option><?php
                        }
                    }
                }
            ?>
        </select>
    </div>

    <div class="add-email-form-group">
        <input type="text" placeholder="User Name" id="user-name" autocomplete="off" onkeyup="joinDomain()">
        <span class="email-id-box"></span>
    </div>

    <div class="add-email-form-group">
        <input type="password" placeholder="Password" id="password" autocomplete="off">
    </div>

    <div class="add-email-form-group">
        <input type="password" placeholder="Confirm Password" id="confirm-password" autocomplete="off">
    </div>

    <button class="add-button" onclick="addEmail()">Add</button>
</div>