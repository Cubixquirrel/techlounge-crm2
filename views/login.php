<?php

include_once('../config/db.php');

if (isset($_COOKIE['user_status']) && $_COOKIE['user_status'] == 'true') {
    $sql_select_users_login = 'SELECT user_id FROM users_login WHERE user_auth = "'.$_COOKIE["user_auth"].'"';
    $result_select_users_login = $conn->query($sql_select_users_login);
    
    if ($result_select_users_login->num_rows === 1) {
        $row_select_users_login = $result_select_users_login->fetch_assoc();

        $sql_select_user = 'SELECT * FROM users WHERE user_id = "'.$row_select_users_login["user_id"].'"';
        $result_select_user = $conn->query($sql_select_user);

        if ($result_select_user->num_rows === 1) {
            $row_select_user = $result_select_user->fetch_assoc();

            if ((in_array('Editor', explode(',', $row_select_user['user_role'])))) {
                header ('location: ../views/analytics.php');
            } else {
                header ('location: ../views/dashboard.php');
            }
        }
    }
}

$page_title = 'CRM Login';

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $page_title; ?></title>
    <link rel="stylesheet" href="../assets/css/login.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/fonts/style.css">
</head>
<body>
    <div class="loader">
        <div class="spinner-border">
            <span class="sr-only">Loading...</span>
        </div>
    </div>
    
    <div class="login-main-container">
        <span class="login-main-text"><?php echo $page_title; ?></span>

        <div class="login-form-container">
            <div class="login-form-group">
                <input type="text" placeholder="Login ID" id="login-id" autocomplete="off">
            </div>

            <div class="login-form-group">
                <input type="password" placeholder="Password" id="login-password" autocomplete="off">
                <i class="icon-eye1 password-icon" onclick="switchPassword()"></i>
            </div>

            <button class="login-button" onclick="login()">Login</button>
        </div>
    </div>

    <script src="../assets/js/login.js"></script>
</body>
</html>