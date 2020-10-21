<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"Aadhaar Mobile Issue" => [
"subject" => "Mobile Number Validation Issue While Processing Your Udyam Application",
"message" => 
"Dear Sir / Maam,<br><br>
Greetings of the day !!<br><br>
This mail is in reference to your Application Submitted for MSME / UDYAM REGISTRATION.<br>
While processing your application, one of the following errors or issues were noticed :<br>
a) Your Mobile Number is not linked to your Aadhaar Card, or<br>
b) Mobile Number linked to your Aadhaar Card is not available with you.
<br>
Due to either of the above mentioned discrepancy, your application processing has been put on hold.
<br><br>
To resolve this issue, we advise you to get your mobile number linked with the Aadhaar at the earliest and upload the latest Aadhaar Card on the link given below.<br>
".$_GET["cid"]."
<br><br>
Note : 
For updating your mobile number in the Aadhaar Database, you need to visit nearest Aadhaar Centre :
<br>
Click here to know the nearest Aadhaar Centre in your locality <a href='https://appointments.uidai.gov.in/EACenterSearch.aspx?value=2'>https://appointments.uidai.gov.in/EACenterSearch.aspx?value=2</a>
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
