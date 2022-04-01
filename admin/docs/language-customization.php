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
                            <h2 class="title_card"><i class="fa fa-book green"></i>Language customization <small><?php echo TITLE_APP ?></small></h2>
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
                                <div class="col-md-12"><h4>Multiply Language support</h4></div>
                                <div class='col-md-12'>
                                
                                <?php echo TITLE_APP ?> is a software with multi-language support functionality and is fully adaptable to any language
                                (fields and categories are also customized).
                                If the <a class="linkDoc in" title="new calendar instance" href="<?php echo APPLICATION_PATH?>/admin/docs/new-calendar-instance.php">barLanguage</a> toolbar is enabled, the user can choose to use one of the languages made available by the administrator
                                The files that contain the translations of the texts used in JSON format are found in the folder :
                                
                                <br><br>
                                
                                <blockquote><code>APPLICATION_PATH . "/assets/vendors/calendarmaker/resources/locales"</code></blockquote>
                                
                                In the "calendarMaker.php" configuration file, the English language is specified as the default (not editable).
                                The corresponding <code>en.json</code> file containing the texts of the English language is the only file that must always be present.
                                To make the calendar available in other languages, simply create or update the JSON file of the desired language by naming it with the syntax « language code ».json (e.g. <code>es.json</code> for Spanish, <code>fr.json</code> for French, <code>zh-cn.json</code> for Chinese, and so on)
                                <br>
                                The "custom" node of the tree contains the "categories" and "fields" sub-nodes each with the (case sensitive) key/value definitions referring to the cagegories and the custom fields of each calendar.
                                <br><br>
                                
<pre class="language-markup charDim">
<code>{
    "custom": {
        "categories": {
            "none":"Select category",
            "work":"Work",
            "funny":"Funny",
            "personal":"Personal",
            "training":"Training"
        },
        "fields":{
            "age":"Age",
            "gender":"Gender",
            "position":"Position"
        }
    },
    "core": {
        ....
    
</code></pre>
                                
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