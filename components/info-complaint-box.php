<?php
    if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Complaint', explode(',', $row_select_user['user_role'])))) {
        ?>
        <div class="info-main active">
            <?php
            if (isset($_GET['stage']) && $_GET['stage'] == '0') {
                ?><div class="info-box active" onclick="openStage('0')"><?php
            } else {
                ?><div class="info-box" onclick="openStage('0')"><?php
            }
            ?>
                <i class="icon-info2"></i>
                
                <div class="info-text">
                    <span><?php echo $new_created_today; ?></span>
                    <span>New Created Today</span>
                    <span>Total: <?php echo $new_created_total; ?></span>
                </div>
            </div>

            <?php
            if (isset($_GET['stage']) && $_GET['stage'] == '1') {
                ?><div class="info-box active" onclick="openStage('1')"><?php
            } else {
                ?><div class="info-box" onclick="openStage('1')"><?php
            }
            ?>
                <i class="icon-arrow-up-circle"></i>
                
                <div class="info-text">
                    <span><?php echo $updated_by_us_today; ?></span>
                    <span>Updated By Us Today</span>
                    <span>Total: <?php echo $updated_by_us_total; ?></span>
                </div>
            </div>

            <?php
            if (isset($_GET['stage']) && $_GET['stage'] == '2') {
                ?><div class="info-box active" onclick="openStage('2')"><?php
            } else {
                ?><div class="info-box" onclick="openStage('2')"><?php
            }
            ?>
                <i class="icon-arrow-down-circle"></i>
                
                <div class="info-text">
                    <span><?php echo $updated_by_client_today; ?></span>
                    <span>Updated By Client Today</span>
                    <span>Total: <?php echo $updated_by_client_total; ?></span>
                </div>
            </div>

                <?php
            if (isset($_GET['stage']) && $_GET['stage'] == '3') {
                ?><div class="info-box active" onclick="openStage('3')"><?php
            } else {
                ?><div class="info-box" onclick="openStage('3')"><?php
            }
            ?>
                <i class="icon-do_not_disturb_alt"></i>
                
                <div class="info-text">
                    <span><?php echo $closed_today; ?></span>
                    <span>Closed By Us Today</span>
                    <span>Total: <?php echo $closed_total; ?></span>
                </div>
            </div>
        </div>
        <?php
    }
?>