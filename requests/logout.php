<?php

include_once('../config/db.php');
include_once('../classes/login-status.php');

date_default_timezone_set('Asia/Kolkata');
$current_time = date('d-m-Y H:i:s');

setcookie('user_auth', '', time() + (10 * 365 * 24 *60 * 60), '/');
setcookie('user_status', '', time() + (10 * 365 * 24 *60 * 60), '/');

$sql_update_user = "UPDATE users SET user_status = 'false', last_logout = '".$current_time."' WHERE user_id = '".$user_id."'";
$result_update_user = $conn->query($sql_update_user);

?>