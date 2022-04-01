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
$cals = $cA->getCalendar($uuid);

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
    <!-- Bootstrap-colorpicker -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet" />
    <!-- jQuery confirm -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/jquery-confirm/dist/jquery-confirm.min.css" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="<?php echo APPLICATION_PATH?>/assets/css/custom.min.css" rel="stylesheet">
    <style type="text/css">
        span.tag {
            -moz-border-radius: 2px;
            -webkit-border-radius: 2px;
            display: block;
            float: left;
            padding: 5px 9px;
            text-decoration: none;
            background: #7da800;
            color: #F1F6F7;
            margin-right: 5px;
            font-weight: 500;
            margin-bottom: 5px;
            font-family: helvetica
        }
        span.tag a {
            color: #F1F6F7 !important
        }
        .tagsinput span.tag a {
            font-weight: bold;
            color: #82ad2b;
            text-decoration: none;
            font-size: 11px
        }
        .tagsinput input {
            width: 80px;
            margin: 0px;
            font-family: helvetica;
            font-size: 13px;
            border: 1px solid transparent;
            padding: 3px;
            background: transparent;
            color: #000;
            outline: 0px
        }
        .tagsinput div {
            display: block;
            float: left
        }
        .tag {
            line-height: 1;
            background: #7da800;
            color: #fff !important
        }
        .tag:after {
            content: " ";
            height: 30px;
            width: 0;
            position: absolute;
            left: 100%;
            top: 0;
            margin: 0;
            pointer-events: none;
            border-top: 14px solid transparent;
            border-bottom: 14px solid transparent;
            border-left: 11px solid #7da800
        }        
    </style>
  </head>

  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        <div class="col-md-3 left_col">
          <div class="left_col scroll-view">
            <div class="navbar nav_title" style="border: 0;">
              <a href="index.php" class="site_title"><i class="fa fa-home"></i> <span>Calendar Maker</span></a>
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
                    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Search for...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">Go!</button>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="title_card"><i class="fa fa-calendar green"></i>Edit calendar <small>Modify calendar settings</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li class="dropdown">
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#">Settings 1</a></li>
                                        <li><a href="#">Settings 2</a></li>
                                    </ul>
                                </li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />

                            <div data-string="&#xf073" class="col-md-2 col-sm-2 hidden-xs filigrana-2col"></div>
                            <div class="col-md-10 col-sm-10 col-xs-12">
                                
                                <?php if($cals['status'] === false){ ?>
                                <div class="form-group">
                                    <label class="control-label col-md-3 col-sm-3 col-xs-12" for="last-name">&nbsp;</label>
                                    <div class="col-md-9 col-sm-9 col-xs-12">
                                        <div class="alert alert-error" role="alert"><?php echo "Error getting calendar info : ".$cals['msg']; ?></div>
                                    </div>
                                </div>
                                <?php } ?>
                                
                                <form id="frmEditCal" action="#" method="post" data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="calendarUUID" value="<?php echo $cals['calendar']['uuid']?>" />

                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Calendar name <span class="required">*</span></label>
                                        <div class="col-md-5 col-sm-5 col-xs-12">
                                            <input type="text" class="form-control" id="calendarName" name="calendarName" placeholder="Your calendar name" value="<?php echo $cals['calendar']['name']?>" autocomplete="off" required="" />
                                        </div>
                                        <label class="control-label col-md-2 col-sm-2 col-xs-12">Language </label>
                                        <div class="col-md-2 col-sm-2 col-xs-12">
                                            <select class="form-control" id="calendarLang" name="calendarLang"></select>                                                
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Default text color</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <div id="cp1" class="input-group colorpicker-component">
                                                <span class="input-group-addon"><i></i></span>
                                                <input type="text" id="colorTx" name="colorTx" value="<?php echo $cals['calendar']['textColor']?>" class="form-control" />
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-text-color"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Default background color</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <div id="cp2" class="input-group">
                                                <span class="input-group-addon"><i></i></span>
                                                <input type="text" id="colorBg" name="colorBg" value="<?php echo $cals['calendar']['bgColor']?>" class="form-control" />
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-text-background"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Categories</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input id="categories" name="categories" type="text" class="tags form-control" value="<?php echo $cals['calendar']['categories']?>" />
                                            <div id="suggestions-container" name="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Custom fields</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">
                                            <input id="categories" name="custom" type="text" class="tags form-control" value="<?php echo $cals['calendar']['customFields']?>" />
                                            <div id="suggestions-container2" name="suggestions-container2" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">

                                            <textarea id="calendarDesc" name="calendarDesc" rows="8" class="form-control col-md-7 col-xs-12"><?php echo $cals['calendar']['description']?></textarea>

                                        </div>
                                    </div>                                
                                    <div class="form-group">
                                        <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                        <div class="col-md-9 col-sm-9 col-xs-12">

                                            <div class="center-block"><button type="submit" id="btnEditCal" class="buttonAction save"<?php if($cals['calendar']['uuid']==""){ echo ' disabled=""';}?>>Update calendar</button></div>

                                        </div>
                                    </div>

                                </form>

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
    <!-- Bootstrap-colorpicker -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
    <!-- jQuery Tags Input -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Moment -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/moment/moment-with-locales.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/moment-timezone/moment-timezone-with-data.min.js"></script>
    <!-- Fullcalendar -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/main.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/locales-all.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/rrule.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/fullcalendar/lib/main.global.min.js"></script>
    <!-- Calendarmaker -->
    <script id="caljs" src="<?php echo APPLICATION_PATH?>/assets/vendors/calendarmaker/calendarMaker.min.js"></script>    
    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.min.js"></script>
    
    <script type="text/javascript">
    
        document.addEventListener('DOMContentLoaded', function() {

            $('#cp1').colorpicker({format: 'hex', align: 'left'});
            $('#cp2').colorpicker({format: 'hex', align: 'left'});
            init_TagsInput();

            var cal = $.fn.calendarMaker();
            var selectedLocaleCode = '<?php echo $cals['calendar']['language']?>';
            var localeSelectorEl = document.getElementById('calendarLang');

            cal.getLocaleCodes().forEach(function(localeCode) {
                var optionEl = document.createElement('option');
                optionEl.value = localeCode;
                optionEl.selected = localeCode === selectedLocaleCode;
                optionEl.innerText = localeCode;
                if(localeSelectorEl) { localeSelectorEl.appendChild(optionEl); }
            });

        });

        function init_TagsInput() {
            if(typeof $.fn.tagsInput !== 'undefined'){	
                $('#categories, #custom').tagsInput({
                  width: 'auto'
                });
            }
        }; 
        
        // Update calendar
        $('#frmEditCal').on("submit", function(event){

            event.preventDefault();
            $('#btnEditCal').replaceWith('<button id="btnEditCal" type="button" class="buttonAction saving" disabled>Saving ...</button>');
            
            $.ajax({
                url: '<?php echo _DIR_BE ?>/ajax/$_update_calendar.php', data : $('#frmEditCal').serialize(), cache : false, type : 'post', dataType: 'json',
                success : function (data) {
                    if(data.status){
                        location.href = '<?php echo _DIR_BE?>/list-calendar.php';
                    }else{
                        alert("error : "+data.msg);
                    }
                },
                error: function (error) {
                    alert( error );
                }
            });

            return false;
        });

    </script>	
  </body>
</html>