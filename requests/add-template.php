<?php
include_once('../config/db.php');

$sql_select_users_team = 'SELECT * FROM users_team WHERE id = "'.$_POST["businessId"].'"';
$result_select_users_team = $conn->query($sql_select_users_team);
if ($result_select_users_team->num_rows > 0) {
    $row_select_users_team = $result_select_users_team->fetch_assoc();
    $business = $row_select_users_team['team'];

    $sql_select_email_processor = 'SELECT * FROM email_processor WHERE business_name = "'.$business.'" AND template_name = "'.$_POST["templateName"].'"';
    $result_select_email_processor = $conn->query($sql_select_email_processor);
    if ($result_select_email_processor->num_rows > 0) {
        $row_select_email_processor = $result_select_email_processor->fetch_assoc();
        echo 'Template Name Already Existed';
        exit;
    }
}

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
    $sql_insert_email_processor = 
    '
    INSERT INTO email_processor (
        template_name, business_name, business_stage
    ) VALUES (
        "'.$_POST["templateName"].'", "'.$business.'", "'.$value.'"
    )
    ';
    $result_insert_email_processor = $conn->query($sql_insert_email_processor);

    $file_name = str_replace(' ', '-', strtolower($_POST['templateName'])) . '.php';
    $file_location = '../template/email/' . $file_name;
    $template_file = file_put_contents($file_location, '');
    $template_file = file_put_contents($file_location, $template_message.PHP_EOL, FILE_APPEND | LOCK_EX);
}

if ($result_insert_email_processor) {
    echo 'Template Added';
}

?>