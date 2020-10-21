<?php

include_once('../classes/xmlapi.php');
include_once('../config/db.php');

$domain = $_POST['domain'];
$user_name = $_POST['userName'];
$password = $_POST['password'];

///////////////////////////////////////////////////////////////////////////////////////
// premlata
$xmlapi_1 = new xmlapi($ip_1);
$xmlapi_1->set_port('2083');
$xmlapi_1->password_auth($account_1, $password_1);
$xmlapi_1->set_output('array');
$domain_lists_1 = $xmlapi_1->api2_query($account_1, 'AddonDomain', 'listaddondomains')['data'];
$subdomain_lists_1 = $xmlapi_1->api2_query($account_1, 'SubDomain', 'listsubdomains')['data'];
$email_lists_1 = $xmlapi_1->api2_query($account_1, 'Email', 'listpopswithdisk')['data'];
$new_domain_lists_1 = [];
for ($i = 0; $i < count($domain_lists_1); $i++) {
    $new_domain_lists_1[] = $domain_lists_1[$i]['domain'];
}
$new_subdomain_lists_1 = [];
for ($i = 0; $i < count($subdomain_lists_1); $i++) {
    $new_subdomain_lists_1[] = $subdomain_lists_1[$i]['domain'];
}
$new_email_lists_1 = [];
for ($i = 0; $i < count($email_lists_1); $i++) {
    $new_email_lists_1[] = $email_lists_1[$i]['email'];
}
// print_r($new_domain_lists_1);
// print_r($new_subdomain_lists_1);
// print_r($new_email_lists_1);

///////////////////////////////////////////////////////////////////////////////////////
// amitk173
$xmlapi_2 = new xmlapi($ip_2);
$xmlapi_2->set_port('2083');
$xmlapi_2->password_auth($account_2, $password_2);
$xmlapi_2->set_output('array');
$domain_lists_2 = $xmlapi_2->api2_query($account_2, 'AddonDomain', 'listaddondomains')['data'];
$subdomain_lists_2 = $xmlapi_2->api2_query($account_2, 'SubDomain', 'listsubdomains')['data'];
$email_lists_2 = $xmlapi_2->api2_query($account_2, 'Email', 'listpopswithdisk')['data'];
$new_domain_lists_2 = [];
for ($i = 0; $i < count($domain_lists_2); $i++) {
    $new_domain_lists_2[] = $domain_lists_2[$i]['domain'];
}
$new_subdomain_lists_2 = [];
for ($i = 0; $i < count($subdomain_lists_2); $i++) {
    $new_subdomain_lists_2[] = $subdomain_lists_2[$i]['domain'];
}
$new_email_lists_2 = [];
for ($i = 0; $i < count($email_lists_2); $i++) {
    $new_email_lists_2[] = $email_lists_2[$i]['email'];
}
// print_r($new_domain_lists_2);
// print_r($new_subdomain_lists_2);
// print_r($new_email_lists_2);

///////////////////////////////////////////////////////////////////////////////////////
// amitk51324
$xmlapi_3 = new xmlapi($ip_3);
$xmlapi_3->set_port('2083');
$xmlapi_3->password_auth($account_3, $password_3);
$xmlapi_3->set_output('array');
$domain_lists_3 = $xmlapi_3->api2_query($account_3, 'AddonDomain', 'listaddondomains')['data'];
$subdomain_lists_3 = $xmlapi_3->api2_query($account_3, 'SubDomain', 'listsubdomains')['data'];
$email_lists_3 = $xmlapi_3->api2_query($account_3, 'Email', 'listpopswithdisk')['data'];
$new_domain_lists_3 = [];
for ($i = 0; $i < count($domain_lists_3); $i++) {
    $new_domain_lists_3[] = $domain_lists_3[$i]['domain'];
}
$new_subdomain_lists_3 = [];
for ($i = 0; $i < count($subdomain_lists_3); $i++) {
    $new_subdomain_lists_3[] = $subdomain_lists_3[$i]['domain'];
}
$new_email_lists_3 = [];
for ($i = 0; $i < count($email_lists_3); $i++) {
    $new_email_lists_3[] = $email_lists_3[$i]['email'];
}
// print_r($new_domain_lists_3);
// print_r($new_subdomain_lists_3);
// print_r($new_email_lists_3);

///////////////////////////////////////////////////////////////////////////////////////

$email_properties = array(
    'domain' => $domain,
    'email' => $user_name,
    'password' => $password,
    'quota' => 250
);

if (in_array($domain, $new_domain_lists_1)) {
    // echo 'Domain 1';
    $email_result = $xmlapi_1->api2_query($account_1, "Email", "addpop", $email_properties);
}

else if (in_array($domain, $new_subdomain_lists_1)) {
    // echo 'Sub Domain 1';
    $email_result = $xmlapi_1->api2_query($account_1, "Email", "addpop", $email_properties);
}

else if (in_array($domain, $new_domain_lists_2)) {
    // echo 'Domain 2';
    $email_result = $xmlapi_2->api2_query($account_2, "Email", "addpop", $email_properties);
}

else if (in_array($domain, $new_subdomain_lists_2)) {
    // echo 'Sub Domain 1';
    $email_result = $xmlapi_2->api2_query($account_2, "Email", "addpop", $email_properties);
}

else if (in_array($domain, $new_domain_lists_3)) {
    // echo 'Domain 3';
    $email_result = $xmlapi_3->api2_query($account_3, "Email", "addpop", $email_properties);
}

else if (in_array($domain, $new_subdomain_lists_3)) {
    // echo 'Sub Domain 3';
    $email_result = $xmlapi_3->api2_query($account_3, "Email", "addpop", $email_properties);
}

if ($email_result['data']['result'] == 1) {
    $email_id = $user_name . '@' . $domain;

    $sql_insert_email_lists = 
    '
    INSERT INTO campaign_email_lists (
        domain, user_name, email_id, password
    ) VALUES (
        "'.$domain.'", "'.$user_name.'", "'.$email_id.'", "'.$password.'"
    )
    ';
    $result_insert_email_lists = $conn->query($sql_insert_email_lists);

    if ($result_insert_email_lists) {
        print_r($email_result['data']['result']);
    }
} else {
    print_r($email_result['data']['result']);
}

?>