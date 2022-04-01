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
                <a href="/calendarmaker/" class="site_title"><span>Tools Makers</span></a>
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
                            <h2 class="title_card"><i class="fa fa-book green"></i>Open Source components <small><?php echo TITLE_APP ?></small></h2>
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
                                
                                <div class='col-md-12'>
                                <?php echo TITLE_APP ?> utilized Open Source components, here’s a list of the components and their licenses :
                                
                                <br><br>
                                <ul>
                                    <li>FullCalendar : Full-sized drag & drop event calendar</li> (<a href="https://github.com/fullcalendar/fullcalendar"><code>https://github.com/fullcalendar/fullcalendar</code></a>) licensed under <a href="https://github.com/fullcalendar/fullcalendar/blob/master/LICENSE.txt"><code>MIT</code></a></code>
                                    <li>MomentPHP : MomentPHP is library for parsing, manipulating and formatting dates</li> (<a href="https://github.com/Lawondyss/MomentPHP"><code>https://github.com/Lawondyss/MomentPHP</code></a>) licensed under <a href="https://github.com/Lawondyss/MomentPHP/blob/master/README.md"><code>GPL-3</code></a>
                                    <li>iCalcreator : PHP class package managing iCal formatted files</li> (<a href="https://github.com/iCalcreator/iCalcreator"><code>https://github.com/iCalcreator/iCalcreator</code></a>) licensed under <a href="https://github.com/Lawondyss/MomentPHP/blob/master/README.md"><code>LGPL-3.0</code></a>
                                    <li>jQuery : jQuery JavaScript Library</li> (<a href="https://github.com/jquery/jquery"><code>https://github.com/jquery/jquery</code></a>) licensed under <a href="https://github.com/jquery/jquery/blob/master/LICENSE.txt"><code>MIT</code></a>
                                    <li>jquery-confirm : A multipurpose plugin for alert, confirm & dialog, with extended features</li> (<a href="https://github.com/craftpip/jquery-confirm"><code>https://github.com/craftpip/jquery-confirm</code></a>) licensed under <a href="https://github.com/craftpip/jquery-confirm/blob/master/LICENSE"><code>MIT</code></a>
                                    <li>jquery-tagsinput : jQuery Tags Input Plugin</li> (<a href="https://github.com/khenfei/jquery-tagsinput"><code>https://github.com/khenfei/jquery-tagsinput</code></a>) licensed under <a href="https://github.com/khenfei/jquery-tagsinput/blob/master/LICENSE"><code>MIT</code></a>                                    
                                    <li>datatables : Tables plug-in for jQuery</li> (<a href="https://github.com/DataTables/DataTables"><code>https://github.com/DataTables/DataTables</code></a>) licensed under <a href="https://github.com/DataTables/DataTables/blob/master/license.txt"><code>MIT</code></a>
                                    <li>moment : Parse, validate, manipulate, and display dates in javascript</li> (<a href="https://github.com/moment/moment"><code>https://github.com/moment/moment</code></a>) licensed under <a href="https://github.com/moment/moment/blob/develop/LICENSE"><code>MIT</code></a>
                                    <li>moment-timezone : Timezone support for moment.js</li> (<a href="https://github.com/moment/moment-timezone/"><code>https://github.com/moment/moment-timezone/</code></a>) licensed under <a href="https://github.com/moment/moment-timezone/blob/develop/LICENSE"><code>MIT</code></a>                                    
                                    <li>bootstrap-datetimepicker : Date/time picker widget based on twitter bootstrap</li> (<a href="https://github.com/Eonasdan/bootstrap-datetimepicker"><code>https://github.com/Eonasdan/bootstrap-datetimepicker</code></a>) licensed under <a href="https://github.com/Eonasdan/bootstrap-datetimepicker/blob/master/LICENSE"><code>MIT</code></a>
                                    <li>bootstrap-wysiwyg : Tiny bootstrap-compatible WISWYG rich text editor</li> (<a href="https://github.com/mindmup/bootstrap-wysiwyg"><code>https://github.com/mindmup/bootstrap-wysiwyg</code></a>) licensed under <a href="https://github.com/mindmup/bootstrap-wysiwyg/blob/master/LICENSE"><code>MIT</code></a>
                                    <li>bootstrap-colorpicker : Bootstrap Colorpicker is a modular color picker plugin for Bootstrap</li> (<a href="https://github.com/itsjavi/bootstrap-colorpicker"><code>https://github.com/itsjavi/bootstrap-colorpicker</code></a>) licensed under <a href="https://github.com/itsjavi/bootstrap-colorpicker/blob/master/LICENSE"><code>MIT</code></a>
                                    <li>nprogress : For slim progress bars like on YouTube, Medium, etc</li> (<a href="https://github.com/rstacruz/nprogress"><code>https://github.com/rstacruz/nprogress</code></a>) licensed under <a href="https://github.com/rstacruz/nprogress/blob/master/License.md"><code>MIT</code></a>
                                    <li>prism : Lightweight, robust, elegant syntax highlighting</li> (<a href="https://github.com/PrismJS/prism"><code>https://github.com/PrismJS/prism</code></a>) licensed under <a href="https://github.com/PrismJS/prism/blob/master/LICENSE"><code>MIT</code></a>
                                    <li>hotkeys : jQuery Hotkeys Plugin</li> (<a href="https://github.com/jeresig/jquery.hotkeys"><code>https://github.com/jeresig/jquery.hotkeys</code></a>) licensed under <code>MIT/GPL2</code>
                                    <li>prettify : An embeddable script that makes source-code snippets in HTML prettier</li> (<a href="https://github.com/googlearchive/code-prettify"><code>https://github.com/googlearchive/code-prettify</code></a>) licensed under <a href="https://github.com/googlearchive/code-prettify/blob/master/COPYING"><code>Apache-2.0 License</code></a>
                                    <li>gentelella : Free Bootstrap 4 Admin Dashboard Template</li> (<a href="https://github.com/ColorlibHQ/gentelella"><code>https://github.com/ColorlibHQ/gentelella</code></a>) licensed under <a href="https://github.com/ColorlibHQ/gentelella/blob/master/LICENSE.txt"><code>MIT</code></a>
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
    <!-- prism -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/prism/prism.js"></script>    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.min.js"></script>      

  </body>
</html>
