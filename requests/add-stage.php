<?php
include_once('../config/db.php');

// $sql_select_business = 'SELECT * FROM business WHERE stage = "'.$_POST["stageName"].'"';
// $result_select_business = $conn->query($sql_select_business);
// if ($result_select_business->num_rows > 0) {
//     echo 'Stage Name Already Existed';
//     exit;
// }

foreach (explode(',', $_POST['teamId']) as $key => $value) {
    $sql_insert_business = 
    '
    INSERT INTO business (
        business_name, stage
    ) VALUES (
        "'.$value.'", "'.$_POST["stageName"].'"
    )
    ';
    $result_insert_business = $conn->query($sql_insert_business);
}

if ($result_insert_business) {
    echo 'Stage Inserted';
}

?>