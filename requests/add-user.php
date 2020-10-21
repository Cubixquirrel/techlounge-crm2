<?php
include_once('../config/db.php');

$sql_select_users = 'SELECT * FROM users WHERE user_name = "'.$_POST["userName"].'"';
$result_select_users = $conn->query($sql_select_users);
if ($result_select_users->num_rows > 0) {
    echo 'Name Already Existed';
    exit;
}

$sql_select_users = 'SELECT * FROM users WHERE user_email = "'.$_POST["userEmail"].'"';
$result_select_users = $conn->query($sql_select_users);
if ($result_select_users->num_rows > 0) {
    echo 'Email Already Existed';
    exit;
}

$hashed_password = password_hash($_POST["userPassword"], PASSWORD_DEFAULT);

$sql_insert_users = 
'
INSERT INTO users (
    user_name, user_email, user_password_hash, user_password, 
    user_role, user_team, user_web, 
    user_status, is_hold, last_login, last_logout
) VALUES (
    "'.ucwords($_POST["userName"]).'", "'.strtolower($_POST["userEmail"]).'", "'.$hashed_password.'", "'.$_POST["userPassword"].'", 
    "'.$_POST["roleId"].'", "'.$_POST["teamId"].'", "'.urlencode(strtoupper($_POST["userWebsite"])).'", 
    "false", "false", "01-01-2020 00:00:01", "01-01-2020 00:00:01"
)
';
echo $sql_insert_users;
$result_insert_users = $conn->query($sql_insert_users);

if ($result_insert_users) {
    echo 'User Inserted';
}

?>