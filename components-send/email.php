<?php
$sql_select_forms = 'SELECT * FROM forms WHERE id = "'.$_GET["clientId"].'"';
$result_select_forms = $conn->query($sql_select_forms);
$row_select_forms = $result_select_forms->fetch_assoc();
$business = $row_select_forms['business'];
$website = $row_select_forms['website'];
$from_email_id = 'order@'.strtolower($website);
?>
<form role="form">
    <div class="form-body">
        <div class="form-group">
            <label>From</label>
            <select class="custom-select" name="emailId">
                <option value="<?php echo $from_email_id; ?>" selected><?php echo $from_email_id; ?></option>
            </select>
        </div>
        <div class="form-group">
            <label>Template</label>
            <select class="custom-select" name="messageId" onchange="updateMessage('<?php echo $_GET['type']; ?>')">
                <option value="">-- Select Template --</option>
                <?php
                    $sql = "SELECT * FROM ".$_GET['type']." WHERE FIND_IN_SET('".$business."', team)";
                    $result = $conn->query($sql);
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            ?><option value="<?php echo $row['id']; ?>"><?php echo $row['template']; ?></option><?php
                        }
                    };
                ?>
            </select>
        </div>
        <div class="form-group">
            <label>Message</label>
            <textarea class="form-control" rows="4" placeholder="" readonly></textarea>
        </div>
    </div>

    <div class="form-footer">
        <input type="hidden" name="clientId" value="<?php echo $_GET['clientId']; ?>">
        <button type="button" class="send-button" id="send-<?php echo $_GET['type']; ?>" onclick="sendMessage('<?php echo $_GET['type']; ?>'), updateTimeline('<?php echo $_GET['type']; ?>');">Send</button>
    </div>
</form>