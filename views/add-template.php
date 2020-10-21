<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$today = date('d-m-Y');

if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) {
    $page_title = 'Add Template';
    if (isset($_GET['businessId']) && $_GET['businessId'] != '') {
        $sql_select_users_team = 'SELECT * FROM users_team WHERE id = "'.$_GET["businessId"].'"';
        $result_select_users_team = $conn->query($sql_select_users_team);
        if ($result_select_users_team->num_rows > 0) {
            $row_select_users_team = $result_select_users_team->fetch_assoc();
            $business = $row_select_users_team['team'];

            $sql_select_business = 'SELECT * FROM business WHERE business_name = "'.$business.'" ORDER BY stage_order + 0 ASC';
            $result_select_business = $conn->query($sql_select_business);
        } else {
            header ('location: ../views/businesses.php');
        }
    } else {
        header ('location: ../views/businesses.php');
    }
} else {
    header ('location: ../index.php');
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $business; ?> Template</title>
    <link rel="stylesheet" href="../assets/css/main.css">
    <link rel="stylesheet" href="../assets/css/sidebar.css">
    <link rel="stylesheet" href="../assets/css/add-template.css">
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
        document.querySelector('#businesses-data-menu').setAttribute('class', 'sidebar-list active');
    </script>

    <?php
    include_once('../components/add-template.php');
    ?>

    <script src="../assets/js/logout.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/sidebar.js"></script>
    <script src="../assets/js/add-template.js"></script>
</body>
</html>