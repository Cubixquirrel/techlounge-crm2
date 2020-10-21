<?php
$pay_vendor = $_GET['payVendor'];
$pay_status = $_GET['payStatus'];

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
        <select id="filter-pay-vendor">
            <option value="ALL">All Payment Gateway</option>
            <option value="" disabled>--------------</option>
            <?php
            $sql_select_forms_filter_pay_vendor = 'SELECT * FROM `forms` GROUP BY pay_vendor ORDER BY pay_vendor ASC';
            $result_select_forms_filter_pay_vendor = $conn->query($sql_select_forms_filter_pay_vendor);
            while($row_select_forms_filter_pay_vendor = $result_select_forms_filter_pay_vendor->fetch_assoc()) {
                if ($row_select_forms_filter_pay_vendor["pay_vendor"] != '') {
                    if ($pay_vendor == $row_select_forms_filter_pay_vendor['pay_vendor']) {
                        echo '<option value="'.$row_select_forms_filter_pay_vendor["pay_vendor"].'" selected>'.$row_select_forms_filter_pay_vendor["pay_vendor"].'</option>';    
                    } else {
                        echo '<option value="'.$row_select_forms_filter_pay_vendor["pay_vendor"].'">'.$row_select_forms_filter_pay_vendor["pay_vendor"].'</option>';
                    }
                }
            }
            ?>
        </select>

        <select id="filter-pay-status">
            <option value="ALL">All Pay Status</option>
            <option value="" disabled>--------------</option>
            <?php
            $sql_select_forms_filter_pay_status = 'SELECT * FROM `forms` GROUP BY pay_status ORDER BY pay_status ASC';
            $result_select_forms_filter_pay_status = $conn->query($sql_select_forms_filter_pay_status);
            while($row_select_forms_filter_pay_status = $result_select_forms_filter_pay_status->fetch_assoc()) {
                if ($row_select_forms_filter_pay_status["pay_status"] != '') {
                    if ($pay_status == $row_select_forms_filter_pay_status['pay_status']) {
                        echo '<option value="'.$row_select_forms_filter_pay_status["pay_status"].'" selected>'.$row_select_forms_filter_pay_status["pay_status"].'</option>';    
                    } else {
                        echo '<option value="'.$row_select_forms_filter_pay_status["pay_status"].'">'.$row_select_forms_filter_pay_status["pay_status"].'</option>';
                    }
                }
            }
            ?>
        </select>
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