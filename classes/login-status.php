<?php

date_default_timezone_set('Asia/Kolkata');
$current_time = date('d-m-Y H:i:s');

if (isset($_COOKIE['user_status']) && $_COOKIE['user_status'] == 'true') {
    $sql_select_users_login = 'SELECT user_id FROM users_login WHERE user_auth = "'.$_COOKIE["user_auth"].'"';
    $result_select_users_login = $conn->query($sql_select_users_login);
    
    if ($result_select_users_login->num_rows === 1) {
        $row_select_users_login = $result_select_users_login->fetch_assoc();

        $sql_select_user = 'SELECT * FROM users WHERE user_id = "'.$row_select_users_login["user_id"].'" AND is_hold != "true"';
        $result_select_user = $conn->query($sql_select_user);

        if ($result_select_user->num_rows === 1) {
            $row_select_user = $result_select_user->fetch_assoc();

            $user_id = $row_select_user['user_id'];
            $user_name = $row_select_user['user_name'];
            $user_team = $row_select_user['user_team'];
            $user_web = $row_select_user['user_web'];
        } else {
            setcookie('user_auth', '', time() + (10 * 365 * 24 *60 * 60), '/');
            setcookie('user_status', '', time() + (10 * 365 * 24 *60 * 60), '/');

            $sql_update_user = "UPDATE users SET user_status = 'false', last_logout = '".$current_time."' WHERE user_id = '".$row_select_users_login['user_id']."'";
            $result_update_user = $conn->query($sql_update_user);
        }
    } else {
        header ('location: ../index.php');
    }
} else {
    header ('location: ../index.php');
}

?>