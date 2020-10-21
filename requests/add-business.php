<?php
include_once('../config/db.php');

$sql_select_users_team = 'SELECT * FROM users_team WHERE team = "'.$_POST["businessName"].'"';
$result_select_users_team = $conn->query($sql_select_users_team);
if ($result_select_users_team->num_rows > 0) {
    echo 'Business Already Existed';
    exit;
}

$sql_insert_users_team = 
'
INSERT INTO users_team (
    team
) VALUES (
    "'.strtoupper($_POST["businessName"]).'"
)
';
$result_insert_users_team = $conn->query($sql_insert_users_team);

if ($result_insert_users_team) {
    echo 'Business Inserted';
}

?>