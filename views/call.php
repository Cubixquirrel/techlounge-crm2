<?php
include_once('../config/db.php');
include_once('../classes/login-status.php');

if (
    (isset($_POST['call_button'])) && 
    ($_POST['id'] != '')
) {

    $sql_select_ext = "SELECT * FROM users WHERE user_name = '".$user_name."'";
    $result_select_ext = $conn->query($sql_select_ext);
    $row_select_ext = $result_select_ext->fetch_assoc();
    $ext = $row_select_ext['user_ext'];

    $sql_select_mobile = "SELECT * FROM forms WHERE id = '".$_POST['id']."'";
    $result_select_mobile = $conn->query($sql_select_mobile);
    $row_select_mobile = $result_select_mobile->fetch_assoc();
    $mobile = intval($row_select_mobile['mobile']);

    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://pbx.voxbaysolutions.com/api/call.php?uid=dfWdEg5DFfbD&pin=cD4QWR644FRgehg&ext='.$ext.'&destination=91'.$mobile.'',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "POST",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: text/html; charset=UTF-8"
      ),
      CURLOPT_SSL_VERIFYHOST => 0,
      CURLOPT_SSL_VERIFYPEER => 0
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo 'Connecting...';
} else {
    echo 'Not Connected';
    header("location:javascript://history.go(-1)");
}
?>