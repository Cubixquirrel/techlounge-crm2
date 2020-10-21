<?php 
    include_once('../config/db.php');
    include_once('../classes/login-status.php');
    include_once('../json/website-data.php');
    
    $sqlSelectForms = "SELECT * FROM forms WHERE id = '".$_POST['clientId']."'";
    $resultSelectForms = $conn->query($sqlSelectForms);
    $rowSelectForms = $resultSelectForms->fetch_assoc();

    $form_id_array  = array_reverse(preg_split("/\,/", $rowSelectForms["form_id"]));
    $business_array = array_reverse(preg_split("/\,/", $rowSelectForms["business_array"]));
    $website_array  = array_reverse(preg_split("/\,/", $rowSelectForms["website_array"]));
    $amount_array   = array_reverse(preg_split("/\,/", $rowSelectForms["amount_array"]));
    
    $return = '';
    for ($i = 0; $i < count($form_id_array); $i++) {
        $form_id            = $form_id_array[$i];
        $sql_business       = $business_array[$i];
        $sql_website_name   = $website_array[$i];
        $sql_amount         = $amount_array[$i];

        $find_website_data = array($website_data)[0][$sql_website_name];

        $hostname = array($website_data)[0][$sql_website_name]['hostname'];
        $username = array($website_data)[0][$sql_website_name]['username'];
        $password = array($website_data)[0][$sql_website_name]['password'];
        $database = array($website_data)[0][$sql_website_name]['database'];
        
        if ($sql_amount == 'ENQUIRY') {
            $table = array($website_data)[0][$sql_website_name]['table']['ENQUIRY'];
        } else {
            $table = array($website_data)[0][$sql_website_name]['table'][$sql_business];
        }

        $remote_conn = new mysqli($hostname, $username, $password, $database);
        if ($remote_conn->connect_error) {
            die("Connection failed: " . $remote_conn->connect_error);
        }

        $select_form = "SELECT * FROM $table WHERE id = '$form_id'";
        $result_select_form = $remote_conn->query($select_form);
        $row_select_form = $result_select_form->fetch_assoc();

        if ($sql_amount == 'ENQUIRY') {
            $return .= "Enquiry Form=".$row_select_form['id']."||";
        } else {
            $return .= $row_select_form['form_name']."=".$row_select_form['id']."||";
        }
    }
    echo $return;
?>