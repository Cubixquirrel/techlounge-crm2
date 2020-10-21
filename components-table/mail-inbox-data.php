<?php
ini_set('max_execution_time', '0');

$mailboxPath = '{imap.gmail.com:993/imap/ssl}INBOX';
$username = 'kfsdeveloper2@gmail.com';
$password = 'Kaloree_1';
$imap = imap_open($mailboxPath, $username, $password);
// echo $numMessages = imap_num_msg($imap);

$folders = imap_list($imap, "{imap.gmail.com:993/imap/ssl}", "*");
?><ul><?php
foreach ($folders as $folder) {
    $folder = str_replace("{imap.gmail.com:993/imap/ssl}", "", imap_utf7_decode($folder));
    ?><li><?php echo $folder; ?></li><?php
}
?></ul><?php

$emailData = imap_search($imap, 'ALL');
$emailData = array_reverse($emailData);
$emailData = imap_sort($imap, SORTDATE, 1);
foreach ($emailData as $emailIdent) {
    $header = imap_header($imap, $emailIdent);

    $fromInfo = $header->from[0];
    $replyInfo = $header->reply_to[0];

    $details = array(
        "fromAddr" => (isset($fromInfo->mailbox) && isset($fromInfo->host))
            ? $fromInfo->mailbox . "@" . $fromInfo->host : "",
        "fromName" => (isset($fromInfo->personal))
            ? $fromInfo->personal : "",
        "replyAddr" => (isset($replyInfo->mailbox) && isset($replyInfo->host))
            ? $replyInfo->mailbox . "@" . $replyInfo->host : "",
        "replyName" => (isset($replyTo->personal))
            ? $replyto->personal : "",
        "subject" => (isset($header->subject))
            ? $header->subject : "",
        "date" => (isset($header->date))
            ? $header->date : ""
    );

    $date = date("d-m-Y H:i:s", strtotime($details["date"]));
    $uid = imap_uid($imap, $emailIdent);
    ?>
    <ul>
        <li>
            <strong>UID: </strong><?php echo $uid; ?>
        </li>
        <li>
            <strong>From: </strong><?php echo $details['fromName'].' '.$details['fromAddr']; ?>
        </li>

        <li>
            <strong>Subject: </strong><?php echo $details['subject']; ?>
        </li>

        <li>
            <strong>Date: </strong><?php echo $date; ?>
        </li>
    </ul>
    <?php
}
?>