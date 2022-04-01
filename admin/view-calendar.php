<?php 

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/../assets/vendors/calendarmaker/class/calendarMaker.php';

$uuid = filter_input(INPUT_GET, "uuid", FILTER_SANITIZE_STRING);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
$cA->accessPage();
$cal = $cA->getCalendar($uuid);

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
    <!-- Bootstrap-datetimepicker -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />    
    <!-- Bootstrap-colorpicker -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet" />
    <!-- jQuery confirm -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/jquery-confirm/dist/jquery-confirm.min.css" rel="stylesheet" />
    <!-- Fullcalendar -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/main.min.css" rel="stylesheet" />     
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
            
                <div class="page-title">
                    <div class="title_left">
                        <h3>&nbsp;</h3>
                    </div>
                    <div class="title_right">
                        <div class="form-group pull-right top_search">
                            <div class="input-group">
                                <input type="text" class="form-control" placeholder="Search for..." id="inputVal" autocomplete="off" />
                                <div class="input-group-btn">
                                    <button id="reset" class="btn btn-default" type="text" style="margin: 0; border: none">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>                                        
                                    <button id="search" class="btn btn-default" type="text" style="margin: 0; border: none">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>                                        
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="clearfix"></div>

                <div class="row">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="x_panel">
                            <div class="x_title">
                                <h2 class="title_card" data-toggle="tooltip" data-placement="top" title="<?php echo $cal['calendar']['description'] ?>"><i class="fa fa-calendar green"></i><?php echo $cal['calendar']['name'] ?> <small><?php echo $cal['calendar']['uuid'] ?></small></h2>
                                <ul class="nav navbar-right panel_toolbox">
                                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-gears"></i></a>
                                        <ul class="dropdown-menu" role="menu">
                                            <li><a href="<?php echo _DIR_BE ?>/edit-calendar.php?<?php echo $_SERVER['QUERY_STRING']?>">Edit calendar</a></li>
                                            <li><a id="resetCal" href="#">Reset calendar</a></li>
                                            <li><a id="import" href="#">Import calendar</a></li>
                                            <li><a id="export" href="#">Export calendar</a></li>
                                        </ul>
                                    </li>
                                    <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                                </ul>
                                <div class="clearfix"></div>
                                
                            </div>

                          <div class="x_content">

                            <div class="div-cal" id="calendar"></div>

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
    <!-- moment -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/moment/moment-with-locales.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/moment-timezone/moment-timezone-with-data.min.js"></script>
    <!-- datetimepicker -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <!-- bootstrap-colorpicker -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
    <!-- fullcalendar -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/main.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/locales-all.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/rrule.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/main.global.min.js"></script>  
    <!-- calendarmaker -->
    <script id="caljs" src="<?php echo APPLICATION_PATH?>/assets/vendors/calendarmaker/calendarMaker.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.js"></script>
    
    <script type="text/javascript">

        var cal;
        document.addEventListener('DOMContentLoaded', function() {
            cal = $.fn.calendarMaker({
                uuidCalendar: '<?php echo $cal['calendar']['uuid'] ?>',                         // required : uuid calendar
                divCal: 'calendar',                                                             // required : div id for calendar rendering
                divLoad: 'loading',                                                             // optional
                popOver: true,                                                                  // optional
                barSearch: {txtSearch: 'inputVal', btnSearch: 'search', btnReset: 'reset'},     // optional
                barImport: {btnReset: 'resetCal', btnImport: 'import', btnExport: 'export'}     // optional
            });
        });

    </script>
  </body>
</html>