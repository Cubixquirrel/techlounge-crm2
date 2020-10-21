<?php
$business = $_GET['business'];
$website = $_GET['website'];

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
                $sql_select_forms_filter_website = 'SELECT * FROM `complaint_forms` WHERE business = "'.$business.'" GROUP BY website ORDER BY website ASC';                
            } else {
                $sql_select_forms_filter_website = 'SELECT * FROM `complaint_forms` GROUP BY website ORDER BY website ASC';
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