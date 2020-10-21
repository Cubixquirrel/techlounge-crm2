<div class="business-box">
    <?php
    if (isset($_GET['business'])) {
        $business = $_GET['business'];

        if ($business != 'ALL') {
            ?><span onclick="openViewsWithBusiness('ALL')">ALL</span><?php
            
            $businesses = explode(',', $row_select_user['user_team']);
            foreach ($businesses as $key => $value) {
                if ($value == $business) {
                    ?><span class="active" onclick="openViewsWithBusiness('<?php echo $value; ?>')"><?php echo $value; ?></span><?php
                } else {
                    ?><span onclick="openViewsWithBusiness('<?php echo $value; ?>')"><?php echo $value; ?></span><?php
                }
            }
        } else {
            ?><span class="active" onclick="openViewsWithBusiness('ALL')">ALL</span><?php
            
            $businesses = explode(',', $row_select_user['user_team']);
            foreach ($businesses as $key => $value) {
                if ($value == $business) {
                    ?><span onclick="openViewsWithBusiness('<?php echo $value; ?>')"><?php echo $value; ?></span><?php
                } else {
                    ?><span onclick="openViewsWithBusiness('<?php echo $value; ?>')"><?php echo $value; ?></span><?php
                }
            }
        }
    } else {
        ?><span class="active" onclick="openViewsWithBusiness('ALL')">ALL</span><?php
        
        $businesses = explode(',', $row_select_user['user_team']);
        foreach ($businesses as $key => $value) {
            ?><span onclick="openViewsWithBusiness('<?php echo $value; ?>')"><?php echo $value; ?></span><?php
        }
    }
    ?>
</div>