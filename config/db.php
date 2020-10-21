<?php
if ($_SERVER['HTTP_HOST'] == 'localhost') {
    define("DB_HOST", "localhost");
    define("DB_NAME", "techlounge_crm2");
    define("DB_USER", ""); // user
    define("DB_PASS", ""); // password
} else {
    define("DB_HOST", "localhost");
    define("DB_NAME", ""); // database
    define("DB_USER", ""); // user
    define("DB_PASS", ""); // password
}

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ip_1 = ''; // ip 1
$account_1 = ''; // user
$password_1 = ''; // password

$ip_2 = ''; // ip 2
$account_2 = ''; // user
$password_2 = ''; // password

$ip_3 = ''; // ip 3
$account_3 = ''; // user
$password_3 = ''; // password

$sms_user = ''; // user
$sms_password = ''; // password
?>