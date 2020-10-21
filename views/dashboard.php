<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache"); 

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$today = date('d-m-Y');

$page_title = 'Dashboard';
if (!isset($_GET['page']) ) {
    header ('location: ../views/dashboard.php?page=1&business=ALL&website=ALL&status=ALL&payVendor=ALL&amount=ALL&sales=ALL&processor=ALL&fromDate=01-01-2020&toDate='.$today.'&orderBy=Latest');
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
    <link rel="stylesheet" href="../assets/css/info-box.css">
    <link rel="stylesheet" href="../assets/css/business-box.css">
    <link rel="stylesheet" href="../assets/css/filter-box.css">
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
        document.querySelector('#master-data-menu').setAttribute('class', 'sidebar-list active');
    </script>

    <?php
    include_once('../components/info-box.php');
    include_once('../components/business-box.php');
    include_once('../components/filter-box.php');
    include_once('../components-table/master-data.php');
    ?>

    <div class="schedule-call-popup"></div>

    <script src="../assets/js/logout.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/sidebar.js"></script>
    <script src="../assets/js/info-box.js"></script>
    <script src="../assets/js/business-box.js"></script>
    <script src="../assets/js/filter-box.js"></script>
    <script src="../assets/js/data-table.js"></script>
    <script src="../assets/js/call-alert.js"></script>

    <?php include_once('../classes/pagination.php'); ?>
</body>
</html>