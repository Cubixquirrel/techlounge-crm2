<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function(event) {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                var response = JSON.parse(this.responseText);
                document.querySelector("#template-subject").value = response[0];
                document.querySelector("#template-message").innerHTML = response[1];
            }
        };

        var template = '<?php echo $template_name; ?>'.split(' ').join('-').toLowerCase();
        xhttp.open("GET", "../template/email/"+template+".php?type=<?php echo $template_name; ?>", true);
        xhttp.send();
    });
</script>
<div class="edit-template-form">
    <div class="edit-template-form-group">
        <input type="text" placeholder="Name" id="template-name" value="<?php echo $template_name; ?>" autocomplete="off">
    </div>

    <div class="edit-template-form-group">
        <input type="text" placeholder="Subject" id="template-subject" autocomplete="off">
    </div>

    <div class="edit-template-form-group">
        <textarea placeholder="Mail Body" id="template-message" cols="30" rows="10" autocomplete="off"></textarea>
    </div>

    <div class="edit-template-form-group stage-box">
        <?php
        $sql_select_business = 'SELECT * FROM business WHERE business_name = "'.$business_name.'" ORDER BY stage_order ASC';
        $result_select_business = $conn->query($sql_select_business);
        if ($result_select_business->num_rows > 0) {
            while ($row_select_business = $result_select_business->fetch_assoc()) {
                $business = $row_select_business['business_name'];

                if ($row_select_business['stage'] == $business_stage) {
                    ?>
                    <span class="active" stage-data-selected="true" stage-data="<?php echo $row_select_business['stage']; ?>" onclick="selectStage('<?php echo $row_select_business['stage']; ?>')"><?php echo $row_select_business['stage']; ?></span>
                    <?php
                } else {
                    ?>
                    <span stage-data="<?php echo $row_select_business['stage']; ?>" onclick="selectStage('<?php echo $row_select_business['stage']; ?>')"><?php echo $row_select_business['stage']; ?></span>
                    <?php
                }
            }
        }
        ?>
        <span class="add-business" onclick="addStage()">+ Add Stage</span>
    </div>

    <button class="update-button" onclick="updateTemplate('<?php echo $_GET['templateId']; ?>')">Update</button>
</div>