<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"Delivery of Udyog Aadhaar Registration Certificate (Print UAM Certificate)" => [
"subject" => "Delivery of Udyog Aadhaar Registration Certificate (Print UAM Certificate)",
"message" => 
"Dear Sir / Maam,
<br><br>
Greetings of the day !!
<br><br>
This mail is in reference to your application submitted for TRACKING / PRINTING of existing 
Udyog Aadhaar Registration Certificate.
<br><br>
We are glad to inform you that your certificate has been TRACED / PRINTED. The same has been attached 
below for your reference.
<br><br>
Regards,
<br>
Team UAM Processing
<br><br>
Note : Do not reply to this email as this is an unattended email.
"
]
];

$type = $_GET["type"];

$subject = array($processor_email)[0][$type]["subject"];
$message = array($processor_email)[0][$type]["message"];

echo json_encode(array($subject, $message));

?>
