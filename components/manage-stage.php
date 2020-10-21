<div class="table-main-container businesses-main-container">
    <div class="table">
        <div class="table-third">
            <div class="third-inner">
                <?php

                $sql_select_users_team = 'SELECT * FROM users_team WHERE id = "'.$_GET["businessId"].'"';
                $result_select_users_team = $conn->query($sql_select_users_team);
                $row_select_users_team = $result_select_users_team->fetch_assoc();
                $business = $row_select_users_team['team'];

                $sql_select_business = 'SELECT * FROM business WHERE business_name = "'.$business.'" ORDER BY stage_order + 0 ASC';
                $result_select_business = $conn->query($sql_select_business);
                if ($result_select_business->num_rows > 0) {
                    $sql_select_business_count = 'SELECT COUNT(*) FROM business WHERE business_name = "'.$business.'"';
                    $result_select_business_count = $conn->query($sql_select_business_count);
                    $row_select_business_count = $result_select_business_count->fetch_row();

                    while ($row_select_business = $result_select_business->fetch_assoc()) {
                        ?>
                        <div class="business-main-box">
                            <span class="stage-text-box" stage-data-id="<?php echo $row_select_business['id']; ?>" stage-data="<?php echo $row_select_business['stage']; ?>"><?php echo $row_select_business['stage']; ?></span>
                            <div>
                                <span class="rename-button" id="rename-button-<?php echo $row_select_business['id']; ?>" onclick="renameStage('<?php echo $row_select_business['id']; ?>', '<?php echo $_GET['businessId']; ?>')">Rename</span>
                                <span class="delete-button" id="delete-button-<?php echo $row_select_business['id']; ?>" onclick="deleteStage('<?php echo $row_select_business['id']; ?>', '<?php echo $_GET['businessId']; ?>')">Delete</span>
                                <select>                        
                                    <option value="<?php echo $row_select_business['stage_order']; ?>" selected><?php echo $row_select_business['stage_order']; ?></option>
                                    <option value="----------" disabled>----------</option>
                                    <?php
                                    for ($i = 1; $i <= $row_select_business_count[0]; $i++) {
                                        ?><option value="<?php echo $i; ?>"><?php echo $i; ?></option><?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <?php
                    }
                } else {
                    ?>
                    <span class="empty-table-box">No businesses found.</span>
                    <?php
                }
                ?>
            </div>
            
            <button class="update-button" onclick="updateStageOrder()">Update</button>
        </div>
    </div>
</div>
