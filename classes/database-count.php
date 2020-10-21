<?php
date_default_timezone_set('Asia/Kolkata');
$today_date = date('d');
$this_month = date('m');

$form_created_on = date('d-m-Y H:i:s');
$form_date = date('d');
$form_month = date('m');
$form_year = date('Y');

$sql_count_master = "SELECT COUNT(*) FROM forms";
$result_count_master = $conn->query($sql_count_master);
$row_count_master = $result_count_master->fetch_row();

if (in_array('Admin', explode(',', $row_select_user['user_role']))) {
    $sql_count_complaint = "SELECT COUNT(*) FROM complaint_forms";
    $sql_count_lead = "SELECT COUNT(*) FROM forms WHERE dropped != 'true' AND status != 'Paid' AND is_follow_up != 'true'";
    $sql_count_follow_up = "SELECT COUNT(*) FROM forms WHERE dropped != 'true' AND status != 'Paid' AND is_follow_up = 'true'";
    $sql_count_dropped = "SELECT COUNT(*) FROM forms WHERE dropped = 'true' AND status != 'Paid'";
    $sql_count_paid = "SELECT COUNT(*) FROM forms WHERE status = 'Paid'";
    $sql_count_users = "SELECT COUNT(*) FROM users";
    $sql_count_business = "SELECT COUNT(*) FROM users_team";

    $result_count_complaint = $conn->query($sql_count_complaint);
    $result_count_lead = $conn->query($sql_count_lead);
    $result_count_follow_up = $conn->query($sql_count_follow_up);
    $result_count_dropped = $conn->query($sql_count_dropped);
    $result_count_paid = $conn->query($sql_count_paid);
    $result_count_users = $conn->query($sql_count_users);
    $result_count_business = $conn->query($sql_count_business);

    $row_count_complaint = $result_count_complaint->fetch_row();
    $row_count_lead = $result_count_lead->fetch_row();
    $row_count_follow_up = $result_count_follow_up->fetch_row();
    $row_count_dropped = $result_count_dropped->fetch_row();
    $row_count_paid = $result_count_paid->fetch_row();
    $row_count_users = $result_count_users->fetch_row();
    $row_count_business = $result_count_business->fetch_row();

    $sql_select_complaint_forms_0 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "0" AND form_date = "'.$form_date.'" AND form_month = "'.$form_month.'" AND form_year = "'.$form_year.'"';                                        
    $result_select_complaint_forms_0 = $conn->query($sql_select_complaint_forms_0);
    $row_select_complaint_forms_0 = $result_select_complaint_forms_0->fetch_row();
    $new_created_today = $row_select_complaint_forms_0[0];

    $sql_select_complaint_forms_1 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "1" AND form_date = "'.$form_date.'" AND form_month = "'.$form_month.'" AND form_year = "'.$form_year.'"';                                        
    $result_select_complaint_forms_1 = $conn->query($sql_select_complaint_forms_1);
    $row_select_complaint_forms_1 = $result_select_complaint_forms_1->fetch_row();
    $updated_by_us_today = $row_select_complaint_forms_1[0];

    $sql_select_complaint_forms_2 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "2" AND form_date = "'.$form_date.'" AND form_month = "'.$form_month.'" AND form_year = "'.$form_year.'"';                                        
    $result_select_complaint_forms_2 = $conn->query($sql_select_complaint_forms_2);
    $row_select_complaint_forms_2 = $result_select_complaint_forms_2->fetch_row();
    $updated_by_client_today = $row_select_complaint_forms_2[0];

    $sql_select_complaint_forms_3 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "3" AND form_date = "'.$form_date.'" AND form_month = "'.$form_month.'" AND form_year = "'.$form_year.'"';                                        
    $result_select_complaint_forms_3 = $conn->query($sql_select_complaint_forms_3);
    $row_select_complaint_forms_3 = $result_select_complaint_forms_3->fetch_row();
    $closed_today = $row_select_complaint_forms_3[0];

    $sql_select_complaint_forms_total_0 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "0"';
    $result_select_complaint_forms_total_0 = $conn->query($sql_select_complaint_forms_total_0);
    $row_select_complaint_forms_total_0 = $result_select_complaint_forms_total_0->fetch_row();
    $new_created_total = $row_select_complaint_forms_total_0[0];

    $sql_select_complaint_forms_total_1 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "1"';
    $result_select_complaint_forms_total_1 = $conn->query($sql_select_complaint_forms_total_1);
    $row_select_complaint_forms_total_1 = $result_select_complaint_forms_total_1->fetch_row();
    $updated_by_us_total = $row_select_complaint_forms_total_1[0];

    $sql_select_complaint_forms_total_2 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "2"';
    $result_select_complaint_forms_total_2 = $conn->query($sql_select_complaint_forms_total_2);
    $row_select_complaint_forms_total_2 = $result_select_complaint_forms_total_2->fetch_row();
    $updated_by_client_total = $row_select_complaint_forms_total_2[0];

    $sql_select_complaint_forms_total_3 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "3"';
    $result_select_complaint_forms_total_3 = $conn->query($sql_select_complaint_forms_total_3);
    $row_select_complaint_forms_total_3 = $result_select_complaint_forms_total_3->fetch_row();
    $closed_total = $row_select_complaint_forms_total_3[0];
}

