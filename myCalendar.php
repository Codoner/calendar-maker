<?php 

namespace ToolsMakers;
require realpath(dirname(__FILE__)) . '/assets/vendors/calendarmaker/class/calendarMaker.php';

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    
    <title>Featured Calendar Maker v1.0</title>
    
    <!-- Bootstrap -->
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="./assets/vendors/bootstrap/dist/css/bootstrap-theme.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="./assets/vendors/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <!-- Bootstrap-datetimepicker -->
    <link href="./assets/vendors/datetimepicker/bootstrap-datetimepicker.min.css" rel="stylesheet" />
    <!-- Bootstrap-colorpicker -->
    <link href="./assets/vendors/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.css" rel="stylesheet" />
    <!-- Fullcalendar -->
    <link href="./assets/vendors/fullcalendar/lib/main.min.css" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="./assets/css/customFE.css" rel="stylesheet">
    </head>
    <body>

    <div class="container">
        <div class="navbar navbar-default navbar-fixed-top">
            <div class="navbar-inner">
                <div class="container">
                    <div class="row">
                        <div class="col-md-5 col-sm-7 col-xs-12 hidden-xs hidden-sm">
                            <a class="navbar-brand" href="index.php"><?php echo TITLE_APP ?></a>
                            <select class="btn dropdown-item" style="margin-top: 12px; float: left; text-align: left" id="calendarLang"></select>
                        </div>
                        <div class="col-md-4 col-sm-6 col-xs-7">
                            <span style="float: left; margin-top: 8px">
                                <button id="resetCal" type="button" class="btn btn-warning btn-block" disabled=""><i class="glyphicon glyphicon-calendar"></i></button>
                            </span>
                            <span style="float: left; margin-left: 5px; margin-top: 8px">
                                <button id="import" type="button" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-import"></i>&nbsp;Import</button>
                            </span>
                            <span style="float: left; margin-left: 5px; margin-top: 8px">
                                <button id="export" type="button" class="btn btn-primary btn-block"><i class="glyphicon glyphicon-export"></i>&nbsp;Export</button>
                            </span>
                        </div>
                        <div class="col-md-3 col-sm-6 col-xs-5">
                            <div class="input-group" style="margin-top: 8px; margin-bottom: 8px;">
                                <input type="text" class="form-control" placeholder="Search" id="inputVal" autocomplete="off" />
                                <div class="input-group-btn">
                                    <button id="reset" class="btn btn-primary" type="text">
                                        <span class="glyphicon glyphicon-remove"></span>
                                    </button>                                        
                                    <button id="search" class="btn btn-primary" type="text">
                                        <span class="glyphicon glyphicon-search"></span>
                                    </button>                                        
                                </div>                                    
                            </div>
                        </div>
                        <div class="col-md-12 col-sm-12 col-xs-12 right">
                            <span id="loading">loading...</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div style="margin-top: 80px; margin-bottom: 35px">
            <div id="script-warning" class="col-md-12 col-md-12 col-sm-12 col-xs-12 alert alert-danger">
                <strong>Error!</strong> Load events failed
            </div>
        </div>
        <div class="row">
            <div class="col-md-12" id="calendar"></div>
        </div>
        <div class="clearfix"><br></div>
    </div>
    <!-- jQuery -->
    <script src="./assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- Moment -->
    <script src="./assets/vendors/moment/moment-with-locales.min.js"></script>
    <script src="./assets/vendors/moment-timezone/moment-timezone-with-data.min.js"></script>
    <!-- Datetimepicker -->
    <script src="./assets/vendors/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <!-- Bootstrap-colorpicker -->
    <script src="./assets/vendors/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
    <!-- Fullcalendar -->
    <script src="./assets/vendors/fullcalendar/lib/main.min.js"></script>
    <script src="./assets/vendors/fullcalendar/lib/locales-all.min.js"></script>
    <script src="./assets/vendors/fullcalendar/lib/rrule.min.js"></script>
    <script src="./assets/vendors/fullcalendar/lib/main.global.min.js"></script>
    <!-- Calendarmaker -->
    <script id="caljs" src="./assets/vendors/calendarmaker/calendarMaker.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="./assets/js/custom.min.js"></script>
    <script type="text/javascript">
        var cal;
        document.addEventListener('DOMContentLoaded', function() {
            cal = $.fn.calendarMaker({
                uuidCalendar: 'xxxxxxxx-xxxx-xxxx-xxxx-xxxxxxxxxxxx',                           // required : uuid calendar identify
                divCal: 'calendar',                                                             // required : div id for calendar rendering
                divLoad: 'loading',                                                             // optional
                popOver: true,                                                                  // optional (default : false)
                readOnly: false,                                                                // optional (default : false)
                barSearch: {txtSearch: 'inputVal', btnSearch: 'search', btnReset: 'reset'},     // optional
                barImport: {btnReset: 'resetCal', btnImport: 'import', btnExport: 'export'},    // optional
                barLanguage: {selector: 'calendarLang', enabled: {all:''} }                     // optional
            });
        });
        
    </script>
</body>
</html>