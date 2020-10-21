<div class="table-main-container businesses-main-container">
    <div class="action-main-box">
        <span id="add-business" onclick="addBusiness()">Add Business</span>
        <span id="add-stage" onclick="addStage()">Add Stage</span>
    </div>
    <?php

    $sql_select_users_team = 'SELECT * FROM users_team';
    $result_select_users_team = $conn->query($sql_select_users_team);

    if ($result_select_users_team->num_rows > 0) {
        while ($row_select_users_team = $result_select_users_team->fetch_assoc()) {
            $business = $row_select_users_team['team'];
            ?>
            <div class="table" table-data-id="<?php echo $row_select_users_team['id']; ?>">
                <div class="table-first">
                    <div class="inner">
                        <span class="business-column"><?php echo $row_select_users_team['team']; ?></span>
                    </div>
                    
                    <div class="first-inner-right">
                        <div class="inner">
                            <span class="action-column" id="add-template" onclick="addTemplate('<?php echo $row_select_users_team['id']; ?>')">Add Template</span>
                        </div>

                        <div class="inner">
                            <span class="action-column" id="manage-stage" onclick="manageStage('<?php echo $row_select_users_team['id']; ?>')">Manage Stage</span>
                        </div>
                    </div>
                </div>

                <div class="table-third">
                    <div class="third-inner">

                    <?php
                    $sql_select_business = 'SELECT * FROM business WHERE business_name = "'.$business.'" ORDER BY stage_order + 0 ASC';
                    $result_select_business = $conn->query($sql_select_business);
        
                    if ($result_select_business->num_rows > 0) {
                        while ($row_select_business = $result_select_business->fetch_assoc()) {
                            $business = $row_select_business['business_name'];
                            $business_stage = $row_select_business['stage'];                            
                            ?>
                            <div class="stage-main">
                                <span class="stage-name"><?php echo $row_select_business['stage'] . ' : '; ?></span>
                                <ul>
                                <?php                        
                                $sql_select_email_processor = 'SELECT * FROM email_processor WHERE business_name = "'.$business.'" AND business_stage = "'.$business_stage.'"';
                                $result_select_email_processor = $conn->query($sql_select_email_processor);
                                if ($result_select_email_processor->num_rows > 0) {
                                    while ($row_select_email_processor = $result_select_email_processor->fetch_assoc()) {
                                        $email_processor_id = $row_select_email_processor['id'];
                                        ?>
                                        <li class="client-name-column">
                                        <?php echo $row_select_email_processor['template_name']; ?>
                                        <span class="template-action">
                                            <span class="edit-template" data-id="edit-template-<?php echo $row_select_email_processor['id']; ?>" onclick="editTemplate('<?php echo $row_select_email_processor['id']; ?>')">(Edit)</span>
                                            <span class="delete-template" data-id="delete-template-<?php echo $row_select_email_processor['id']; ?>" onclick="deleteTemplate('<?php echo $row_select_email_processor['id']; ?>')">(Delete)</span>
                                        </span>
                                        </li>
                                        <?php
                                    }
                                } else {
                                    ?><li class="client-name-column"><?php echo 'No Template Available'; ?></li><?php
                                }
                                ?>
                                </ul>
                            </div>
                            <?php
                        }
                    } else {
                        ?>
                        <span>
                            <span class="client-name-column">No Stage Found</span>
                        </span>
                        <?php
                    }
                    ?>
                    </div>
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