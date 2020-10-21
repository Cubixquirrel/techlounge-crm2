<?php
    if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Sales', explode(',', $row_select_user['user_role'])))) {
        ?>
        <div class="info-main">
            <div class="info-box" onclick="openViews('lead.php')">
                <i class="icon-edit1"></i>
                
                <div class="info-text">
                    <span><?php echo $row_count_lead[0]; ?></span>
                    <span>In Lead</span>
                </div>
            </div>

            <div class="info-box" onclick="openViews('follow-up.php')">
                <i class="icon-thumbs-up1"></i>
                
                <div class="info-text">
                    <span><?php echo $row_count_follow_up[0]; ?></span>
                    <span>In Follow Up</span>
                </div>
            </div>

            <div class="info-box" onclick="openViews('dropped.php')">
                <i class="icon-trash-2"></i>
                
                <div class="info-text">
                    <span><?php echo $row_count_dropped[0]; ?></span>
                    <span>In Dropped</span>
                </div>
            </div>

            <div class="info-box" onclick="openViews('paid.php')">
                <i class="icon-check-circle"></i>
                
                <div class="info-text">
                    <span><?php echo $row_count_paid[0]; ?></span>
                    <span>In Paid</span>
                </div>
            </div>
        </div>
        <?php
    }
?>