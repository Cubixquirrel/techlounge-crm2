<?php
include_once('../config/db.php');

$sql_select_email_processor = 'SELECT * FROM email_processor WHERE id = "'.$_POST["templateId"].'"';
$result_select_email_processor = $conn->query($sql_select_email_processor);
$row_select_email_processor = $result_select_email_processor->fetch_assoc();

$template_message = 
'<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"'.$_POST["templateName"].'" => [
"subject" => "'.$_POST["templateSubject"].'",
"message" => 
"'.$_POST["templateMessage"].'
"
]
];

$type = $_GET["type"];

$subject = array($processor_email)[0][$type]["subject"];
$message = array($processor_email)[0][$type]["message"];

echo json_encode(array($subject, $message));

?>';

foreach (explode(',', $_POST['stageId']) as $key => $value) {
    $sql_update_email_processor = 
    '
    UPDATE email_processor SET 
    template_name = "'.$_POST["templateName"].'", business_stage = "'.$value.'" 
    WHERE id = "'.$_POST["templateId"].'"
    ';
    $result_update_email_processor = $conn->query($sql_update_email_processor);

    $file_name = str_replace(' ', '-', strtolower($_POST['templateName'])) . '.php';
    $file_location = '../template/email/' . $file_name;
    $template_file = file_put_contents($file_location, '');
    $template_file = file_put_contents($file_location, $template_message.PHP_EOL, FILE_APPEND | LOCK_EX);
}

echo 'Template Updated';

?>