if (in_array('Processor', explode(',', $row_select_user['user_role']))) {
    $sql_count_pending = "SELECT COUNT(*) FROM forms WHERE status = 'Paid' AND processor = '".$user_name."'";
    
    $result_count_pending = $conn->query($sql_count_pending);

    $row_count_pending = $result_count_pending->fetch_row();
}

if (in_array('Complaint', explode(',', $row_select_user['user_role']))) {
    $sql_count_complaint = "SELECT COUNT(*) FROM complaint_forms WHERE assigned_to = '".$user_name."'";

    $result_count_complaint = $conn->query($sql_count_complaint);

    $row_count_complaint = $result_count_complaint->fetch_row();

    $sql_select_complaint_forms_0 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "0" AND form_date = "'.$form_date.'" AND form_month = "'.$form_month.'" AND form_year = "'.$form_year.'" AND assigned_to = "'.$user_name.'"';                                        
    $result_select_complaint_forms_0 = $conn->query($sql_select_complaint_forms_0);
    $row_select_complaint_forms_0 = $result_select_complaint_forms_0->fetch_row();
    $new_created_today = $row_select_complaint_forms_0[0];

    $sql_select_complaint_forms_1 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "1" AND form_date = "'.$form_date.'" AND form_month = "'.$form_month.'" AND form_year = "'.$form_year.'" AND assigned_to = "'.$user_name.'"';                                        
    $result_select_complaint_forms_1 = $conn->query($sql_select_complaint_forms_1);
    $row_select_complaint_forms_1 = $result_select_complaint_forms_1->fetch_row();
    $updated_by_us_today = $row_select_complaint_forms_1[0];

    $sql_select_complaint_forms_2 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "2" AND form_date = "'.$form_date.'" AND form_month = "'.$form_month.'" AND form_year = "'.$form_year.'" AND assigned_to = "'.$user_name.'"';                                        
    $result_select_complaint_forms_2 = $conn->query($sql_select_complaint_forms_2);
    $row_select_complaint_forms_2 = $result_select_complaint_forms_2->fetch_row();
    $updated_by_client_today = $row_select_complaint_forms_2[0];

    $sql_select_complaint_forms_3 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "3" AND form_date = "'.$form_date.'" AND form_month = "'.$form_month.'" AND form_year = "'.$form_year.'" AND assigned_to = "'.$user_name.'"';                                        
    $result_select_complaint_forms_3 = $conn->query($sql_select_complaint_forms_3);
    $row_select_complaint_forms_3 = $result_select_complaint_forms_3->fetch_row();
    $closed_today = $row_select_complaint_forms_3[0];

    $sql_select_complaint_forms_total_0 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "0" AND assigned_to = "'.$user_name.'"';
    $result_select_complaint_forms_total_0 = $conn->query($sql_select_complaint_forms_total_0);
    $row_select_complaint_forms_total_0 = $result_select_complaint_forms_total_0->fetch_row();
    $new_created_total = $row_select_complaint_forms_total_0[0];

    $sql_select_complaint_forms_total_1 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "1" AND assigned_to = "'.$user_name.'"';
    $result_select_complaint_forms_total_1 = $conn->query($sql_select_complaint_forms_total_1);
    $row_select_complaint_forms_total_1 = $result_select_complaint_forms_total_1->fetch_row();
    $updated_by_us_total = $row_select_complaint_forms_total_1[0];

    $sql_select_complaint_forms_total_2 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "2" AND assigned_to = "'.$user_name.'"';
    $result_select_complaint_forms_total_2 = $conn->query($sql_select_complaint_forms_total_2);
    $row_select_complaint_forms_total_2 = $result_select_complaint_forms_total_2->fetch_row();
    $updated_by_client_total = $row_select_complaint_forms_total_2[0];

    $sql_select_complaint_forms_total_3 = 'SELECT COUNT(*) FROM complaint_forms WHERE stage = "3" AND assigned_to = "'.$user_name.'"';
    $result_select_complaint_forms_total_3 = $conn->query($sql_select_complaint_forms_total_3);
    $row_select_complaint_forms_total_3 = $result_select_complaint_forms_total_3->fetch_row();
    $closed_total = $row_select_complaint_forms_total_3[0];
}

