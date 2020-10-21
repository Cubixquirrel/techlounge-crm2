<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"OTP Not Given" => [
"subject" => "Intimation Of Non Processing Of Udyam Certificate Due To Non Cooperation From You",
"message" => 
"Dear Sir / Maam,<br><br>
Greeting for the day !!<br><br>
This mail is in reference to your application for MSME UDYAM registration.<br>
As per the Standard Operating Procedure, we need to verify that the order for MSME Registration has been placed by the owner of the Aadhaar Number (i.e. Applicant is the Owner of the Aadhaar being used for Registration).<br>
To verify that same, we send an OTP on the mobile number saved in the Aadhaar Database by UIDAI. The same needs to be shared with us to validate the identity.<br>
As per our telephonic conversation today you were not ready to share the OTP to allow us to validate as aforementioned.
<br><br>
In absence of cooperation from you we are unable to process your registration application.
<br><br>
Thanking you
<br>
Team MSME UDYAM Registration

"
]
];

$type = $_GET["type"];

$subject = array($processor_email)[0][$type]["subject"];
$message = array($processor_email)[0][$type]["message"];

echo json_encode(array($subject, $message));

?>
