<div class="add-template-form">
    <div class="add-template-form-group">
        <input type="text" placeholder="Name" id="template-name" autocomplete="off">
    </div>

    <div class="add-template-form-group">
        <input type="text" placeholder="Subject" id="template-subject" autocomplete="off">
    </div>

    <div class="add-template-form-group">
        <textarea placeholder="Mail Body" id="template-message" cols="30" rows="10" autocomplete="off"></textarea>
    </div>

    <div class="add-template-form-group stage-box">
        <?php        
        if ($result_select_business->num_rows > 0) {
            while ($row_select_business = $result_select_business->fetch_assoc()) {
                $business = $row_select_business['business_name'];
                $business_stage = $row_select_business['stage'];
                ?>
                <span stage-data="<?php echo $business_stage; ?>" onclick="selectStage('<?php echo $business_stage; ?>')"><?php echo $business_stage; ?></span>
                <?php
            }
        }
        ?>
        <span class="add-business" onclick="addStage()">+ Add Stage</span>
    </div>

    <button class="add-button" onclick="addTemplate('<?php echo $_GET['businessId']; ?>')">Add</button>
</div>