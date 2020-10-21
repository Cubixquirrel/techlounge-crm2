<div class="edit-user-form">
    <div class="edit-user-form-group">
        <input type="text" placeholder="Name" id="user-name" value="<?php echo $row_select_users['user_name']; ?>" autocomplete="off">
    </div>

    <div class="edit-user-form-group">
        <input type="text" placeholder="Email" id="user-email" value="<?php echo $row_select_users['user_email']; ?>" autocomplete="off">
    </div>

    <div class="edit-user-form-group">
        <input type="text" placeholder="Password" id="user-password" value="<?php echo $row_select_users['user_password']; ?>" autocomplete="off">
    </div>

    <div class="edit-user-form-group role-box">
        <?php
        if (in_array('Admin', explode(',', $row_select_users['user_role']))) {
            ?><span role-data="Admin" class="active" onclick="selectRole('Admin')" role-data-selected="true">Admin</span><?php
        } else {
            ?><span role-data="Admin" onclick="selectRole('Admin')">Admin</span><?php
        }

        if (in_array('Processor', explode(',', $row_select_users['user_role']))) {
            ?><span role-data="Processor" class="active" onclick="selectRole('Processor')" role-data-selected="true">Processor</span><?php
        } else {
            ?><span role-data="Processor" onclick="selectRole('Processor')">Processor</span><?php
        }

        if (in_array('Complaint', explode(',', $row_select_users['user_role']))) {
            ?><span role-data="Complaint" class="active" onclick="selectRole('Complaint')" role-data-selected="true">Complaint</span><?php
        } else {
            ?><span role-data="Complaint" onclick="selectRole('Complaint')">Complaint</span><?php
        }

        if (in_array('Sales', explode(',', $row_select_users['user_role']))) {
            ?><span role-data="Sales" class="active" onclick="selectRole('Sales')" role-data-selected="true">Sales</span><?php
        } else {
            ?><span role-data="Sales" onclick="selectRole('Sales')">Sales</span><?php
        }

        $display = 'none';
        if (in_array('Editor', explode(',', $row_select_users['user_role']))) {
            $display = 'block';
            ?><span role-data="Editor" class="active" onclick="selectRole('Editor')" role-data-selected="true">Editor</span><?php
        } else {
            $display = 'none';
            ?><span role-data="Editor" onclick="selectRole('Editor')">Editor</span><?php
        }
        ?>
    </div>

    <div class="edit-user-form-group team-box">
        <?php        
        $sql_select_users_team = 'SELECT * FROM users_team ORDER BY id ASC';
        $result_select_users_team = $conn->query($sql_select_users_team);
        if ($result_select_users_team->num_rows > 0) {
            while ($row_select_users_team = $result_select_users_team->fetch_assoc()) {
                if (in_array($row_select_users_team['team'], explode(',', $row_select_users['user_team']))) {
                ?>
                <span class="active" team-data="<?php echo $row_select_users_team['team']; ?>" onclick="selectTeam('<?php echo $row_select_users_team['team']; ?>')" team-data-selected="true"><?php echo $row_select_users_team['team']; ?></span>
                <?php
                } else {
                ?>
                <span team-data="<?php echo $row_select_users_team['team']; ?>" onclick="selectTeam('<?php echo $row_select_users_team['team']; ?>')"><?php echo $row_select_users_team['team']; ?></span>
                <?php
                }
            }
        }
        ?>
        <span class="add-business" onclick="addBusiness()">+ Add Business</span>
    </div>

    <div class="edit-user-form-group" id="editor-form-group" style="display: <?php echo $display; ?>;">
        <input type="text" placeholder='Website (Example: "EUDYOGAADHAAR.ORG","MSMEREGISTRAR.ORG")' id="user-website" value='<?php echo urldecode($row_select_users['user_web']); ?>' autocomplete="off">
    </div>

    <button class="update-button" onclick="updateUser('<?php echo $_GET['userId']; ?>')">Update</button>
</div>