<?php
    include_once('../config/db.php');

    date_default_timezone_set('Asia/Kolkata');
    $form_date_time = date('d-m-Y H:i:s');
    
    $sql_select_ip = "SELECT * FROM track_ip WHERE ip = '".$_GET['ip']."'";
    $result_select_ip = $conn->query($sql_select_ip);

    if ($_GET['status'] == 'true') {
        if ($result_select_ip->num_rows > 0) {
            if (isset($_GET['user_id']) && $_GET['user_id'] != '') {
                $sql_update_ip = 
                "
                UPDATE track_ip SET 
                ip = '".$_GET['ip']."', 
                url = '".$_GET['url']."', 
                user_id = '".$_GET['user_id']."', 
                status = '".$_GET['status']."',
                created_on = '".$form_date_time."' 
                WHERE 
                ip = '".$_GET['ip']."'
                ";

                echo $sql_update_ip;
            } else {
                $sql_update_ip = 
                "
                UPDATE track_ip SET 
                ip = '".$_GET['ip']."', 
                url = '".$_GET['url']."', 
                status = '".$_GET['status']."', 
                created_on = '".$form_date_time."' 
                WHERE 
                ip = '".$_GET['ip']."'
                ";
            }
            $result_update_ip = $conn->query($sql_update_ip);

            if ($result_update_ip) {
                echo 'Data Updated';
            };
        } else {
            if (isset($_GET['user_id']) && $_GET['user_id'] != '') {
                $sql_insert_ip = 
                "
                INSERT INTO track_ip (
                ip,
                url,
                user_id,
                status, 
                created_on
                )

                VALUES (
                '".$_GET["ip"]."',
                '".$_GET["url"]."',
                '".$_GET["user_id"]."',
                '".$_GET["status"]."',
                '".$form_date_time."'
                )
                ";
            } else {
                $sql_insert_ip = 
                "
                INSERT INTO track_ip (
                ip,
                url,
                status, 
                created_on
                )

                VALUES (
                '".$_GET["ip"]."',
                '".$_GET["url"]."',
                '".$_GET["status"]."',
                '".$form_date_time."'
                )
                ";
            }
            $result_insert_ip = $conn->query($sql_insert_ip);

            if ($result_insert_ip) {
                echo 'Data Inserted';
            };
        }
    } else {
        $sql_delete_ip = "DELETE FROM track_ip WHERE ip = '".$_GET['ip']."'";
        $result_delete_ip = $conn->query($sql_delete_ip);
    }

    $sql_select = "SELECT * FROM track_ip";
    $result_select = $conn->query($sql_select);

    while($row_select = $result_select->fetch_assoc()) {
        $new_form_time = strtotime($row_select['created_on']) + 360;
        $current_form_time = strtotime($form_date_time);

        if ($new_form_time > $current_form_time) {} 
        else {
            $sql_delete_ip = "DELETE FROM track_ip WHERE id = '".$row_select['id']."'";
            $result_delete_ip = $conn->query($sql_delete_ip);
        }
    }
?>