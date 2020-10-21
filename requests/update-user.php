<?php
include_once('../config/db.php');

$hashed_password = password_hash($_POST["userPassword"], PASSWORD_DEFAULT);

$sql_update_users = 
'
UPDATE users SET user_name = "'.ucwords($_POST["userName"]).'", user_email = "'.strtolower($_POST["userEmail"]).'", 
user_password_hash = "'.$hashed_password.'", user_password = "'.$_POST["userPassword"].'", 
user_role = "'.$_POST["roleId"].'", user_team = "'.$_POST["teamId"].'", user_web = "'.urlencode($_POST["userWebsite"]).'" 
WHERE user_id = "'.$_POST["userId"].'"
';
$result_update_users = $conn->query($sql_update_users);

if ($result_update_users) {
    echo 'User Updated';
}

?>