<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"Delivery Of Udyam Registration Number" => [
"subject" => "Delivery Of Udyam Registration Number",
"message" => 
"Dear Sir / Maam,
<br><br>
Greetings of the day !!
<br><br>
This mail is in reference to your application submitted for UDYAM REGISTRATION NUMBER.
<br><br>
We are glad to inform you that UDYAM REGISTRATION NUMBER against your application 
has been successfully generated, your UDYAM REGISTRATION NUMBER is 
<span class='uam-box' style='font-weight: 700; text-transform: uppercase'>______________________</span>
<br><br>
Your certificate will be generated within next 15 - 20 days and the same will be sent on your registered email address.
<br><br>
Regards,
<br>
Team Udyam Processing
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
