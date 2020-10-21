<?php
    if ((in_array('Sales', explode(',', $row_select_user['user_role'])))) {
        ?>
        <div class="info-sales-main">
            <div class="info-sales-box">
                <i class="icon-today"></i>
                
                <div class="info-sales-text">
                    <span><?php echo $row_select_date[0]; ?></span>
                    <span>Todays Sales</span>
                </div>
            </div>

            <div class="info-sales-box">
                <i class="icon-date_range"></i>
                
                <div class="info-sales-text">
                    <span><?php echo $row_select_month[0]; ?></span>
                    <span>Month Sales</span>
                </div>
            </div>

            <div class="info-sales-box">
                <i class="icon-event_available"></i>
                
                <div class="info-sales-text">
                    <span><?php echo $target_left; ?></span>
                    <span>Target Lefts</span>
                </div>
            </div>
        </div>
        <?php
    }
?>