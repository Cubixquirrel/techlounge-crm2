<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"Driving Licence Aadhaar DL Issue" => [
"subject" => "Driving Licence Aadhaar / DL Issue",
"message" => 
"Dear Sir / Maam,<br><br>
Greetings of the day !!<br><br>
This mail is in reference to your Application Submitted for Driving Licence.<br>
While processing your application following errors / issues were noticed :<br>
<span class='dl-detail-document-box' style='font-weight: 700; text-transform: uppercase'>______________________</span>.<br>
Due to above mentioned discrepancy, your application processing has been put on hold.
<br><br>
To resolve this issue, we advise you to update following details at the earliest by clicking on the link below.
<br>
https://licencewala.com/complaint-form.php
<br><br>
Regards,
<br>
Team Processing
"
]
];

$type = $_GET["type"];

$subject = array($processor_email)[0][$type]["subject"];
$message = array($processor_email)[0][$type]["message"];

echo json_encode(array($subject, $message));

?>
