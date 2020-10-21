<?php
include_once('../config/db.php');

$sql_select_email_processor = 'SELECT * FROM email_processor WHERE id = "'.$_POST["templateId"].'"';
$result_select_email_processor = $conn->query($sql_select_email_processor);
if ($result_select_email_processor->num_rows > 0) {
    $sql_delete_email_processor = 'DELETE FROM email_processor WHERE id = "'.$_POST["templateId"].'"';
    $result_delete_email_processor = $conn->query($sql_delete_email_processor);

    if ($result_delete_email_processor) {
        echo 'Deleted successfully';
    }
}

?>