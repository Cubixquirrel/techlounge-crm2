<?php
include_once('../config/db.php');

date_default_timezone_set('Asia/Kolkata');
$form_created_on = date('d-m-Y H:i:s');
$form_created_on_date = date('d-m-Y');
$form_created_on_time = date('H:i:s');

if ((isset($_GET['printGid']) && $_GET['printGid'] != '')) {
    $print_gid = $_GET['printGid'];

    $sql_select_print_gid = 'SELECT * FROM print_gid WHERE print_gid = "'.$print_gid.'"';
    $result_select_print_gid = $conn->query($sql_select_print_gid);

    if ($result_select_print_gid->num_rows == 1) {
        $row_select_print_gid = $result_select_print_gid->fetch_assoc();
        $client_id = $row_select_print_gid['client_id'];

        $sql_update_print_gid = 'UPDATE forms SET stage = "Certificate Delivered", delivered_on = "'.$form_created_on.'" WHERE id = "'.$client_id.'"';
        $result_update_print_gid = $conn->query($sql_update_print_gid);

        $sql_select_forms = 'SELECT * FROM forms WHERE id = "'.$client_id.'"';
        $result_select_forms = $conn->query($sql_select_forms);
        $row_select_forms = $result_select_forms->fetch_assoc();
        $processor = $row_select_forms['processor'];
        $client_name = ucwords($row_select_forms['name']);

        $sql ="
        INSERT INTO timeline (
        meta_id,
        meta_name,
        meta_description,
        meta_user,
        form_created_on,
        form_created_time
        )

        VALUES (
        '".$client_id."',
        'stage',
        'Certificate Delivered__%__Marked by client',
        '***',
        '$form_created_on_date',
        '$form_created_on_time'
        )";

        if(!$result = $conn->query($sql)){
            die('There was an error running the query [' . $conn->error . ']');
        }
        else
        {
            echo 'Successfully Marked';
        }
    }
}
?>