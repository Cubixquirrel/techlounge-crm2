<?php
    include_once('../config/db.php');

    date_default_timezone_set('Asia/Kolkata');
    $form_created_on = date('d-m-Y H:i:s');
    $form_date = date('d');
    $form_month = date('m');
    $form_year = date('Y');

    $form_created_on_date = date('d-m-Y');
    $form_created_on_time = date('H:i:s');

    if ($_GET["status"] == 'Unpaid') {
        $website_form_id = $_GET['formId'];
        $website_vendor = $_GET['vendor'];
        $website_business = $_GET['business'];
        $website_name = $_GET['website'];
        $form_amount = $_GET['amount'];
        $form_status = $_GET['status'];
        $client_name = ucwords(strtolower($_GET['name']));
        $client_mobile = $_GET['mobile'];
        $client_email = strtolower($_GET['email']);
        $client_form_name = ucwords(urldecode($_GET['formName']));

        $sql_select_forms = "SELECT * FROM forms WHERE mobile = '".$_GET['mobile']."' OR email = '".$_GET['email']."' ORDER BY id DESC LIMIT 1";
        $result_select_forms = $conn->query($sql_select_forms);

        // If already assigned, assign to same user
        if ($result_select_forms->num_rows > 0) {
            $row_select_forms = $result_select_forms->fetch_assoc();
            $assigned_to = $row_select_forms['assigned_to'];

            // If current user is unpaid
            if ($row_select_forms["status"] == 'Unpaid') {
                if ($row_select_forms["form_id"] != '') { $added_website_form_id = $row_select_forms["form_id"] . ',' . $website_form_id; } else { $added_website_form_id = $website_form_id; }
                if ($row_select_forms["vendor_array"] != '') { $added_website_vendor = $row_select_forms["vendor_array"] . ',' . $website_vendor; } else { $added_website_vendor = $website_vendor; }
                if ($row_select_forms["business_array"] != '') { $added_website_business = $row_select_forms["business_array"] . ',' . $website_business; } else { $added_website_business = $website_business; }
                if ($row_select_forms["website_array"] != '') { $added_website_name = $row_select_forms["website_array"] . ',' . $website_name; } else { $added_website_name = $website_name; }
                if ($row_select_forms["amount_array"] != '') { $added_form_amount = $row_select_forms["amount_array"] . ',' . $form_amount; } else { $added_form_amount = $form_amount; }
                if ($row_select_forms["status_array"] != '') { $added_form_status = $row_select_forms["status_array"] . ',' . $form_status; } else { $added_form_status = $form_status; }
                if ($row_select_forms["form_name"] != '') { $added_client_form_name = $row_select_forms["form_name"] . ',' . $client_form_name; } else { $added_client_form_name = $client_form_name; }
                
                $sql_update_forms = 
                "
                UPDATE forms
                SET
                form_id = '".$added_website_form_id."',
                vendor_array = '".$added_website_vendor."', business_array = '".$added_website_business."', website_array = '".$added_website_name."', amount_array = '".$added_form_amount."', status_array = '".$added_form_status."',
                vendor = '".$website_vendor."', business = '".$website_business."', website = '".$website_name."', amount = '".$form_amount."', status = '".$form_status."',
                name = '".$client_name."', mobile = '".$client_mobile."', email = '".$client_email."', form_name = '".$added_client_form_name."', 
                assigned_to = '".$assigned_to."',
                dropped = '', dropped_by = '', is_follow_up = '',
                date = '".$form_created_on."', form_date = '".$form_date."', form_month = '".$form_month."', form_year = '".$form_year."'
                WHERE mobile = '".$_GET['mobile']."' OR email = '".$_GET['email']."' ORDER BY id DESC LIMIT 1
                ";
                $result_update_forms = $conn->query($sql_update_forms);
                $crm_form_id = $row_select_forms["id"];
            }

            // If current user is paid
            else if ($row_select_forms["status"] == 'Paid') {
                $sql_insert_forms = 
                "
                INSERT INTO forms (
                form_id,
                vendor_array, business_array, website_array, amount_array, status_array,
                vendor, business, website, amount, status,
                name, mobile, email, form_name, 
                assigned_to,
                date, form_date, form_month, form_year
                )
                VALUES (
                '".$website_form_id."',
                '".$website_vendor."', '".$website_business."', '".$website_name."', '".$form_amount."', '".$form_status."',
                '".$website_vendor."', '".$website_business."', '".$website_name."', '".$form_amount."', '".$form_status."',
                '".$client_name."', '".$client_mobile."', '".$client_email."', '".$client_form_name."', 
                '".$assigned_to."',
                '".$form_created_on."', '".$form_date."', '".$form_month."', '".$form_year."'
                )";
                $result_insert_forms = $conn->query($sql_insert_forms);
                $crm_form_id = $conn->insert_id;
            }
        }

        // If not assigned to any user
        else {
            $sql_select_users = "SELECT * FROM users WHERE FIND_IN_SET('Sales', user_role) AND user_status = 'true' AND is_hold = 'false' AND FIND_IN_SET('".$website_business."', user_team)";
            $result_select_users = $conn->query($sql_select_users);

            // If not assigned to any user and all sales user status is false, assign to Sales Log
            if ($result_select_users->num_rows == 0) {
                $assigned_to = 'Sales Log';
            }

            // If not assigned to any user and if one of sales user status is true, assign to this user
            else if ($result_select_users->num_rows == 1) {
                $row_select_users = $result_select_users->fetch_assoc();
                $assigned_to = $row_select_users["user_name"];
            }

            // If not assigned to any user and all sales user status is true, assign randomly
            else if ($result_select_users->num_rows >= 2) {
                $sql_select_users = "SELECT * FROM users WHERE FIND_IN_SET('Sales', user_role) AND user_status = 'true' AND is_hold = 'false' AND FIND_IN_SET('".$website_business."', user_team) ORDER BY RAND() LIMIT 1";
                $result_select_users = $conn->query($sql_select_users);
                $row_select_users = $result_select_users->fetch_assoc();
                $assigned_to = $row_select_users["user_name"];
            }

            $sql_insert_forms = 
            "
            INSERT INTO forms (
            form_id,
            vendor_array, business_array, website_array, amount_array, status_array,
            vendor, business, website, amount, status,
            name, mobile, email, form_name, 
            assigned_to,
            date, form_date, form_month, form_year
            )
            VALUES (
            '".$website_form_id."',
            '".$website_vendor."', '".$website_business."', '".$website_name."', '".$form_amount."', '".$form_status."',
            '".$website_vendor."', '".$website_business."', '".$website_name."', '".$form_amount."', '".$form_status."',
            '".$client_name."', '".$client_mobile."', '".$client_email."', '".$client_form_name."', 
            '".$assigned_to."',
            '".$form_created_on."', '".$form_date."', '".$form_month."', '".$form_year."'
            )";
            $result_insert_forms = $conn->query($sql_insert_forms);
            $crm_form_id = $conn->insert_id;
        }

        $sql_insert_timeline = 
        "
        INSERT INTO timeline (
        meta_id, meta_name, meta_description, meta_user,
        form_created_on, form_created_time
        )
        VALUES (
        '".$crm_form_id."', 'form', 'New form submitted', '-',
        '".$form_created_on_date."', '".$form_created_on_time."'
        )
        ";
        $result_insert_timeline = $conn->query($sql_insert_timeline);
        echo $crm_form_id;
    }
?>