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

    if ((isset($_POST['complaint_id']) && $_POST['complaint_id'] != '')) {
        $sql_select_form = 'SELECT * FROM complaint_forms WHERE complaint_id = "'.$_POST["complaint_id"].'"';
        $result_select_form = $conn->query($sql_select_form);
        if ($result_select_form->num_rows == 1) {
            $row_select_form = $result_select_form->fetch_assoc();
            $applicant_name  = $row_select_form['applicant_name'];
            $message         = $_POST['message'];
            $stage           = $row_select_form['stage'];
        }

        if ($stage != '0') {
            $sql_update_complaint_forms = 'UPDATE complaint_forms SET stage = "2", form_created_on = "'.$form_created_on.'", form_date = "'.$form_date.'", form_month = "'.$form_month.'", form_year = "'.$form_year.'" WHERE complaint_id = "'.$_POST["complaint_id"].'"';
            $result_update_complaint_forms = $conn->query($sql_update_complaint_forms);
        } else {
            $sql_update_complaint_forms = 'UPDATE complaint_forms SET stage = "0", form_created_on = "'.$form_created_on.'", form_date = "'.$form_date.'", form_month = "'.$form_month.'", form_year = "'.$form_year.'" WHERE complaint_id = "'.$_POST["complaint_id"].'"';
            $result_update_complaint_forms = $conn->query($sql_update_complaint_forms);            
        }

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
            '".$_POST['complaint_id']."',
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

?>