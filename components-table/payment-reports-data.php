<div class="table-main-container">
<?php

if ($_GET['payVendor'] != 'ALL') {
    $payVendor = ' AND pay_vendor = "'.$_GET['payVendor'].'"';
} else {
    $payVendor = '';
}

if ($_GET['payStatus'] != 'ALL') {
    $payStatus = ' AND pay_status = "'.$_GET['payStatus'].'"';
} else {
    $payStatus = '';
}

$betweenDate = ' AND STR_TO_DATE(date, "%d-%m-%Y %T") BETWEEN STR_TO_DATE("'.$_GET["fromDate"].' 00:00:01", "%d-%m-%Y %T") AND STR_TO_DATE("'.$_GET["toDate"].' 23:59:59", "%d-%m-%Y %T") ';

if ($_GET['orderBy'] == 'Latest') {
    $orderBy = ' DESC ';
} else {
    $orderBy = ' ASC ';
}

if (isset($_GET['text'])) {
    $text = $_GET['text'];
    $sql_text = 
    ' AND (
        pay_vendor LIKE "%'.$_GET['text'].'%" OR 
        pay_status LIKE "%'.$_GET['text'].'%" OR 
        payment_id LIKE "%'.$_GET['text'].'%" OR 
        order_id LIKE "%'.$_GET['text'].'%" OR 
        business LIKE "%'.$_GET['text'].'%" OR 
        amount LIKE "%'.$_GET['text'].'%" OR 
        status LIKE "%'.$_GET['text'].'%" OR 
        name LIKE "%'.$_GET['text'].'%" OR 
        mobile LIKE "%'.$_GET['text'].'%" OR 
        date LIKE "%'.$_GET['text'].'%"
    ) ';
} else {
    $text = '';
    $sql_text = '';
}

$sql_select_forms = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $payVendor . $payStatus . $betweenDate . ' AND pay_status != ""';
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->num_rows;
$total_entries = $row_select_forms;

$results_per_page = 10;
$number_of_page = ceil($row_select_forms / $results_per_page);
$page = $_GET['page'];
$page_first_result = ($page - 1) * $results_per_page;

$sql_select_forms = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $payVendor . $payStatus . $betweenDate . ' AND pay_status != "" ORDER BY STR_TO_DATE(date, "%d-%m-%Y %T") '.$orderBy.' LIMIT '.$page_first_result.','.$results_per_page.'';
$result_select_forms = $conn->query($sql_select_forms);

if (isset($_GET['export']) && $_GET['export'] == true) {
    $sql_select_forms_export = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $payVendor . $payStatus . $betweenDate . ' AND pay_status != "" ORDER BY STR_TO_DATE(date, "%d-%m-%Y %T") '.$orderBy.'';
    $exp_table = 'payment-reports';
    $csv  = $exp_table . '-' . $today . '.csv';
    $csv_location = '../export/'. $csv;
    $file = fopen($csv_location, 'w');

    if (!$mysqli_result = mysqli_query($conn, $sql_select_forms_export)) {
        printf("Error: %s\n", $conn->error);
    } else {
        while ($column = mysqli_fetch_field($mysqli_result)) {
            $column_names[] = $column->name;
        }

        if (!fputcsv($file, $column_names)) {
            die('Can\'t write column names in csv file');
        }
        
        while ($row = mysqli_fetch_row($mysqli_result)) {
            if (!fputcsv($file, $row)) {
                die('Can\'t write rows in csv file');
            }
        }
    }
    fclose($file);
} else {
    $csv = '';
}
?>
<div class="table-header">            
    <div class="table-header-right">
        <div class="search-box">
            <input type="text" autocomplete="off" class="input-search-box" placeholder="Search..." value="<?php echo $text; ?>" onkeyup="validateSearch()"/>
            <i class="icon-magnifying-glass search-button" onclick="search()"></i>
        </div>
    </div>

    <div class="table-header-right">
        <div class="total-count-box">Showing <?php echo $total_entries; ?> entries</div>
        <?php        
            $last = $number_of_page;
            $current = $page;
            $first = 1;
            $output = "";
            $show_limit = 5;

            if ($show_limit == $last) {
                for ($i = 1; $i <= $last; $i++) {
                    if(empty($output)) {
                        $output .= "$i";
                    } else {
                        $output .= ",$i";
                    }
                }
                $output = "$output";
            }
            else {
                if ($last < $show_limit) {
                    for ($i = 1; $i <= $last; $i++) {
                        if(empty($output)) {
                            $output .= "$i";
                        } else {
                            $output .= ",$i";
                        }
                    }
                    $output = "$output";
                }
                else if ($current - ceil($show_limit / 2) <= $first) {
                    for ($i = 1; $i <= $show_limit + 1; $i++) {
                        if(empty($output)) {
                            $output .= "$i";
                        } else {
                            $output .= ",$i";
                        }
                    }
                    $output = "$output,..,$last";
                }
                else if ($current + ceil($show_limit / 2) >= $last) {
                    for ($i = 1; $i < $show_limit + 1; $i++) {
                        $output = ",".intval($last - $i).$output;
                    }
                    $output = "1,..".$output.",$last";
                }
                else {
                    $output = "1,..,";
                    $start = $current - floor($show_limit / 2);
                    for ($i = 0; $i < $show_limit; $i++) {
                        $cursor = intval($start + $i);
                        if ($cursor == $last) {
                            break;
                        }
                        $output .= $cursor.",";
                    }
                    $output .= "..,$last";
                }
            }
        ?>
        <div class="pagination-box"><?php echo $output; ?></div>
    </div>
