<div class="sidebar-shadow" onclick="swapSidebar('close')"></div>

<div class="sidebar-main" id="sidebar">
    <div class="header">
        <div class="sidebar-header-flex-left">
            <i class="user-icon icon-user1"></i>
            <span class="sidebar-user-text"><?php echo $user_name; ?></span>
        </div>

        <div class="sidebar-header-flex-right">
            <i class="icon-x-circle sidebar-menu-close" id="sidebar-menu-close" onclick="swapSidebar('close')"></i>
        </div>
    </div>

    <div class="body">
        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Processor', explode(',', $row_select_user['user_role']))) OR (in_array('Sales', explode(',', $row_select_user['user_role']))) OR (in_array('Complaint', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="master-data-menu" onclick="openViews('dashboard.php')">
            <div class="list-left">
                <i class="icon-box list-icon"></i>
                <span class="list-menu">Dashboard</span>
            </div>
            
            <?php if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) { ?>
            <div class="list-right">
                <span class="list-count"><?php echo $row_count_master[0]; ?></span>
            </div>
            <?php } ?>
        </div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Complaint', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="complaint-data-menu" onclick="openViews('complaint.php')">
            <div class="list-left">
                <i class="icon-info2 list-icon"></i>
                <span class="list-menu">Complaint</span>
            </div>

            <div class="list-right">
                <span class="list-count"><?php echo $row_count_complaint[0]; ?></span>
            </div>
        </div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Sales', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="lead-data-menu" onclick="openViews('lead.php')">
            <div class="list-left">
                <i class="icon-edit1 list-icon"></i>
                <span class="list-menu">Lead</span>
            </div>

            <div class="list-right">
                <span class="list-count"><?php echo $row_count_lead[0]; ?></span>
            </div>
        </div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Sales', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="follow-up-data-menu" onclick="openViews('follow-up.php')">
            <div class="list-left">
                <i class="icon-thumbs-up1 list-icon"></i>
                <span class="list-menu">Follow Up</span>
            </div>

            <div class="list-right">
                <span class="list-count"><?php echo $row_count_follow_up[0]; ?></span>
            </div>
        </div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Sales', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="dropped-data-menu" onclick="openViews('dropped.php')">
            <div class="list-left">
                <i class="icon-trash-2 list-icon"></i>
                <span class="list-menu">Dropped</span>
            </div>

            <div class="list-right">
                <span class="list-count"><?php echo $row_count_dropped[0]; ?></span>
            </div>
        </div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Sales', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="paid-data-menu" onclick="openViews('paid.php')">
            <div class="list-left">
                <i class="icon-check-circle list-icon"></i>
                <span class="list-menu">Paid</span>
            </div>

            <div class="list-right">
                <span class="list-count"><?php echo $row_count_paid[0]; ?></span>
            </div>
        </div>
        <?php } ?>

        <?php if ((in_array('Processor', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="pending-data-menu" onclick="openViews('pending.php')">
            <div class="list-left">
                <i class="icon-file list-icon"></i>
                <span class="list-menu">Pending</span>
            </div>

            <div class="list-right">
                <span class="list-count"><?php echo $row_count_pending[0]; ?></span>
            </div>
        </div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="border"></div>

        <div class="sidebar-list" id="users-data-menu" onclick="openViews('users.php')">
            <div class="list-left">
                <i class="icon-users list-icon"></i>
                <span class="list-menu">Manage Users</span>
            </div>

            <div class="list-right">
                <span class="list-count"><?php echo $row_count_users[0]; ?></span>
            </div>
        </div>

        <div class="sidebar-list" id="businesses-data-menu" onclick="openViews('businesses.php')">
            <div class="list-left">
                <i class="icon-briefcase list-icon"></i>
                <span class="list-menu">Manage Businesses</span>
            </div>

            <div class="list-right">
                <span class="list-count"><?php echo $row_count_business[0]; ?></span>
            </div>
        </div>

        <div class="border"></div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="campaign-data-menu" onclick="openViews('campaign.php')">
            <div class="list-left">
                <i class="icon-tv list-icon"></i>
                <span class="list-menu">Campaign</span>
            </div>
        </div>

        <div class="border"></div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) { ?>
        <!-- <div class="sidebar-list" id="mail-inbox-data-menu" onclick="openViews('mail-inbox.php')">
            <div class="list-left">
                <i class="icon-inbox list-icon"></i>
                <span class="list-menu">Mail Inbox</span>
            </div>
        </div>

        <div class="border"></div> -->
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role']))) OR (in_array('Editor', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="analytics-data-menu" onclick="openViews('analytics.php')">
            <div class="list-left">
                <i class="icon-line-graph list-icon"></i>
                <span class="list-menu">Analytics</span>
            </div>
        </div>

        <div class="border"></div>
        <?php } ?>

        <?php if ((in_array('Admin', explode(',', $row_select_user['user_role'])))) { ?>
        <div class="sidebar-list" id="payment-reports-data-menu" onclick="openViews('payment-reports.php')">
            <div class="list-left">
                <i class="icon-pie_chart_outlined list-icon"></i>
                <span class="list-menu">Payment Reports</span>
            </div>
        </div>

        <div class="sidebar-list" id="merge-client-data-menu" onclick="openViews('merge-client.php')">
            <div class="list-left">
                <i class="icon-repeat1 list-icon"></i>
                <span class="list-menu">Merge Client</span>
            </div>
        </div>
        <?php } ?>
    </div>
</div>

<div class="header-flex">
    <div class="header-left-flex">
        <i class="icon-menu header-menu" id="sidebar-menu-open" onclick="swapSidebar('open')"></i>
        
        <div class="body-heading">
            <span><?php echo $page_title; ?></span>
        </div>

        <?php
        if (
            ($page_title == 'Dashboard') OR 
            ($page_title == 'Lead') OR 
            ($page_title == 'Follow Up') OR 
            ($page_title == 'Dropped') OR 
            ($page_title == 'Paid') OR 
            ($page_title == 'Pending') OR 
            ($page_title == 'Complaint') OR 
            ($page_title == 'Analytics') OR 
            ($page_title == 'Payment Reports') OR 
            ($page_title == 'Mail Inbox')
        ) {
        ?>
        <span class="open-filter" onclick="swicthFilter()">Open Filter</span>
        <?php
        }
        ?>
    </div>

    <div class="header-flex-right">
        <button class="logout-button" onclick="logout()">Log Out</button>
    </div>
</div>