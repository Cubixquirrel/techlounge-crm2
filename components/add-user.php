<div class="add-user-form">
    <div class="add-user-form-group">
        <input type="text" placeholder="Name" id="user-name" autocomplete="off">
    </div>

    <div class="add-user-form-group">
        <input type="text" placeholder="Email" id="user-email" autocomplete="off">
    </div>

    <div class="add-user-form-group">
        <input type="text" placeholder="Password" id="user-password" autocomplete="off">
    </div>

    <div class="add-user-form-group role-box">
        <span role-data="Admin" onclick="selectRole('Admin')">Admin</span>
        <span role-data="Processor" onclick="selectRole('Processor')">Processor</span>
        <span role-data="Complaint" onclick="selectRole('Complaint')">Complaint</span>
        <span role-data="Sales" onclick="selectRole('Sales')">Sales</span>
        <span role-data="Editor" onclick="selectRole('Editor')">Editor</span>
    </div>

    <div class="add-user-form-group team-box">
        <?php
        $sql_select_users_team = 'SELECT * FROM users_team ORDER BY id ASC';
        $result_select_users_team = $conn->query($sql_select_users_team);
        if ($result_select_users_team->num_rows > 0) {
            while ($row_select_users_team = $result_select_users_team->fetch_assoc()) {
                ?>
                <span team-data="<?php echo $row_select_users_team['team']; ?>" onclick="selectTeam('<?php echo $row_select_users_team['team']; ?>')"><?php echo $row_select_users_team['team']; ?></span>
                <?php
            }
        }
        ?>
        <span class="add-business" onclick="addBusiness()">+ Add Business</span>
    </div>

    <div class="add-user-form-group" id="editor-form-group" style="display: none;">
        <input type="text" placeholder='Website (Example: "EUDYOGAADHAAR.ORG","MSMEREGISTRAR.ORG")' id="user-website" autocomplete="off">
    </div>

    <button class="add-button" onclick="addUser()">Add</button>
</div>