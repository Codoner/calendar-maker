<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
header("cache-control: no-cache");
if(!isset($_SESSION)){ session_start(); }

require realpath(dirname(__FILE__)) . '/../assets/vendors/calendarmaker/class/calendarMaker.php';
if(!INSTALLED) { header("Location: ".INSTALL_PAGE); exit; }

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();

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
    <!-- Custom Theme Style -->
    <link href="<?php echo APPLICATION_PATH?>/assets/css/custom.min.css" rel="stylesheet">
    
  </head>
  <body class="nav-md">
    <div class="container body">
      <div class="main_container">
        
        <div class="right_col" role="main">
            
            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="title_card"><i class="fa fa-lock green"></i>Login <small>Access to administration area</small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="clearfix"><br /></div>

                            <div data-string="&#xf023" class="col-md-2 col-sm-2 hidden-xs filigrana-2col"></div>
                            <div class="col-md-10 col-sm-10 col-xs-12">

                                <form id="frmCheckLogin" action="#" method="post" data-parsley-validate class="form-horizontal form-label-left">
                                    <div class="row" style="padding-top: 50px">
                                        <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">

                                            <div class="form-group">
                                                <label for="form-create-account-email">Username</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Type your username" value="" autocomplete="off" required="" />
                                                    <span class="input-group-addon spaceIcon"><i class="fa fa-user"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="form-create-account-email">Password</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="password" name="password" placeholder="Type your password" value="" autocomplete="off" required="" />
                                                    <span class="input-group-addon spaceIcon"><i class="fa fa-key"></i></span>
                                                </div>
                                            </div>

                                            <div class="clearfix"><br /><br /></div>

                                            <div class="form-group">
                                                <div class="center-block"><button type="submit" id="btnCheckLogin" class="buttonAction login"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Access admin area</button></div>
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

        <!-- footer content -->
        <footer>
            <div class="pull-right">
                <?php echo TITLE_APP ?> - Admin area
            </div>
          <div class="clearfix"></div>
        </footer>
        <!-- /footer content -->
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
    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.min.js"></script>
    
    <script type="text/javascript">
        
        $("#frmCheckLogin").on("submit", function(event){

            event.preventDefault();
            $('#btnCheckLogin').replaceWith('<button id="btnCheckLogin" type="button" class="buttonAction saving" disabled>Checking ...</button>');
            
            $.ajax({
                url: './ajax/$_login.php', data : $('#frmCheckLogin').serialize(), cache : false, type : 'post', dataType: 'json',
                success : function (data) {
                    if(data.status){
                        document.location.href = data.url;
                    }else{
                        $.alert({
                            icon: "fa fa-times-circle red",
                            title: "Error",
                            theme: "modern",
                            animation: "zoom",
                            closeAnimation: "scale",
                            animateFromElement: false,
                            containerFluid: true,
                            type: "dark",
                            content: data.msg
                        });
                        $('#btnCheckLogin').replaceWith('<button id="btnCheckLogin" type="submit" class="buttonAction login"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Access admin area</button>');
                    }
                },
                error : function (request, status, errors) { 
                    $.alert({
                        icon: "fa fa-times-circle red",
                        title: "Error",
                        theme: "modern",
                        animation: "zoom",
                        closeAnimation: "scale",
                        animateFromElement: false,
                        containerFluid: true,
                        type: "dark",
                        content: errors
                    });
                    $('#btnCheckLogin').replaceWith('<button id="btnCheckLogin" type="submit" class="buttonAction login"><i class="fa fa-sign-in"></i>&nbsp;&nbsp;Access admin area</button>');                    
                }
            });
            
            return false;
        });

    </script>	
  </body>
</html>