</div>

<?php
if (in_array('Admin', explode(',', $row_select_user['user_role']))) {
?>
<div class="action-main-box">
    <?php
    if ($csv == '') {
        ?>
        <a onclick='exportData("<?php echo $csv; ?>")' id='export' export-data-value='<?php echo $csv; ?>'>Export</a>
        <?php
    } else {
        ?>
        <a href='<?php echo $csv_location; ?>' id='export' export-data-value='<?php echo $csv; ?>'>Export</a>
        <script>
            document.addEventListener("DOMContentLoaded", function(event) {
                document.querySelector('#export').click();

                setTimeout(() => {
                    var url = new URL(window.location.href);
                    var urlSearchParams = url.searchParams;
                    urlSearchParams.delete('export');
                    url.search = urlSearchParams.toString();
                    var newUrl = url.toString();
                    window.history.pushState('', '', newUrl);                 
                }, 1000);
            });
        </script>
        <?php
    }
    ?>
</div>
<?php
}
?>

<?php
if (($result_select_forms->num_rows > 0)) {
    while ($row_select_forms = $result_select_forms->fetch_assoc()) {
        ?>    
        <div class="table flex-table analytics-table" table-data-id="<?php echo $row_select_forms['id']; ?>">
            <div class="table-left">
                <div class="table-first">
                    <div class="first-inner">
                        <span class="date-column"><?php echo $row_select_forms['date']; ?></span>
                        <span class="website-column"><?php echo $row_select_forms['website']; ?></span>
                        <?php if ($row_select_forms['pay_status'] == 'Payment Authorized') {
                            ?><span class="status-column"><?php echo $row_select_forms['pay_status']; ?> <span class="capture-button" id="capture-button-<?php echo $row_select_forms['id']; ?>" onclick="capturePayment('<?php echo $row_select_forms['id']; ?>', '<?php echo $row_select_forms['payment_id']; ?>')">(Capture)</span></span><?php
                        } else {
                            ?><span class="status-column"><?php echo $row_select_forms['pay_status']; ?></span><?php
                        }
                        ?>
                    </div>

                    <div class="first-inner">
                        <span class="business-column"><?php echo $row_select_forms['business']; ?></span>
                        <span class="amount-column"><?php echo $row_select_forms['amount']; ?></span>
                    </div>
                </div>

                <div class="table-third">
                    <div class="third-inner">
                        <span>
                            <span class="client-name-column">Name: <?php echo $row_select_forms['name']; ?></span>
                            <span class="client-mobile-column">Mobile: <?php echo $row_select_forms['mobile']; ?></span>
                            <span class="client-email-column">Email: <?php echo $row_select_forms['email']; ?></span>
                        </span>

                        <span class="payment-detail">
                            <span class="client-name-column">Merchant: <?php echo $row_select_forms['pay_vendor']; ?></span>
                            <span class="client-mobile-column">Payment Id: <?php echo $row_select_forms['payment_id']; ?></span>
                            <span class="client-email-column">Order Id: <?php echo $row_select_forms['order_id']; ?></span>
                        </span>
                    </div>
                </div>
            </div>            
        </div>
        <?php
    }
} else {
    ?>
    <span class="empty-table-box">No data found.</span>
    <?php
}
?>
<div class="table-header bottom">
    <div class="table-header-right">
    </div>

    <div class="table-header-right">
        <div class="total-count-box">Showing <?php echo $total_entries; ?> entries</div>
    
        <div class="pagination-box bottom"></div>
    </div>
</div>

</div>