<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"DNF" => [
"subject" => "Details / Documents Required To Complete Your Udyam Registration Application",
"message" => 
"Dear Sir / Maam,<br><br>
Greetings of the day !!<br><br>
This mail is in reference to your Application Submitted for MSME / UDYAM REGISTRATION.<br>
While processing your application, your application was found to be incomplete or defective 
or the compulsory attachment i.e., Front of Aadhaar Card is missing.
<br><br>
Due to the discrepancy in your application, your application has been put on hold.
<br><br>
To resolve this issue, we advise you to click on the link below and complete your application.
<br>
".$_GET["cid"]."
<br>
<br>
Regards,
<br>
Team Processing
<br><br>
Note: Since your payment has already been received, you wont be required to make payment again.
"
]
];

$type = $_GET["type"];

$subject = array($processor_email)[0][$type]["subject"];
$message = array($processor_email)[0][$type]["message"];

echo json_encode(array($subject, $message));

?>
