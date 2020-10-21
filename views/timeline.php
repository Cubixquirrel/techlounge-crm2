<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include_once('../config/db.php');
include_once('../classes/login-status.php');

include('../json/website-data.php');

date_default_timezone_set('Asia/Kolkata');
$today = date('d-m-Y');

$page_title = 'Timeline';

// Select CRM Form
$sql_select_forms = "SELECT * FROM forms WHERE id = '".$_GET['clientId']."'";
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->fetch_assoc();

$form_id_array  = array_reverse(preg_split("/\,/", $row_select_forms["form_id"]));
$business_array = array_reverse(preg_split("/\,/", $row_select_forms["business_array"]));
$website_array  = array_reverse(preg_split("/\,/", $row_select_forms["website_array"]));
$amount_array   = array_reverse(preg_split("/\,/", $row_select_forms["amount_array"]));

for ($i = 0; $i < count($form_id_array); $i++) {
  $return_form[$i] = '';

  // Collect CRM Form Data
  $form_id            = $form_id_array[$i];
  $sql_business       = $business_array[$i];
  $sql_website_name   = $website_array[$i];
  $sql_amount         = $amount_array[$i];

  // Find Website Connection Data
  if ($form_id != '-') {
    $find_website_data = array($website_data)[0][$sql_website_name];

    // Name Connection Data
    $hostname = array($website_data)[0][$sql_website_name]['hostname'];
    $username = array($website_data)[0][$sql_website_name]['username'];
    $password = array($website_data)[0][$sql_website_name]['password'];
    $database = array($website_data)[0][$sql_website_name]['database'];
  
    if ($sql_amount == 'ENQUIRY') {
        $table = array($website_data)[0][$sql_website_name]['table']['ENQUIRY'];
    } else {
        $table = array($website_data)[0][$sql_website_name]['table'][$sql_business];
    }

    // Connect To Remote Database
    $remote_conn = new mysqli($hostname, $username, $password, $database);
    if ($remote_conn->connect_error) {
        die("Connection failed: " . $remote_conn->connect_error);
    }

    // On Successful Connection
    // Collect Form Data
    $select_form = "SELECT * FROM $table WHERE id = '$form_id'";
    $result_select_form = $remote_conn->query($select_form);
    $row_select_form = $result_select_form->fetch_assoc();

    if ($sql_amount == 'ENQUIRY') {
        $return_form[$i] .= "Form Name = Enquiry Form <br> Website = ".$sql_website_name;
    } else {
        $return_form[$i] .= "Form Name = ".$row_select_form['form_name']." <br> Website = ".$sql_website_name;
    }
  }
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
    <link rel="stylesheet" href="../assets/css/timeline.css">
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

    <?php include_once('../components/timeline.php'); ?>

    <script src="../assets/js/logout.js"></script>
    <script src="../assets/js/main.js"></script>
    <script src="../assets/js/sidebar.js"></script>
</body>
</html>