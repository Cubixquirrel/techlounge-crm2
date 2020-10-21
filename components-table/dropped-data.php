<div class="table-main-container">
<?php

if ($_GET['business'] != 'ALL') {
    $business = ' AND business = "'.$_GET['business'].'"';
} else {
    $business = '';
}

if ($_GET['website'] != 'ALL') {
    $website = ' AND website = "'.$_GET['website'].'"';
} else {
    $website = '';
}

if ($_GET['status'] != 'ALL') {
    $status = ' AND status = "'.$_GET['status'].'"';
} else {
    $status = '';
}

if ($_GET['payVendor'] != 'ALL') {
    $payVendor = ' AND pay_vendor = "'.$_GET['payVendor'].'"';
} else {
    $payVendor = '';
}

if ($_GET['amount'] != 'ALL') {
    $amount = ' AND amount = "'.$_GET['amount'].'"';
} else {
    $amount = '';
}

if ($_GET['sales'] != 'ALL') {
    $sales = ' AND assigned_to = "'.$_GET['sales'].'"';
} else {
    $sales = '';
}

if ($_GET['processor'] != 'ALL') {
    $processor = ' AND processor = "'.$_GET['processor'].'"';
} else {
    $processor = '';
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
        payment_id LIKE "%'.$_GET['text'].'%" OR 
        order_id LIKE "%'.$_GET['text'].'%" OR 
        business LIKE "%'.$_GET['text'].'%" OR 
        amount LIKE "%'.$_GET['text'].'%" OR 
        status LIKE "%'.$_GET['text'].'%" OR 
        name LIKE "%'.$_GET['text'].'%" OR 
        mobile LIKE "%'.$_GET['text'].'%" OR 
        email LIKE "%'.$_GET['text'].'%" OR 
        assigned_to LIKE "%'.$_GET['text'].'%" OR 
        processor LIKE "%'.$_GET['text'].'%" OR 
        stage LIKE "%'.$_GET['text'].'%" OR 
        delivered_on LIKE "%'.$_GET['text'].'%" OR 
        remarks LIKE "%'.$_GET['text'].'%" OR 
        date LIKE "%'.$_GET['text'].'%"
    ) ';
} else {
    $text = '';
    $sql_text = '';
}

if (in_array('Admin', explode(',', $row_select_user['user_role']))) {
    $sql_select_forms = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $business . $website . $status . $payVendor . $amount . $sales . $processor . $betweenDate . ' AND dropped = "true" AND status != "Paid"';
} else {
    $sql_select_forms = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $business . $website . $status . $payVendor . $amount . $sales . $processor . $betweenDate . ' AND dropped = "true" AND status != "Paid" AND assigned_to = "'.$user_name.'"';
}
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->num_rows;
$total_entries = $row_select_forms;

$results_per_page = 10;
$number_of_page = ceil($row_select_forms / $results_per_page);
$page = $_GET['page'];
$page_first_result = ($page - 1) * $results_per_page;

if (in_array('Admin', explode(',', $row_select_user['user_role']))) {
    $sql_select_forms = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $business . $website . $status . $payVendor . $amount . $sales . $processor . $betweenDate . ' AND dropped = "true" AND status != "Paid" ORDER BY STR_TO_DATE(date, "%d-%m-%Y %T") '.$orderBy.' LIMIT '.$page_first_result.','.$results_per_page.'';
} else {
    $sql_select_forms = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $business . $website . $status . $payVendor . $amount . $sales . $processor . $betweenDate . ' AND dropped = "true" AND status != "Paid" AND assigned_to = "'.$user_name.'" ORDER BY STR_TO_DATE(date, "%d-%m-%Y %T") '.$orderBy.' LIMIT '.$page_first_result.','.$results_per_page.'';
}
$result_select_forms = $conn->query($sql_select_forms);

