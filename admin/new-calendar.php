<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/../assets/vendors/calendarmaker/class/calendarMaker.php';

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
                            <h2 class="title_card"><i class="fa fa-calendar green"></i>New calendar <small>Create a new calendar</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />

                            <div data-string="&#xf073" class="col-md-2 col-sm-2 hidden-xs filigrana-2col"></div>
                            <div class="col-md-10 col-sm-10 col-xs-12">

                                <form id="frmNewCal" action="#" method="post" data-parsley-validate class="form-horizontal form-label-left">

                                    <div class="row">
                                        
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Calendar name <span class="required">*</span></label>
                                            <div class="col-md-5 col-sm-5 col-xs-12">
                                                <input type="text" class="form-control" id="calendarName" name="calendarName" placeholder="Your calendar name" value="" autocomplete="off" required="" />
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
                                                    <input type="text" class="form-control" id="colorTx" name="colorTx" value="<?php echo TEXT_COLOR; ?>" />
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-text-color"></i></span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Default background color</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div id="cp2" class="input-group">
                                                    <span class="input-group-addon"><i></i></span>
                                                    <input type="text" class="form-control" id="colorBg" name="colorBg" value="<?php echo BG_COLOR; ?>" />
                                                    <span class="input-group-addon"><i class="glyphicon glyphicon-text-background"></i></span>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Categories</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="categories" name="categories" type="text" class="tags form-control" value="" />
                                                <div id="suggestions-container" name="suggestions-container" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                            </div>
                                        </div>
                                        
                                        <div class="control-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Custom fields</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <input id="categories" name="custom" type="text" class="tags form-control" value="" />
                                                <div id="suggestions-container2" name="suggestions-container2" style="position: relative; float: left; width: 250px; margin: 10px;"></div>
                                            </div>
                                        </div>                                        

                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12">Description</label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <textarea id="calendarDesc" name="calendarDesc" rows="8" placeholder="Describe your calendar purpose" class="form-control col-md-7 col-xs-12"></textarea>
                                            </div>
                                        </div>                                
                                        <div class="form-group">
                                            <label class="control-label col-md-3 col-sm-3 col-xs-12"></label>
                                            <div class="col-md-9 col-sm-9 col-xs-12">
                                                <div class="center-block"><button type="submit" id="btnNewCal" class="buttonAction save">Save calendar</button></div>
                                            </div>
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
            var cal = $.fn.calendarMaker();
            var selectedLocaleCode = '<?php echo DEF_LANG ?>';
            var localeSelectorEl = document.getElementById('calendarLang');

            cal.getLocaleCodes().forEach(function(localeCode) {
                var optionEl = document.createElement('option');
                optionEl.value = localeCode;
                optionEl.selected = localeCode === selectedLocaleCode;
                optionEl.innerText = localeCode;
                if(localeSelectorEl) { localeSelectorEl.appendChild(optionEl); }
            });
        });

    </script>    

    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.js"></script>
    <script type="text/javascript">
    
    	$(document).ready(function() {
            $('#cp1').colorpicker({format: 'hex', align: 'left'});
            $('#cp2').colorpicker({format: 'hex', align: 'left'});
            init_TagsInput();
        });

        function init_TagsInput() {
            if(typeof $.fn.tagsInput !== 'undefined'){	
                $('#categories, #custom').tagsInput({
                  width: 'auto'
                });
            }
        }; 

        // Save new calendar
        $('#frmNewCal').on("submit", function(event){

            event.preventDefault();
            $('#btnNewCal').replaceWith('<button id="btnNewCal" type="button" class="buttonAction saving">Saving ...</button>');

            $.ajax({
                url: './ajax/$_new_calendar.php', data : $('#frmNewCal').serialize(), cache : false, type : 'post', dataType: 'json',
                success : function (data) {
                    if(data.status){
                        location.href = '<?php echo _DIR_BE ?>/list-calendar.php';
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
