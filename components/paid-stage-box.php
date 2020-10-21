<?php
    if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Processor', explode(',', $row_select_user['user_role'])))) {
        if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) {
            $sql_select_forms_refunded = 'SELECT COUNT(*) FROM forms WHERE business = "'.$_GET["business"].'" AND status = "Paid" AND stage = "Refunded"';
            $sql_select_forms_refunded_updated = 'SELECT COUNT(*) FROM forms WHERE business = "'.$_GET["business"].'" AND status = "Paid" AND stage = "Refunded" AND is_updated = "true"';
            

            $result_select_forms_refunded = $conn->query($sql_select_forms_refunded);
            $row_select_forms_refunded = $result_select_forms_refunded->fetch_row();

            $result_select_forms_refunded_updated = $conn->query($sql_select_forms_refunded_updated);
            $row_select_forms_refunded_updated = $result_select_forms_refunded_updated->fetch_row();
        }
        ?>
        <?php if ($_GET['business'] != 'ALL') { ?>
        <div class="stage-main">
            <?php
            if (isset($_GET['stage']) && $_GET['stage'] == 'Refunded') {
                $stage_refunded = 'active';
            } else {
                $stage_refunded = '';
            }
            ?>

            <?php
            if ($_GET['business'] != 'ALL') {
                $sql_select_business = 'SELECT * FROM business WHERE business_name = "'.$_GET['business'].'" ORDER BY stage_order + 0 ASC';
                $result_select_business = $conn->query($sql_select_business);

                if ($result_select_business->num_rows > 0) {
                    while ($row_select_business = $result_select_business->fetch_assoc()) {
                        if (isset($_GET['stage']) && $_GET['stage'] == $row_select_business['stage']) {
                            $stage_active = 'active';
                        } else {
                            $stage_active = '';
                        }
                        if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) {
                            $sql_select_forms = 'SELECT COUNT(*) FROM forms WHERE business = "'.$_GET["business"].'" AND status = "Paid" AND stage = "'.$row_select_business['stage'].'"';
                            $sql_select_forms_updated = 'SELECT COUNT(*) FROM forms WHERE business = "'.$_GET["business"].'" AND status = "Paid" AND stage = "'.$row_select_business['stage'].'" AND is_updated = "true"';
                        } else if ((in_array('Processor', explode(',', $row_select_user['user_role'])))) {
                            $sql_select_forms = 'SELECT COUNT(*) FROM forms WHERE business = "'.$_GET["business"].'" AND status = "Paid" AND stage = "'.$row_select_business['stage'].'" AND processor="'.$user_name.'"';
                            $sql_select_forms_updated = 'SELECT COUNT(*) FROM forms WHERE business = "'.$_GET["business"].'" AND status = "Paid" AND stage = "'.$row_select_business['stage'].'" AND processor="'.$user_name.'" AND is_updated = "true"';
                        }
                        $result_select_forms = $conn->query($sql_select_forms);
                        $row_select_forms = $result_select_forms->fetch_row();

                        $result_select_forms_updated = $conn->query($sql_select_forms_updated);
                        $row_select_forms_updated = $result_select_forms_updated->fetch_row();
                        ?>
                        <div class="stage-box <?php echo $stage_active; ?>" id="<?php echo str_replace(' ', '-', strtolower($row_select_business['stage'])); ?>-stage-box" onclick="openStage('<?php echo $row_select_business['stage']; ?>')">                   
                            <div class="stage-text">
                                <span><?php echo $row_select_forms[0]; ?></span>
                                <span><?php echo $row_select_business['stage']; ?></span>
                            </div>

                            <div class="updated-stage-text">
                                <span>Updated: <?php echo $row_select_forms_updated[0]; ?></span>
                            </div>
                        </div>
                        <?php
                    }
                }
            }
            ?>
            
            <?php if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) { ?>
            <?php if ($_GET['business'] != 'ALL') { ?>
            <div class="stage-box <?php echo $stage_refunded; ?>" id="refunded-stage-box" onclick="openStage('Refunded')">                   
                <div class="stage-text">
                    <span><?php echo $row_select_forms_refunded[0]; ?></span>
                    <span>Refunded</span>
                </div>

                <div class="updated-stage-text">
                    <span>Updated: <?php echo $row_select_forms_refunded_updated[0]; ?></span>
                </div>
            </div>
            <?php } ?>
            <?php } ?>
        </div>
        <?php } ?>
        <?php
    }