<div class="add-stage-form">
    <div class="add-stage-form-group">
        <input type="text" placeholder="Name" id="stage-name" autocomplete="off">
    </div>

    <div class="edit-stage-form-group team-box">
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

    <button class="add-button" onclick="addStage()">Add</button>
</div>