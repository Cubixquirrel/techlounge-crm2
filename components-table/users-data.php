<div class="table-main-container user-main-container">
    <div class="action-main-box">
        <span id="add-user" onclick="addUser()">Add User</span>
        <span id="edit-user" onclick="editUser()">Edit User</span>
        <span id="hold" onclick="holdUser()">Block</span>
        <span id="un-hold" onclick="unHoldUser()">Unblock</span>
    </div>
    <?php

    $sql_select_users = 'SELECT * FROM users ORDER BY user_role ASC';
    $result_select_users = $conn->query($sql_select_users);

    if ($result_select_users->num_rows > 0) {
        while ($row_select_users = $result_select_users->fetch_assoc()) {
            if ($row_select_users['user_status'] == 'true') {
                $signal = 'status green';
                $signal_text = 'Online';
            } else {
                $signal = 'status red';
                $signal_text = 'Offline';
            }

            if ($row_select_users['is_hold'] == 'true') {
                $table_class = 'table users blocked';
            } else {
                $table_class = 'table users unblocked';
            }
            ?>
            <div class="<?php echo $table_class; ?>" table-data-id="<?php echo $row_select_users['user_id']; ?>" onclick="selectUserTableDataId('<?php echo $row_select_users['user_id']; ?>')">
                <div class="table-first">
                    <div class="first-inner">
                        <span class="date-column"><?php echo $row_select_users['user_email']; ?></span>
                        <span class="status-column"><?php echo $row_select_users['user_name']; ?></span>
                    </div>

                    <div class="first-inner">
                        <span class="business-column"><?php echo $signal_text; ?></span>
                        <span class="<?php echo $signal; ?>"></span>
                    </div>
                </div>

                <div class="table-second">
                    <div class="second-inner">                        
                        <span>Last Login: <span class="location-column"><?php echo $row_select_users['last_login']; ?></span>
                    </div>

                    <div class="second-inner">
                        <span>Last Logout: <span class="sales-user-column"><?php echo $row_select_users['last_logout']; ?></span></span>
                    </div>
                </div>

                <div class="table-third">
                    <div class="third-inner">
                        <span>
                            <span class="client-name-column">
                            <?php
                            $user_roles = explode(',', $row_select_users['user_role']);
                            foreach ($user_roles as $key => $value) {
                                echo '<span>'.$value.'</span>';
                            }
                            ?>
                            </span>
                        </span>

                        <span>
                            <span class="client-name-column">
                            <?php
                            $user_teams = explode(',', $row_select_users['user_team']);
                            foreach ($user_teams as $key => $value) {
                                echo '<span>'.$value.'</span>';
                            }
                            ?>
                            </span>
                        </span>

                        <?php
                        $user_teams = explode(',', $row_select_users['user_role']);
                        if (in_array('Editor', $user_teams)) {
                            if ($row_select_users['user_web'] != '') {                                
                                $user_webs = explode(',', urldecode($row_select_users['user_web']));
                            ?>
                            <span>
                                <span class="client-name-column">
                                    <?php
                                    foreach ($user_webs as $key => $value) {
                                        echo '<span>'.substr(substr($value, 1), 0, -1).'</span>';
                                    }
                                    ?>
                                </span>
                            </span>
                            <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
            <?php
        }
    } else {
        ?>
        <span class="empty-table-box">No users found.</span>
        <?php
    }
    ?>
</div>