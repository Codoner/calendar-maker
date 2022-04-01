<!-- sidebar menu -->
<br /><br /><br />
<div id="sidebar-menu" class="main_menu_side hidden-print main_menu">
    <div class="menu_section">
        <h3>General</h3>
        <ul class="nav side-menu">
            <li><a href="<?php echo _DIR_BE?>/index.php"><i class="fa fa-dashboard"></i> Dashboard </a></li>
            <li><a><i class="fa fa-calendar"></i> Calendar <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo _DIR_BE?>/new-calendar.php">New calendar</a></li>
                    <li><a href="<?php echo _DIR_BE?>/list-calendar.php">List calendars</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-gears"></i> Settings <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo _DIR_BE?>/change-password.php">Change password</a></li>
                </ul>
            </li>
            <li><a><i class="fa fa-book"></i> Help <span class="fa fa-chevron-down"></span></a>
                <ul class="nav child_menu">
                    <li><a href="<?php echo _DIR_BE?>/docs/getting-started.php">Getting started</a></li>
                    <li><a href="<?php echo _DIR_BE?>/docs/new-calendar-instance.php">New calendar instance</a></li>
                    <li><a href="<?php echo _DIR_BE?>/docs/language-customization.php">Language customization</a></li>
                    <li><a href="<?php echo _DIR_BE?>/docs/import-export.php">Import / Export calendar events</a></li>
                    <li><a href="<?php echo _DIR_BE?>/docs/categories-and-fields.php">Custom categories and fields</a></li>
                    <li><a href="<?php echo _DIR_BE?>/docs/plugin-functions.php">Plugin functions</a></li>
                    <li><a href="<?php echo _DIR_BE?>/docs/licenses.php">Open source components</a></li>
                </ul>
            </li>            
            <li><a href="<?php echo LOGOUT_PAGE?>"><i class="fa fa-sign-out"></i> Log out</a></li>
        </ul>
    </div>
</div>
<!-- /sidebar menu -->