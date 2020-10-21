<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$today = date('d-m-Y');

$page_title = 'Analytics';
if (!isset($_GET['page']) ) {
    header ('location: ../views/analytics.php?page=1&website=ALL&status=ALL&fromDate=01-01-2020&toDate='.$today.'&orderBy=Latest');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/filter-analytics-box.css">
    <link rel="stylesheet" href="../assets/css/data-table.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fonts/style.css">
</head>
<body>
    <div class="loader">
        <div class="spinner-border">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    <?php include_once('../classes/database-count.php'); ?>
    <?php include_once('../components/sidebar.php'); ?>
    <script>
        document.querySelector('#analytics-data-menu').setAttribute('class', 'sidebar-list active');
    </script>

    <?php
    include_once('../components/filter-analytics-box.php');
    include_once('../components-table/analytics-data.php');
    ?>

    <script src="../assets/js/logout.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/sidebar.js"></script>
    <script src="../assets/js/filter-analytics-box.js"></script>
    <script src="../assets/js/data-table.js"></script>

    <?php include_once('../classes/pagination-analytics.php'); ?>
</body>
</html>