if (in_array('Sales', explode(',', $row_select_user['user_role']))) {
    $sql_count_lead = "SELECT COUNT(*) FROM forms WHERE dropped != 'true' AND status != 'Paid' AND is_follow_up != 'true' AND assigned_to = '".$user_name."'";
    $sql_count_follow_up = "SELECT COUNT(*) FROM forms WHERE dropped != 'true' AND status != 'Paid' AND is_follow_up = 'true' AND assigned_to = '".$user_name."'";
    $sql_count_dropped = "SELECT COUNT(*) FROM forms WHERE dropped = 'true' AND status != 'Paid' AND assigned_to = '".$user_name."'";
    $sql_count_paid = "SELECT COUNT(*) FROM forms WHERE status = 'Paid' AND pay_vendor = 'kfs.jamshedpur@gmail.com' AND assigned_to = '".$user_name."'";

    $result_count_lead = $conn->query($sql_count_lead);
    $result_count_follow_up = $conn->query($sql_count_follow_up);
    $result_count_dropped = $conn->query($sql_count_dropped);
    $result_count_paid = $conn->query($sql_count_paid);

    $row_count_lead = $result_count_lead->fetch_row();
    $row_count_follow_up = $result_count_follow_up->fetch_row();
    $row_count_dropped = $result_count_dropped->fetch_row();
    $row_count_paid = $result_count_paid->fetch_row();

    $sql_select_date = "SELECT count(*) FROM forms WHERE assigned_to = '".$user_name."' AND mark_as_paid_by = '".$user_name."' AND form_date = '$today_date' AND form_month = '$this_month'";
    $sql_select_month = "SELECT count(*) FROM forms WHERE assigned_to = '".$user_name."' AND mark_as_paid_by = '".$user_name."' AND form_month = '$this_month'";

    $result_select_date = $conn->query($sql_select_date);
    $result_select_month = $conn->query($sql_select_month);

    $row_select_date = $result_select_date->fetch_row();
    $row_select_month = $result_select_month->fetch_row();

    $total_target = '40';
    $target_left = $total_target - $row_select_month[0];
}

?>