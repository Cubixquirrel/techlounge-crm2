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

if (isset($_GET['stage'])) {
    $stage = ' AND stage = "'.$_GET['stage'].'"';
} else {
    $stage = '';
}

$betweenDate = ' AND STR_TO_DATE(form_created_on, "%d-%m-%Y %T") BETWEEN STR_TO_DATE("'.$_GET["fromDate"].' 00:00:01", "%d-%m-%Y %T") AND STR_TO_DATE("'.$_GET["toDate"].' 23:59:59", "%d-%m-%Y %T") ';

if ($_GET['orderBy'] == 'Latest') {
    $orderBy = ' DESC ';
} else {
    $orderBy = ' ASC ';
}

if (isset($_GET['text'])) {
    $text = $_GET['text'];
    $sql_text = 
    ' AND (
        business LIKE "%'.$_GET['text'].'%" OR 
        complaint_id LIKE "%'.$_GET['text'].'%" OR 
        form_name LIKE "%'.$_GET['text'].'%" OR 
        applicant_name LIKE "%'.$_GET['text'].'%" OR 
        mobile_number LIKE "%'.$_GET['text'].'%" OR 
        email_id LIKE "%'.$_GET['text'].'%" OR 
        docs LIKE "%'.$_GET['text'].'%" OR 
        order_id LIKE "%'.$_GET['text'].'%" OR 
        transaction_date LIKE "%'.$_GET['text'].'%" OR 
        transaction_amount LIKE "%'.$_GET['text'].'%" OR 
        complaint_details LIKE "%'.$_GET['text'].'%" OR 
        website LIKE "%'.$_GET['text'].'%" OR 
        status LIKE "%'.$_GET['text'].'%" OR 
        stage LIKE "%'.$_GET['text'].'%" OR 
        form_created_on LIKE "%'.$_GET['text'].'%"
    ) ';
} else {
    $text = '';
    $sql_text = '';
}

$sql_select_forms = 'SELECT * FROM complaint_forms WHERE id != "" ' . $sql_text . $business . $website . $betweenDate . $stage . '';
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->num_rows;
$total_entries = $row_select_forms;

$results_per_page = 10;
$number_of_page = ceil($row_select_forms / $results_per_page);
$page = $_GET['page'];
$page_first_result = ($page - 1) * $results_per_page;

$sql_select_forms = 'SELECT * FROM complaint_forms WHERE id != "" ' . $sql_text . $business . $website . $betweenDate . $stage . ' ORDER BY STR_TO_DATE(form_created_on, "%d-%m-%Y %T") '.$orderBy.' LIMIT '.$page_first_result.','.$results_per_page.'';
$result_select_forms = $conn->query($sql_select_forms);

if (isset($_GET['export']) && $_GET['export'] == true) {
    $sql_select_forms_export = 'SELECT * FROM complaint_forms WHERE id != "" ' . $sql_text . $business . $website . $betweenDate . $stage . ' ORDER BY STR_TO_DATE(form_created_on, "%d-%m-%Y %T") '.$orderBy.'';
    $exp_table = 'complaint';
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
    <select id="mark-to-sales" onchange="markData('mark-to-sales', 'Sales')">
        <option>Mark to Complaint</option>
        <option disabled>--------------</option>
        <?php
        $sql_select_users = 'SELECT * FROM users WHERE FIND_IN_SET("Complaint", user_role)';
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
</div>
<?php
}
?>

<?php
if (($result_select_forms->num_rows > 0)) {
    while ($row_select_forms = $result_select_forms->fetch_assoc()) {
        if (($row_select_forms['stage'] == '0')) {
            $location = 'New Created';
        } else if (($row_select_forms['stage'] == '1')) {
            $location = 'Updated by Us';
        } else if (($row_select_forms['stage'] == '2')) {
            $location = 'Updated by Client';
        } else if (($row_select_forms['stage'] == '3')) {
            $location = 'Closed';
        }
        ?>    
        <div class="table" table-data-id="<?php echo $row_select_forms['id']; ?>" onclick="selectTableDataId('<?php echo $row_select_forms['id']; ?>')">
            <div class="table-first">
                <div class="first-inner">
                    <span class="date-column"><?php echo $row_select_forms['form_created_on']; ?></span>
                    <span class="website-column"><?php echo $row_select_forms['website']; ?></span>
                </div>

                <div class="first-inner">
                    <span class="business-column"><?php echo $row_select_forms['business']; ?></span>
                </div>
            </div>

            <div class="table-second">
                <div class="second-inner">
                    <span>Complaint Id: <span class="location-column"><?php echo $row_select_forms['complaint_id']; ?></span></span>
                    <span>Last Status: <span class="location-column"><?php echo $location; ?></span></span>
                </div>
                
                <div class="second-inner">
                    <span>Complaint: <span class="processing-user-column"><?php echo $row_select_forms['assigned_to']; ?></span></span>
                </div>
            </div>

            <div class="table-third">
                <div class="third-inner">
                    <span>
                        <span class="client-name-column">Name: <?php echo $row_select_forms['applicant_name']; ?></span>
                        <span class="client-mobile-column">Mobile: <?php echo $row_select_forms['mobile_number']; ?></span>
                        <span class="client-email-column">Email: <?php echo $row_select_forms['email_id']; ?></span>
                        <span class="client-email-column">Aadhaar / PAN Number: <?php echo $row_select_forms['docs']; ?></span>
                    </span>

                    <span class="payment-detail">
                        <span class="client-name-column">Order Id: <?php echo $row_select_forms['order_id']; ?></span>
                        <span class="client-mobile-column">Transaction Date: <?php echo $row_select_forms['transaction_date']; ?></span>
                        <span class="client-email-column">Transaction Amount: <?php echo $row_select_forms['transaction_amount']; ?></span>
                    </span>

                    <div class="action-column">
                        <span class="timeline-column" onclick="viewComplaintTimeline('<?php echo $row_select_forms['id']; ?>')"><i class="icon-schedule"></i></span>
                    </div>
                </div>                
            </div>
        </div>
        <?php
    }
} else {
    ?>
    <span class="empty-table-box">No complaint found.</span>
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