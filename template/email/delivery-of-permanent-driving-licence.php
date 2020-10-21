<?php

if (isset($_GET["cid"])) {
    $_GET["cid"] = $_GET["cid"];
} else {
    $_GET["cid"] = "";
}

$processor_email = [    
"Delivery of Permanent Driving Licence" => [
"subject" => "Your Permanent Licence Appointment - Acknowledgement Attached",
"message" => 
"Dear  Sir / Ma'am,
<br><br>
Congratulations!!<br>
Your Permanent Licence (DL) Application has been done and acknowledgment for the same has been attached herewith. Following Attachments are being sent for your perusal.<br><br>

1. Copy of Duly filled Application Form,<br>
2. Driving Licence Acknowledgement Slip,<br>
3. Form 1,<br>
4. Form 1A.<br>
<br>

<div style='background: #005ea5; color: #ffffff; padding: 10px'>
Your application is submitted for processing and quote this Application Number: <span class='dl-application-number-box' style='font-weight: 700; text-transform: uppercase'>______________________</span> for all future reference.
<br>
An SMS has been sent to your mobile <span class='form-mobile-number-box' style='font-weight: 700; text-transform: uppercase'>______________________</span>.
<br><br>
Note
<br>
1: Applicant should take print out of the Application Form (pre filled) and duly signed with all required Documents to be concerned RTO office.
<br><br>
<strong>
2: The online facility of application submission, upload documents, payment of fees, slot
booking etc., does not complete the process of issue of Driving Licence or any other Service requested.
The applicant has to compulsorily visit the concerned Road Transport Office to finish the process of issue
of Driving Licence and/or any other associated services.
</strong>
<br><br>
3: Applicants are requested to note that after completion of all stages mentioned under
'Applicant Stages', the applicant has to visit the concerned Road Transport Office on the scheduled date
of appointment, along with the necessary documents to complete the remaining process (or) In cases
where online slot booking facility is not available for any particular RTO, the applicant has to go to the
concerned Road Transport Office at the earliest along with the necessary documents, to complete the
remaining process.
</div>
<br>
For complaint / suggestions / queries related: https://licencewala.com/complaint-form.php
<br><br>
Regards,<br>
Processing Team<br><br>

<div style='background: #005ea5; color: #ffffff; padding: 10px'>
** This is an automatically generated email, please do not reply to it.<br>
© Content Owned and Maintained by Licence Wala (<a href='https://licencewala.com/' style='color: #ffffff;'>licencewala.com</a>)</div>
"
]
];

$type = $_GET["type"];

$subject = array($processor_email)[0][$type]["subject"];
$message = array($processor_email)[0][$type]["message"];

echo json_encode(array($subject, $message));

?>
