<?php
include_once('../config/db.php');

$link = $_GET['link'];

$sql_select_link = 'SELECT * FROM edit_form_link WHERE full_link = "'.$link.'"';
$result_select_link = $conn->query($sql_select_link);
$row_select_link = $result_select_link->fetch_assoc();
$client_id = $row_select_link['panel_form_id'];
$form_id = $row_select_link['form_id'];

if ($result_select_link->num_rows > 0) {    
    $sql_update_form = 'UPDATE forms SET is_updated = "true" WHERE id = "'.$client_id.'"';
    $result_update_form = $conn->query($sql_update_form);

    echo 'Form Updated.';
}
?>