<?php 

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/../../assets/vendors/calendarmaker/class/calendarMaker.php';

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
$cA->accessPage();

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo TITLE_APP ?> :: <?php echo COMPANY_APP ?></title>
    
    <!-- Bootstrap -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- NProgress -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Prism -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/prism/prism.css" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="<?php echo APPLICATION_PATH?>/assets/css/custom.min.css" rel="stylesheet">   

  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="<?php echo _DIR_BE ?>/index.php" class="site_title"><i class="fa fa-home"></i> <span>Calendar Maker</span></a>
            </div>

            <div class="clearfix"></div>

            <?php include_once ( __ROOT__ . "/../../../admin/inc/quick-info.php");?>
            <?php include_once ( __ROOT__ . "/../../../admin/inc/sidebar-menu.php");?>
            <?php include_once ( __ROOT__ . "/../../../admin/inc/menu-footer-buttons.php");?>
            
          </div>
        </div>

        <?php include_once ( __ROOT__ . "/../../../admin/inc/top-navigation.php");?>

        <div class="right_col" role="main">

            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="title_card"><i class="fa fa-book green"></i>Getting started <small><?php echo TITLE_APP ?></small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />

                            <div data-string="&#xf02d" class="col-md-2 col-sm-2 hidden-xs filigrana-2col"></div>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                <div class="col-md-12"><h4>Introduction</h4></div>
                                <div class="col-md-12">
                    <?php echo TITLE_APP ?> multingual extends the functionalities of the latest version of the FullCalendar (5.3.2),
                    the most popular and completed JavaScript Calendar <a class="linkDoc in" title="open source components" href="<?php echo APPLICATION_PATH?>/admin/docs/licenses.php">open source</a>.
                    It consists of a plugin jQuery (calendarMaker.js) and a PHP class (calendarMaker.php) which makes available both the main 
                    functions used for Calendar management such as entry, modifying and deleting events, and authentication ones, 
                    since our solution is fully manageable by one or more administrators through the backend private area. <br>
                    <?php echo TITLE_APP ?> is a complete and fully customizable software solution that allows to manage infinite 
                    Calendars in any language with simple or recurring events. 
                    Each calendar can be used for numerous activities (blogs, events, travels, reservationes, etc..) and is different 
                    contexts thanks to the possibility of associating categories customized fields.
                    All events, both proprietary and imported can be filtered by categories and/or keywords to facilitates the search. <br><br>                                    
                                </div>
                                <div class="col-md-12"><h4>Requirements</h4></div>
                                <div class="col-md-12">
                                    <ul>
                                        <li>PHP 5.6+</li>
                                        <li>PDO PHP Extension</li>
                                        <li>MySQL 5.x</li>
                                    </ul>
                                </div>
                                <div class="col-md-12"><h4>Features</h4></div>
                                <div class="col-md-12">
                                    <ul>
                                        <li>Multi-Language, Fully Customized</li>
                                        <li>100% Responsive Design</li>
                                        <li>Powerful Admin Panel</li>
                                        <li>Create unlimited calendar</li>
                                        <li>Add/Edit/Delete/View/Export/Update calendar events</li>
                                        <li>Rules Implemented for Recurring Events</li>
                                        <li>WYSIWYG editor for Events Description</li>
                                        <li>Create Custom Categories</li>
                                        <li>Create Custom Fields</li>
                                        <li>Toolbar for Search/Filter Events</li>
                                        <li>Toolbar for Import/Export Calendars</li>
                                        <li>Update Events on Drag and Resize</li>
                                        <li>Export Calendar or Events to ICAL format</li>
                                        <li>PHP & JS Versions with PHP Class</li>
                                        <li>UTF-8 Ready</li>                                        
                                        <li>Easy to Install</li>
                                        <li>Demo Included</li>
                                        <li>Documentation Included</li>
                                    </ul>
                                </div>
                                <div class="col-md-12"><h4>Tools and libraries used</h4></div>
                                <div class="col-md-12">
                                    <ul>
                                        <li>FullCalendar v5.3.2</li>
                                        <li>jQuery v2.2.3</li>
                                        <li>Bootstrap v3.3.6</li>
                                    </ul>
                                </div>

                            </div>
                      </div>
                    </div>
                </div>
            </div>            
            
        </div>

        <?php include_once ( __ROOT__ . "/../../../admin/inc/footer.php");?>
      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- NProgress -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/nprogress/nprogress.js"></script>
    <!-- Prism -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/prism/prism.js"></script>    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.min.js"></script>

  </body>
</html>