<?php
    include_once('../config/db.php');
    include_once('../classes/login-status.php');

    date_default_timezone_set('Asia/Kolkata');
    $form_created_on = date('d-m-Y H:i:s');
    $form_date = date('d');
    $form_month = date('m');
    $form_year = date('Y');

    $form_created_on_date = date('d-m-Y');
    $form_created_on_time = date('H:i:s');

    if ( (isset($_POST['form_name']) && $_POST['form_name'] == 'Complaint Form') && (isset($_POST['complaint_id']) && $_POST['complaint_id'] != '') ) {
        
        // print_r($_POST);
        $applicant_name = ucwords($_POST["applicant_name"]);
        $mobile_number  = intval($_POST["mobile_number"]);
        $email_id       = strtolower($_POST["email_id"]);
        $docs           = $_POST["docs"];
        $message        = $_POST["complaint_details"];

        $sql_select_users = "SELECT * FROM users WHERE FIND_IN_SET('Complaint', user_role) AND user_status = 'true'";
        $result_select_users = $conn->query($sql_select_users);

        // If all complaint user status is false, assign to complaint log
        if (mysqli_num_rows($result_select_users) == 0) {            
            $sql_insert_complaint = 
            '
            INSERT INTO complaint_forms (
                business,
                complaint_id,
                form_name,
                applicant_name,
                mobile_number,
                email_id,
                docs,
                order_id,
                transaction_date,
                transaction_amount,
                complaint_details,
                website,
                assigned_to,
                stage,
                form_created_on,
                form_date,
                form_month,
                form_year
            ) VALUES (
                "'.$_POST["business"].'",
                "'.$_POST["complaint_id"].'",
                "'.$_POST["form_name"].'",
                "'.$applicant_name.'",
                "'.$mobile_number.'",
                "'.$email_id.'",
                "'.$docs.'",
                "'.$_POST["order_id"].'",
                "'.$_POST["transaction_date"].'",
                "'.$_POST["transaction_amount"].'",
                "'.$message.'",
                "'.$_POST["website"].'",
                "Complaint Log",
                "0",
                "'.$form_created_on.'",
                "'.$form_date.'",
                "'.$form_month.'",
                "'.$form_year.'"
            )
            ';
            $result_insert_complaint = $conn->query($sql_insert_complaint);
            
            if ($result_insert_complaint) {
                $sql_insert_timeline =
                "
                INSERT INTO complaint_timeline (
                    meta_id,
                    meta_name,
                    meta_description,
                    meta_user,
                    form_created_on,
                    form_created_time
                ) VALUES (
                    '".$_POST["complaint_id"]."',
                    'complaint form',
                    '".$message."',
                    '".$applicant_name."',
                    '".$form_created_on_date."',
                    '".$form_created_on_time."'
                )
                ";
                $result_insert_timeline = $conn->query($sql_insert_timeline);

                if ($result_insert_timeline) {
                    echo 'Data Inserted';
                }
            }
        }

        // If one of complaint user status is true, assign to this user
        else if (mysqli_num_rows($result_select_users) == 1) {
            $row_select_users = $result_select_users->fetch_assoc();

            $sql_insert_complaint = 
            '
            INSERT INTO complaint_forms (
                business,
                complaint_id,
                form_name,
                applicant_name,
                mobile_number,
                email_id,
                docs,
                order_id,
                transaction_date,
                transaction_amount,
                complaint_details,
                website,
                assigned_to,
                stage,
                form_created_on,
                form_date,
                form_month,
                form_year
            ) VALUES (
                "'.$_POST["business"].'",
                "'.$_POST["complaint_id"].'",
                "'.$_POST["form_name"].'",
                "'.$applicant_name.'",
                "'.$mobile_number.'",
                "'.$email_id.'",
                "'.$docs.'",
                "'.$_POST["order_id"].'",
                "'.$_POST["transaction_date"].'",
                "'.$_POST["transaction_amount"].'",
                "'.$message.'",
                "'.$_POST["website"].'",
                "'.$row_select_users["user_name"].'",
                "0",
                "'.$form_created_on.'",
                "'.$form_date.'",
                "'.$form_month.'",
                "'.$form_year.'"
            )
            ';
            $result_insert_complaint = $conn->query($sql_insert_complaint);
            
            if ($result_insert_complaint) {
                $sql_insert_timeline =
                "
                INSERT INTO complaint_timeline (
                    meta_id,
                    meta_name,
                    meta_description,
                    meta_user,
                    form_created_on,
                    form_created_time
                ) VALUES (
                    '".$_POST["complaint_id"]."',
                    'complaint form',
                    '".$message."',
                    '".$applicant_name."',
                    '".$form_created_on_date."',
                    '".$form_created_on_time."'
                )
                ";
                $result_insert_timeline = $conn->query($sql_insert_timeline);
                
                if ($result_insert_timeline) {
                    echo 'Data Inserted';
                }
            }
        }

        // If all complaint user status is true, assign randomly
        else if (mysqli_num_rows($result_select_users) >= 2) {
            $sql_select_user = "SELECT * FROM users WHERE FIND_IN_SET('Complaint', user_role) AND user_status = 'true' ORDER BY RAND() LIMIT 1";
            $result_select_user = $conn->query($sql_select_user);
            $row_select_user = $result_select_user->fetch_assoc();

            $sql_insert_complaint = 
            '
            INSERT INTO complaint_forms (
                business,
                complaint_id,
                form_name,
                applicant_name,
                mobile_number,
                email_id,
                docs,
                order_id,
                transaction_date,
                transaction_amount,
                complaint_details,
                website,
                assigned_to,
                stage,
                form_created_on,
                form_date,
                form_month,
                form_year
            ) VALUES (
                "'.$_POST["business"].'",
                "'.$_POST["complaint_id"].'",
                "'.$_POST["form_name"].'",
                "'.$applicant_name.'",
                "'.$mobile_number.'",
                "'.$email_id.'",
                "'.$docs.'",
                "'.$_POST["order_id"].'",
                "'.$_POST["transaction_date"].'",
                "'.$_POST["transaction_amount"].'",
                "'.$message.'",
                "'.$_POST["website"].'",
                "'.$row_select_user["user_name"].'",
                "0",
                "'.$form_created_on.'",
                "'.$form_date.'",
                "'.$form_month.'",
                "'.$form_year.'"
            )
            ';
            $result_insert_complaint = $conn->query($sql_insert_complaint);
            
            if ($result_insert_complaint) {
                $sql_insert_timeline =
                "
                INSERT INTO complaint_timeline (
                    meta_id,
                    meta_name,
                    meta_description,
                    meta_user,
                    form_created_on,
                    form_created_time
                ) VALUES (
                    '".$_POST["complaint_id"]."',
                    'complaint form',
                    '".$message."',
                    '".$message."',
                    '".$applicant_name."',
                    '".$form_created_on_date."',
                    '".$form_created_on_time."'
                )
                ";
                $result_insert_timeline = $conn->query($sql_insert_timeline);
                
                if ($result_insert_timeline) {
                    echo 'Data Inserted';
                }
            }
        }
    }

?>