<?php
$business = $_GET['business'];
$website = $_GET['website'];
$status = $_GET['status'];
$pay_vendor = $_GET['payVendor'];
$amount = $_GET['amount'];
$assigned_to = $_GET['sales'];
$processor = $_GET['processor'];

$from_date = $_GET['fromDate'];
$filter_from_date = (explode('-', $from_date)[0]);
$filter_from_month = (explode('-', $from_date)[1]);
$filter_from_year = (explode('-', $from_date)[2]);

$to_date = $_GET['toDate'];
$filter_to_date = (explode('-', $to_date)[0]);
$filter_to_month = (explode('-', $to_date)[1]);
$filter_to_year = (explode('-', $to_date)[2]);

$order_by = $_GET['orderBy'];
?>

<div class="sorting-main" style="display: none;">
    <div class="sorting-box">
        <select id="filter-website">
            <option value="ALL">All Website</option>
            <option value="" disabled>--------------</option>
            <?php
            if ($business != 'ALL') {
                $sql_select_forms_filter_website = 'SELECT * FROM `forms` WHERE business = "'.$business.'" GROUP BY website ORDER BY website ASC';                
            } else {
                $sql_select_forms_filter_website = 'SELECT * FROM `forms` GROUP BY website ORDER BY website ASC';
            }
            $result_select_forms_filter_website = $conn->query($sql_select_forms_filter_website);
            while($row_select_forms_filter_website = $result_select_forms_filter_website->fetch_assoc()) {
                if ($row_select_forms_filter_website["website"] != '') {
                    if ($website == 'ALL') {
                        echo '<option value="'.$row_select_forms_filter_website["website"].'">'.$row_select_forms_filter_website["website"].'</option>';
                    } else {
                        if ($website == $row_select_forms_filter_website['website']) {
                            echo '<option value="'.$row_select_forms_filter_website["website"].'" selected>'.$row_select_forms_filter_website["website"].'</option>';    
                        } else {
                            echo '<option value="'.$row_select_forms_filter_website["website"].'">'.$row_select_forms_filter_website["website"].'</option>';
                        }
                    }
                }
            }
            ?>
        </select>

        <?php
        if (($page_title == 'Dashboard')) {
        ?>
        <select id="filter-status">
            <option value="ALL">All Status</option>
            <option value="" disabled>--------------</option>
            <?php
            $sql_select_forms_filter_status = 'SELECT * FROM `forms` GROUP BY status ORDER BY status ASC';
            $result_select_forms_filter_status = $conn->query($sql_select_forms_filter_status);
            while($row_select_forms_filter_status = $result_select_forms_filter_status->fetch_assoc()) {
                if ($row_select_forms_filter_status["status"] != '') {
                    if ($status == 'ALL') {
                        echo '<option value="'.$row_select_forms_filter_status["status"].'">'.$row_select_forms_filter_status["status"].'</option>';
                    } else {
                        if ($status == $row_select_forms_filter_status['status']) {
                            echo '<option value="'.$row_select_forms_filter_status["status"].'" selected>'.$row_select_forms_filter_status["status"].'</option>';    
                        } else {
                            echo '<option value="'.$row_select_forms_filter_status["status"].'">'.$row_select_forms_filter_status["status"].'</option>';
                        }
                    }
                }
            }
            ?>
        </select>
        <?php
        }
        ?>

        <?php
        if (
            ($page_title == 'Dashboard') OR 
            (
                ($page_title == 'Paid') && 
                (
                    (
                        in_array (
                            'Admin', 
                            explode(',', $row_select_user['user_role'])
                        )
                    )
                ) OR 
                ($page_title == 'Pending Process') && 
                (
                    (
                        in_array (
                            'Processor', 
                            explode(',', $row_select_user['user_role'])
                        )
                    )
                )
            )
        ) {
        ?>
        <select id="filter-pay-vendor">
            <option value="ALL">All Payment Gateway</option>
            <option value="" disabled>--------------</option>
            <?php
            if ($business != 'ALL') {
                $sql_select_forms_filter_pay_vendor = 'SELECT * FROM `forms` WHERE business = "'.$business.'" GROUP BY pay_vendor ORDER BY pay_vendor ASC';
            } else {
                $sql_select_forms_filter_pay_vendor = 'SELECT * FROM `forms` GROUP BY pay_vendor ORDER BY pay_vendor ASC';
            }
            $result_select_forms_filter_pay_vendor = $conn->query($sql_select_forms_filter_pay_vendor);
            while($row_select_forms_filter_pay_vendor = $result_select_forms_filter_pay_vendor->fetch_assoc()) {
                if ($row_select_forms_filter_pay_vendor["pay_vendor"] != '') {
                    if ($pay_vendor == 'ALL') {
                        echo '<option value="'.$row_select_forms_filter_pay_vendor["pay_vendor"].'">'.$row_select_forms_filter_pay_vendor["pay_vendor"].'</option>';
                    } else {
                        if ($pay_vendor == $row_select_forms_filter_pay_vendor['pay_vendor']) {
                            echo '<option value="'.$row_select_forms_filter_pay_vendor["pay_vendor"].'" selected>'.$row_select_forms_filter_pay_vendor["pay_vendor"].'</option>';    
                        } else {
                            echo '<option value="'.$row_select_forms_filter_pay_vendor["pay_vendor"].'">'.$row_select_forms_filter_pay_vendor["pay_vendor"].'</option>';
                        }
                    }
                }
            }
            ?>
        </select>
        <?php
        }
        ?>

        <select id="filter-amount">
            <option value="ALL">All Amount</option>
            <option value="" disabled>--------------</option>
            <?php
            if ($business != 'ALL') {
                $sql_select_forms_filter_amount = 'SELECT * FROM `forms` WHERE business = "'.$business.'" GROUP BY amount ORDER BY amount ASC';                
            } else {
                $sql_select_forms_filter_amount = 'SELECT * FROM `forms` GROUP BY amount ORDER BY amount ASC';
            }
            $result_select_forms_filter_amount = $conn->query($sql_select_forms_filter_amount);
            while($row_select_forms_filter_amount = $result_select_forms_filter_amount->fetch_assoc()) {
                if ($row_select_forms_filter_amount["amount"] != '') {
                    if ($amount == 'ALL') {
                        echo '<option value="'.$row_select_forms_filter_amount["amount"].'">'.$row_select_forms_filter_amount["amount"].'</option>';
                    } else {
                        if ($amount == $row_select_forms_filter_amount['amount']) {
                            echo '<option value="'.$row_select_forms_filter_amount["amount"].'" selected>'.$row_select_forms_filter_amount["amount"].'</option>';    
                        } else {
                            echo '<option value="'.$row_select_forms_filter_amount["amount"].'">'.$row_select_forms_filter_amount["amount"].'</option>';
                        }
                    }
                }
            }
            ?>
        </select>

        <?php
        if (($page_title == 'Dashboard') OR (($page_title != 'Dashboard') && in_array('Admin', explode(',', $row_select_user['user_role'])))) {
        ?>
        <select id="filter-assigned-to">
            <option value="ALL">All Sales</option>
            <option value="" disabled>--------------</option>
            <?php
            if ($business != 'ALL') {
                $sql_select_forms_filter_assigned_to = 'SELECT * FROM `forms` WHERE business = "'.$business.'" GROUP BY assigned_to ORDER BY assigned_to ASC';                
            } else {
                $sql_select_forms_filter_assigned_to = 'SELECT * FROM `forms` GROUP BY assigned_to ORDER BY assigned_to ASC';
            }
            $result_select_forms_filter_assigned_to = $conn->query($sql_select_forms_filter_assigned_to);
            while($row_select_forms_filter_assigned_to = $result_select_forms_filter_assigned_to->fetch_assoc()) {
                if ($row_select_forms_filter_assigned_to["assigned_to"] != '') {
                    $sql_select_users = 'SELECT * FROM users WHERE user_name = "'.$row_select_forms_filter_assigned_to["assigned_to"].'" AND FIND_IN_SET("Sales", user_role)';
                    $result_select_users = $conn->query($sql_select_users);

                    if ($result_select_users->num_rows > 0) {
                        if ($assigned_to == 'ALL') {
                            echo '<option value="'.$row_select_forms_filter_assigned_to["assigned_to"].'">'.$row_select_forms_filter_assigned_to["assigned_to"].'</option>';
                        } else {
                            if ($assigned_to == $row_select_forms_filter_assigned_to['assigned_to']) {
                                echo '<option value="'.$row_select_forms_filter_assigned_to["assigned_to"].'" selected>'.$row_select_forms_filter_assigned_to["assigned_to"].'</option>';    
                            } else {
                                echo '<option value="'.$row_select_forms_filter_assigned_to["assigned_to"].'">'.$row_select_forms_filter_assigned_to["assigned_to"].'</option>';
                            }
                        }
                    }
                }
            }
            ?>
        </select>
        <?php
        }
        ?>

        <?php
        if (($page_title == 'Dashboard') OR (($page_title == 'Paid') && in_array('Admin', explode(',', $row_select_user['user_role'])))) {
        ?>
        <select id="filter-processor">
            <option value="ALL">All Processor</option>
            <option value="" disabled>--------------</option>
            <?php
            if ($business != 'ALL') {
                $sql_select_forms_filter_processor = 'SELECT * FROM `forms` WHERE business = "'.$business.'" GROUP BY processor ORDER BY processor ASC';                
            } else {
                $sql_select_forms_filter_processor = 'SELECT * FROM `forms` GROUP BY processor ORDER BY processor ASC';
            }
            $result_select_forms_filter_processor = $conn->query($sql_select_forms_filter_processor);
            while($row_select_forms_filter_processor = $result_select_forms_filter_processor->fetch_assoc()) {
                if ($row_select_forms_filter_processor["processor"] != '') {
                    $sql_select_users = 'SELECT * FROM users WHERE user_name = "'.$row_select_forms_filter_processor["processor"].'" AND FIND_IN_SET("Processor", user_role)';
                    $result_select_users = $conn->query($sql_select_users);

                    if ($result_select_users->num_rows > 0) {
                        if ($processor == 'ALL') {
                            echo '<option value="'.$row_select_forms_filter_processor["processor"].'">'.$row_select_forms_filter_processor["processor"].'</option>';
                        } else {
                            if ($processor == $row_select_forms_filter_processor['processor']) {
                                echo '<option value="'.$row_select_forms_filter_processor["processor"].'" selected>'.$row_select_forms_filter_processor["processor"].'</option>';    
                            } else {
                                echo '<option value="'.$row_select_forms_filter_processor["processor"].'">'.$row_select_forms_filter_processor["processor"].'</option>';
                            }
                        }
                    }
                }
            }
            ?>
        </select>
        <?php
        }
        ?>
    </div>

    <div class="sorting-box">
        <div>
            <span>From</span>
            <select id="filter-from-date">
                <?php
                for ($i = 1; $i < 32; $i++) {
                    if ($i == $filter_from_date) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    } else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                ?>
            </select>
            <select id="filter-from-month">
                <?php
                for ($i = 1; $i < 13; $i++) {
                    if ($i == $filter_from_month) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    } else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                ?>
            </select>
            <select id="filter-from-year">
                <?php
                for ($i = 2020; $i > 1919; $i--) {
                    if ($i == $filter_from_year) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    } else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div>
            <span>To</span>
            <select id="filter-to-date">
                <?php
                for ($i = 1; $i < 32; $i++) {
                    if ($i == $filter_to_date) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    } else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                ?>
            </select>
            <select id="filter-to-month">
                <?php
                for ($i = 1; $i < 13; $i++) {
                    if ($i == $filter_to_month) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    } else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                ?>
            </select>
            <select id="filter-to-year">
                <?php
                for ($i = 2020; $i > 1919; $i--) {
                    if ($i == $filter_to_year) {
                        echo '<option value="'.$i.'" selected>'.$i.'</option>';
                    } else {
                        echo '<option value="'.$i.'">'.$i.'</option>';
                    }
                }
                ?>
            </select>
        </div>

        <div>
            <span>Order By</span>
            <select id="filter-order-by">
            <?php
                if ($order_by == 'Latest') {
                    ?>
                    <option value="Latest" selected>Latest</option>
                    <option value="Oldest">Oldest</option>
                    <?php
                } else {
                    ?>
                    <option value="Latest">Latest</option>
                    <option value="Oldest" selected>Oldest</option>
                    <?php
                }
            ?>
            </select>
        </div>

        <div class="filter-button">
            <span onclick="filterParam()">Filter</span>
        </div>
    </div>
</div>