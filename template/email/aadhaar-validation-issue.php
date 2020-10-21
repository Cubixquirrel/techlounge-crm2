<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"Aadhaar Validation Issue" => [
"subject" => "Aadhaar Validation Issue While Processing Your Udyam Application",
"message" => 
"Dear Sir / Maam,<br><br>
Greetings of the day !!<br><br>
This mail is in reference to your Application Submitted for MSME / UDYAM REGISTRATION.<br>
While processing your application following errors / issues were noticed :<br>
a) You did not provide your Aadhaar Card, OR<br>
b) Your name mentioned on the application does not match with Aadhaar Database.<br>
Due to either of above mentioned discrepancy, your application processing has been put on hold.
<br><br>
To resolve this issue, we advise you to send Your Latest Aadhaar Card at the earliest by clicking on the link below.
<br>
".$_GET["cid"]."
<br><br>
Note : 
For latest Copy of Aadhaar Card <br>
1) Download it from <a href='https://eaadhaar.uidai.gov.in/#/'>https://eaadhaar.uidai.gov.in</a>  (Only if Mobile Number is Linked to Aadhaar Card.)<br>
2) Get Latest Aadhar Card from Aadhaar Centre in your neighbourhood.
Click here to know the nearest Aadhaar Centre in your locality <a href='https://appointments.uidai.gov.in/EACenterSearch.aspx?value=2'>https://appointments.uidai.gov.in/EACenterSearch.aspx?value=2</a>
<br>
<br>
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
