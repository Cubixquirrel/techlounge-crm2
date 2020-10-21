<?php

include_once('../config/db.php');

date_default_timezone_set('Asia/Kolkata');
$current_time = date('d-m-Y H:i:s');

function generateToken($length = 7) {
    $chars = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $token = '';
    while(strlen($token) < $length) {
        $token .= $chars[mt_rand(0, strlen($chars)-1)];
    }
    return $token;
}

if (isset($_POST['loginId']) && ($_POST['loginPassword'] != '')) {
    $login_id = $_POST['loginId'];
    $login_password = $_POST['loginPassword'];

    $sql_select_user = 'SELECT * FROM users WHERE user_email = "'.$login_id.'" AND is_hold != "true"';
    $result_select_user = $conn->query($sql_select_user);
    $row_select_user = $result_select_user->fetch_assoc();
    
    if ($result_select_user->num_rows === 1) { 
        if (password_verify($login_password, $row_select_user['user_password_hash'])) {               
            $user_id = $row_select_user['user_id'];
            $user_name = $row_select_user['user_name'];

            $user_auth = generateToken(80);
            $user_status = 'true';

            $sql_select_id = 'SELECT * FROM users_login WHERE user_id = "'.$user_id.'"';
            $result_select_id = $conn->query($sql_select_id);

            if ($result_select_id->num_rows === 1) {
                $sql_update_status = 
                '
                UPDATE users_login SET
                user_auth = "'.$user_auth.'",
                user_status = "'.$user_status.'"
                WHERE user_id = "'.$user_id.'"
                ';
                $result_update_status = $conn->query($sql_update_status);

                if ($result_update_status) {
                    setcookie('user_auth', $user_auth, time() + (10 * 365 * 24 *60 * 60), '/');
                    setcookie('user_status', $user_status, time() + (10 * 365 * 24 *60 * 60), '/');

                    echo $user_status . '__%__' . $user_name;
                }
            } else {    
                $sql_insert_status = 
                '
                INSERT INTO users_login (
                    user_id,
                    user_auth,
                    user_status
                ) VALUES (
                    "'.$user_id.'",
                    "'.$user_auth.'",
                    "'.$user_status.'"
                )
                ';
                $result_insert_status = $conn->query($sql_insert_status);
        
                if ($result_insert_status) {
                    setcookie('user_auth', $user_auth, time() + (10 * 365 * 24 *60 * 60), '/');
                    setcookie('user_status', $user_status, time() + (10 * 365 * 24 *60 * 60), '/');
        
                    echo $user_status . '__%__' . $user_name;
                }
            }

            $sql_update_user = "UPDATE users SET user_status = 'true', last_login = '".$current_time."' WHERE user_id = '".$user_id."'";
            $result_update_user = $conn->query($sql_update_user);
        } else {
            echo 'Incorrect Password';
        }
    } else {
        echo 'Incorrect ID';
    }
}

?>