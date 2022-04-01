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
    <!-- jQuery confirm -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/jquery-confirm/dist/jquery-confirm.min.css" rel="stylesheet" />
    <!-- Datatables -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/datatables/datatables.min.css" rel="stylesheet" />
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
                            <h2 class="title_card"><i class="fa fa-calendar green"></i>List calendars <small>Get a list of calendars</small></h2>
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

                                <table id="dataTable" class="table table-striped table-bordered dt-responsive nowrap" width="100%" cellspacing="0">
                                   <thead>
                                      <tr>
                                         <th>ID</th>
                                         <th>Name</th>
                                         <th>Lang</th>
                                         <th>TxColor</th>
                                         <th>BgColor</th>
                                         <th>Actions</th>
                                         <th>UUID</th>
                                      </tr>
                                   </thead>
                                </table>

                                <div class="center-block"><a href="<?php echo _DIR_BE ?>/new-calendar.php" class="buttonAction new">New calendar</a></div>
                                
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
    <!-- jQuery confirm -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/jquery-confirm/dist/jquery-confirm.min.js"></script>
    <!-- Datatables -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/datatables/datatables.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.min.js"></script>
    
    <script type="text/javascript">
    
    	$(document).ready(function() {

            $("#dataTable").DataTable({
                searching: false,
                paging: false,
                processing: true,
                language: {
                    processing: "<i class='fa fa-spinner fa-spin fa-3x fa-fw'></i><span class='sr-only'>Loading...</span> "
                },
                serverSide: false,
                ajax:{
                    url: "<?php echo _DIR_BE ?>/ajax/$_list_calendars.php",
                    type: "POST",
                    dataSrc: function ( json ) {
                        if(json.status){ 
                            return json.data;
                        }else{
                            alert(json.msg); return json.data;
                        }
                    }                     
                },
                deferRender: true,
                columns: [
                    { data: "ID" },
                    { data: "Name" },
                    { data: "Lang" },
                    { data: "TxColor" },
                    { data: "BgColor" },
                    { data: "Actions" },
                    { data: "UUID" }                    
                ],
                "columnDefs": [
                    { targets: 5, orderable: false },
                    { width: "300px", targets: 1 },
                    { className: "cell-center", targets: [2] }
                ],                        
                order: [[ 0, "desc" ]]
            });


        });


        function deleteCal(id, notifica){

            notifica = (typeof notifica !== "undefined") ?  notifica : 1;

            $.confirm({
                theme: "modern",
                closeIcon: true,
                animation: "zoom",
                closeAnimation: "scale",
                animateFromElement: false,
                type: "dark",
                columnClass: "col-md-4 col-sm-6 col-md-offset-4 col-sm-offset-3",
                containerFluid: true,
                title: "<h3 class='titlePopup'>Confirmation required</h3><br>",
                content : "By continuing, the selected calendar will be deleted with all the events and data associated with it.<br><br>Are you sure you want to continue ?<br>",
                buttons: {
                    confirm: {
                        text: "<i class='fa fa-trash-o'></i>&nbsp;&nbsp;Yes, delete",
                        btnClass: "btn-danger",
                        action: function () {
                            $.post("<?php echo _DIR_BE ?>/ajax/$_delete_calendar.php", { id: id, notifica: notifica}, function(response) {
                                if(response.stato === false) {
                                    $.alert({
                                        icon: "fa fa-times-circle red",
                                        title: "Error",
                                        theme: "modern",
                                        animation: "zoom",
                                        closeAnimation: "scale",
                                        animateFromElement: false,
                                        containerFluid: true,
                                        type: "dark",
                                        content: response.msg
                                    });
                                }else{
                                    $.alert({
                                        icon: "fa fa-check green",
                                        title: "Success",
                                        theme: "modern",
                                        animation: "zoom",
                                        closeAnimation: "scale",
                                        animateFromElement: false,
                                        containerFluid: true,
                                        type: "dark",
                                        content: response.msg,
                                        buttons: {
                                            confirm: {
                                                text: "Close",
                                                action: function () {
                                                    window.location.reload(true);
                                                }
                                            }
                                        }
                                    });
                                }
                            }, "json");
                        }
                    },
                    cancel: {
                        text: "Cancel",
                    }
                }
            });

        }

    </script>	
  </body>
</html>