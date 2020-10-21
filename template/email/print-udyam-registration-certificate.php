<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"Print Udyam Registration Certificate" => [
"subject" => "Print Udyam Registration Certificate",
"message" => 
"Dear Sir / Maam,
<br><br>
Greetings of the day !!
<br><br>
This mail is in reference to your application submitted for PRINT UDYAM REGISTRATION CERTIFICATE.
<br><br>
We are glad to inform you that your certificate has been TRACED / GENERATED and the same has been attached 
below for your reference.
<br>
Your UDYAM REGISTRATION NUMBER is 
<span class='uam-box' style='font-weight: 700; text-transform: uppercase'>______________________</span>
<br><br>
Regards,
<br>
Team Processing
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
