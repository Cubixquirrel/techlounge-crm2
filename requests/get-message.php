<?php
include_once("../config/db.php");

if (($_POST['messageId'] != '') && ($_POST['type'] != '')) {
    $sql = "SELECT message FROM ".$_POST['type']." WHERE id = ".$_POST['messageId']."";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    echo $row['message'];
}

?>