if (isset($_GET['export']) && $_GET['export'] == true) {
    if (in_array('Admin', explode(',', $row_select_user['user_role']))) {
        $sql_select_forms_export = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $business . $website . $status . $payVendor . $amount . $sales . $processor . $betweenDate . ' AND dropped = "true" AND status != "Paid" ORDER BY STR_TO_DATE(date, "%d-%m-%Y %T") '.$orderBy.'';
    } else {
        $sql_select_forms_export = 'SELECT * FROM forms WHERE id != "" ' . $sql_text . $business . $website . $status . $payVendor . $amount . $sales . $processor . $betweenDate . ' AND dropped = "true" AND status != "Paid" AND assigned_to = "'.$user_name.'" ORDER BY STR_TO_DATE(date, "%d-%m-%Y %T") '.$orderBy.'';
    }
    $exp_table = 'dropped';
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

<div class="action-main-box">
    <?php
    if (in_array('Admin', explode(',', $row_select_user['user_role']))) {
    ?>
    <select id="mark-to-sales" onchange="markData('mark-to-sales', 'Sales')">
        <option>Mark to Sales</option>
        <option disabled>--------------</option>
        <?php
        $sql_select_users = 'SELECT * FROM users WHERE FIND_IN_SET("Sales", user_role) ORDER BY user_name ASC';
        $result_select_users = $conn->query($sql_select_users);
        if ($result_select_users->num_rows > 0) {
            while ($row_select_users = $result_select_users->fetch_assoc()) {
                echo '<option value="'.$row_select_users["user_name"].'">'.$row_select_users["user_name"].'</option>';
            }
        }
        ?>
    </select>

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
    <?php
    }
    ?>

    <span id="restore" onclick="restoreData()">Restore</span>
</div>

<?php
if (($result_select_forms->num_rows > 0)) {
    while ($row_select_forms = $result_select_forms->fetch_assoc()) {
        $sql_select_ip = "SELECT * FROM track_ip WHERE user_id = '".$row_select_forms['id']."'";
        $result_select_ip = $conn->query($sql_select_ip);
        $row_select_ip = $result_select_ip->fetch_assoc();

        if ($row_select_ip['status'] == 'true') {
            $signal = 'status red';
        } else {
            $signal = 'status green';
        }

        if (($row_select_forms['dropped'] != 'true') && ($row_select_forms['status'] != 'Paid') && ($row_select_forms['is_follow_up'] != 'true')) {
            $location = 'In Lead';
        } else if (($row_select_forms['dropped'] != 'true') && ($row_select_forms['status'] != 'Paid') && ($row_select_forms['is_follow_up'] = 'true')) {
            $location = 'In Follow Up';
        } else if (($row_select_forms['dropped'] = 'true') && ($row_select_forms['status'] != 'Paid')) {
            $location = 'In Dropped';
        } else if (($row_select_forms['status'] = 'Paid')) {
            $location = 'In Paid';
        }
        ?>    
        <div class="table flex-table" table-data-id="<?php echo $row_select_forms['id']; ?>" onclick="selectTableDataId('<?php echo $row_select_forms['id']; ?>')">
            <div class="table-left">
                <div class="table-first">
                    <div class="first-inner">
                        <span class="date-column"><?php echo $row_select_forms['date']; ?></span>
                        <span class="website-column"><?php echo $row_select_forms['website']; ?></span>
                        <span class="status-column"><?php echo $row_select_forms['status']; ?></span>
                    </div>

                    <div class="first-inner">
                        <span class="business-column"><?php echo $row_select_forms['business']; ?></span>
                        <span class="amount-column"><?php echo $row_select_forms['amount']; ?></span>
                    </div>
                </div>

                <div class="table-second">
                    <?php
                    if ($row_select_forms['processor'] == '') {
                        ?>
                        <div class="second-inner">                        
                            <span>Location: <span class="location-column"><?php echo $location; ?></span>
                        </div>

                        <div class="second-inner">
                            <span>Sales: <span class="sales-user-column"><?php echo $row_select_forms['assigned_to']; ?></span></span>
                        </div>
                        <?php
                    } else {
                        ?>
                        <div class="second-inner">                        
                            <span><span class="processing-status-column"><?php echo $row_select_forms['stage']; ?></span></span>
                            <?php
                            if ($row_select_forms['stage'] == 'Certificate Delivered') {
                                ?>
                                <span>Delivered On: <span class="processing-delivered-column"><?php echo $row_select_forms['delivered_on']; ?></span></span>
                                <?php
                            }
                            if (($row_select_forms['stage'] != 'Pending') && ($row_select_forms['stage'] != 'Certificate Delivered')) {
                                ?>
                                <span>Marked On: <span class="processing-delivered-column"><?php echo $row_select_forms['delivered_on']; ?></span></span>
                                <?php
                            }
                            ?>
                            <span>Location: <span class="location-column"><?php echo $location; ?></span>
                        </div>
                        
                        <div class="second-inner">
                            <span>Processing: <span class="processing-user-column"><?php echo $row_select_forms['processor']; ?></span></span>
                            <span>Sales: <span class="sales-user-column"><?php echo $row_select_forms['assigned_to']; ?></span></span>
                        </div>
                        <?php
                    }
                    ?>
                </div>

                <div class="table-third">
                    <div class="third-inner">
                        <span>
                            <span class="client-name-column">Name: <?php echo $row_select_forms['name']; ?></span>
                            <span class="client-mobile-column">Mobile: <?php echo $row_select_forms['mobile']; ?></span>
                            <span class="client-email-column">Email: <?php echo $row_select_forms['email']; ?></span>
                        </span>

                        <div class="action-column">
                            <span class="timeline-column" onclick="viewTimeline('<?php echo $row_select_forms['id']; ?>')"><i class="icon-schedule"></i></span>
                            <span onclick="displayForm('<?php echo $row_select_forms['id']; ?>')" data-selected="false" class="process-button view-form-column" id="process-button-<?php echo $row_select_forms['id']; ?>">View Form</span>
                            <div class="view-form-box-main"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="table-right">
                <div class="third-inner">
                    <?php
                    if ($row_select_forms['schedule_date'] != '') {
                        ?>
                        <div class="schedule-inner">
                            <span class="schedule-label">Schedule Date:</span>
                            <span class="schedule-column"><?php echo $row_select_forms['schedule_date']; ?></span>
                        </div>
                        <?php
                    }
                    ?>

                    <div class="remarks-inner">
                        <span class="remarks-label">Remarks:</span>
                        <div>
                            <?php
                            $remarks = explode('__%__', $row_select_forms['remarks']);
                            if ($row_select_forms['remarks'] != '') {
                                foreach (array_reverse($remarks) as $single_remarks) {
                                    ?>
                                    <span class="remarks-column"><?php echo $single_remarks; ?></span>
                                    <?php
                                }
                            } else {
                                ?>
                                <span class="remarks-column">No remarks.</span>
                                <?php
                            }
                            ?>
                        </div>
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