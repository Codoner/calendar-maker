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
                            <h2 class="title_card"><i class="fa fa-key green"></i>Change password <small>Set a new password for Administrator</small></h2>
                            <ul class="nav navbar-right panel_toolbox">
                                <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a></li>
                                <li><a class="close-link"><i class="fa fa-close"></i></a></li>
                            </ul>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <div class="clearfix"><br /></div>

                            <div data-string="&#xf084" class="col-md-2 col-sm-2 hidden-xs filigrana-2col"></div>
                            <div class="col-md-10 col-sm-10 col-xs-12">

                                <form id="frmNewPwd" action="#" method="post" data-parsley-validate class="form-horizontal form-label-left">
                                    <input type="hidden" name="idUser" value="<?php echo $_SESSION['user']['id'];?>" />
                                    <div class="row" style="padding-top: 50px">
                                        <div class="col-md-6 col-sm-6 col-md-offset-3 col-sm-offset-3">

                                            <div class="form-group">
                                                <label for="form-create-account-email">New password (*)</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New password" value="" autocomplete="off" required="" />
                                                    <span class="input-group-addon spaceIcon"><i class="fa fa-key"></i></span>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="form-create-account-email">Retype new password (*)</label>
                                                <div class="input-group">
                                                    <input type="password" class="form-control" id="repeatPassword" name="repeatPassword" oninput="check(this)" placeholder="Retype new password" value="" autocomplete="off" required="" />
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
    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.min.js"></script>
    <script type="text/javascript">

        function check(input) {
            if (input.value !== document.getElementById('newPassword').value) {
                input.setCustomValidity("Password confirmation doesn't match new password");
            } else {
                input.setCustomValidity('');
            }
        }

        // Save new password
        $('#frmNewPwd').on("submit", function(event){
            if($('#newPassword').val() !== $('#repeatPassword').val()) { 
                $.alert({
                    icon: "fa fa-times-circle red",
                    title: "Error",
                    theme: "modern",
                    animation: "zoom",
                    closeAnimation: "scale",
                    animateFromElement: false,
                    containerFluid: true,
                    type: "dark",
                    content: "Password confirmation doesn't match new password"
                });
                return false;
            }
            
            event.preventDefault();
            $('#btnNewPwd').replaceWith('<button id="btnNewPwd" type="button" class="buttonAction saving" disabled>Saving ...</button>');

            $.ajax({
                url: '<?php echo _DIR_BE ?>/ajax/$_change_password.php', data : $('#frmNewPwd').serialize(), cache : false, type : 'post', dataType: 'json',
                success : function (data) {
                    if(data.status){
                        $.alert({
                            icon: "fa fa-check green",
                            title: "Success",
                            theme: "modern",
                            animation: "zoom",
                            closeAnimation: "scale",
                            animateFromElement: false,
                            containerFluid: true,
                            type: "dark",
                            content: "",
                            buttons: {
                                confirm: {
                                    text: "Close",
                                    action: function () {
                                        window.location.href = '<?php echo _DIR_BE?>/list-calendar.php';
                                    }
                                }
                            }
                        });                        
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
                        $('#btnNewPwd').replaceWith('<button id="btnNewPwd" type="submit" class="buttonAction save">Save password</button>');
                    }
                },
                error: function (error) {
                    $.alert({
                        icon: "fa fa-times-circle red",
                        title: "Error",
                        theme: "modern",
                        animation: "zoom",
                        closeAnimation: "scale",
                        animateFromElement: false,
                        containerFluid: true,
                        type: "dark",
                        content: error
                    });
                    $('#btnNewPwd').replaceWith('<button id="btnNewPwd" type="submit" class="buttonAction save">Save password</button>');
                }
            });

            return false;
        }); 
        
    </script>	
  </body>
</html>
