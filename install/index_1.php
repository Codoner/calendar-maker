<?php

require realpath(dirname(__FILE__)) . '/../assets/vendors/calendarmaker/class/calendarMaker.php';

?><!DOCTYPE html>
<html lang="en">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title><?php echo TITLE_APP ?> :: <?php echo COMPANY_APP ?></title>
    <link rel="icon" href="/favicon.png" />
    
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
    <!-- jquery confirm -->
    <link href="<?php echo APPLICATION_PATH?>/assets/vendors/jquery-confirm/dist/jquery-confirm.min.css" rel="stylesheet" />
    <!-- Custom Theme Style -->
    <link href="<?php echo APPLICATION_PATH?>/assets/css/custom.css" rel="stylesheet">

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
        .checkResult {
            width: 100px;
            height: 30px;
            text-align: left;
            line-height: 30px;
        }
        .checkResult span {
            display: table;
            text-indent: 5px;
            width: 100px;
            height: 30px;
            line-height: 30px;
            vertical-align: middle;
        }
        .passed {
            background-color: #bed37f;
        }
        .fault {
            background-color: #ff7f7f;
        }

        
        
.wizard {
    margin: 0px auto;
    background: #fff;
}

    .wizard .nav-tabs {
        position: relative;
        margin: 0px auto;
        margin-bottom: 0;
        border-bottom-color: #e0e0e0;
    }

    .wizard > div.wizard-inner {
        position: relative;
    }

.connecting-line {
    height: 2px;
    background: #e0e0e0;
    position: absolute;
    width: 80%;
    margin: 0 auto;
    left: 0;
    right: 0;
    top: 50%;
    z-index: 1;
}

.wizard .nav-tabs > li.active > a, .wizard .nav-tabs > li.active > a:hover, .wizard .nav-tabs > li.active > a:focus {
    color: #e0e0e0;
    cursor: default;
    border: 0;
    border-bottom-color: transparent;
}

span.round-tab {
    width: 70px;
    height: 70px;
    line-height: 70px;
    display: inline-block;
    border-radius: 100px;
    background: #fff;
    border: 2px solid #e0e0e0;
    z-index: 2;
    position: absolute;
    left: 0;
    text-align: center;
    font-size: 25px;
}
span.round-tab i{
    color:#e0e0e0;
}
.wizard li.active span.round-tab {
    background: #fff;
    border: 2px solid #7da800;
    
}
.wizard li.active span.round-tab i{
    color: #7da800;
}

span.round-tab:hover {
    color: #e0e0e0;
    border: 2px solid #7da800;
}

.wizard .nav-tabs > li {
    width: 25%;
}

.wizard li:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 0;
    margin: 0 auto;
    bottom: 0px;
    border: 5px solid transparent;
    border-bottom-color: #7da800;
    transition: 0.1s ease-in-out;
}

.wizard li.active:after {
    content: " ";
    position: absolute;
    left: 46%;
    opacity: 1;
    margin: 0 auto;
    bottom: 0px;
    border: 10px solid transparent;
    border-bottom-color: #7da800;
}

.wizard .nav-tabs > li a {
    width: 70px;
    height: 70px;
    margin: 20px auto;
    border-radius: 100%;
    padding: 0;
}

    .wizard .nav-tabs > li a:hover {
        background: transparent;
    }

.wizard .tab-pane {
    position: relative;
    padding-top: 50px;
}

.wizard h3 {
    margin-top: 0;
}
.step1 .row {
    margin-bottom:10px;
}
.step_21 {
    /*
    border :1px solid #eee;
    border-radius:5px;
    */
    padding:10px;
}
.step33 {
    border:1px solid #ccc;
    border-radius:5px;
    padding-left:10px;
    margin-bottom:10px;
}
.dropselectsec {
    width: 68%;
    padding: 6px 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333;
    margin-left: 10px;
    outline: none;
    font-weight: normal;
}
.dropselectsec1 {
    width: 74%;
    padding: 6px 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333;
    margin-left: 10px;
    outline: none;
    font-weight: normal;
}
.mar_ned {
    margin-bottom:10px;
}
.wdth {
    width:25%;
}
.birthdrop {
    padding: 6px 5px;
    border: 1px solid #ccc;
    border-radius: 3px;
    color: #333;
    margin-left: 10px;
    width: 16%;
    outline: 0;
    font-weight: normal;
}


/* according menu */
#accordion-container {
    font-size:13px
}
.accordion-header {
    font-size:13px;
	background:#ebebeb;
	margin:5px 0 0;
	padding:7px 20px;
	cursor:pointer;
	color:#fff;
	font-weight:400;
	-moz-border-radius:5px;
	-webkit-border-radius:5px;
	border-radius:5px
}
.unselect_img{
	width:18px;
	-webkit-user-select: none;  
	-moz-user-select: none;     
	-ms-user-select: none;      
	user-select: none; 
}
.active-header {
	-moz-border-radius:5px 5px 0 0;
	-webkit-border-radius:5px 5px 0 0;
	border-radius:5px 5px 0 0;
	background:#F53B27;
}
.active-header:after {
	content:"\f068";
	font-family:'FontAwesome';
	float:right;
	margin:5px;
	font-weight:400
}
.inactive-header {
	background:#333;
}
.inactive-header:after {
	content:"\f067";
	font-family:'FontAwesome';
	float:right;
	margin:4px 5px;
	font-weight:400
}
.accordion-content {
	display:none;
	padding:20px;
	background:#fff;
	border:1px solid #ccc;
	border-top:0;
	-moz-border-radius:0 0 5px 5px;
	-webkit-border-radius:0 0 5px 5px;
	border-radius:0 0 5px 5px
}
.accordion-content a{
	text-decoration:none;
	color:#333;
}
.accordion-content td{
	border-bottom:1px solid #dcdcdc;
}



@media( max-width : 585px ) {

    .wizard {
        width: 90%;
        height: auto !important;
    }

    span.round-tab {
        font-size: 16px;
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard .nav-tabs > li a {
        width: 50px;
        height: 50px;
        line-height: 50px;
    }

    .wizard li.active:after {
        content: " ";
        position: absolute;
        left: 35%;
    }
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

          </div>
        </div>

        <!-- top navigation -->
        <div class="top_nav">
            <div class="nav_menu">
                <nav>
                    <div class="nav toggle" style="padding-bottom: 10px">
                        <a id="menu_toggle"><i class="fa fa-bars"></i></a>
                    </div>
                </nav>
            </div>
        </div>
        <!-- /top navigation -->
        
        <div class="right_col" role="main">

            <div class="clearfix"></div>
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    <div class="x_panel">
                        <div class="x_title">
                            <h2 class="title_card"><i class="fa fa-flag green"></i>Install <small><?php echo TITLE_APP?></small></h2>
                            <div class="clearfix"></div>
                        </div>
                        <div class="x_content">
                            <br />

                            <div data-string="&#xf024" class="col-md-2 col-sm-2 hidden-xs filigrana-2col"></div>
                            <div class="col-md-10 col-sm-10 col-xs-12">

    <div class="row">
    	<section>
        <div class="wizard">
            <div class="wizard-inner">
                <div class="connecting-line"></div>
                <ul class="nav nav-tabs" role="tablist">

                    <li role="presentation" class="active">
                        <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" title="Requirements">
                            <span class="round-tab">
                                <i class="fa fa-list-ul"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" title="Database">
                            <span class="round-tab">
                                <i class="fa fa-database"></i>
                            </span>
                        </a>
                    </li>
                    <li role="presentation" class="disabled">
                        <a href="#step3" data-toggle="tab" aria-controls="step3" role="tab" title="Account">
                            <span class="round-tab">
                                <i class="fa fa-user"></i>
                            </span>
                        </a>
                    </li>

                    <li role="presentation" class="disabled">
                        <a href="#complete" data-toggle="tab" aria-controls="complete" role="tab" title="Complete">
                            <span class="round-tab">
                                <i class="glyphicon glyphicon-ok"></i>
                            </span>
                        </a>
                    </li>
                </ul>
            </div>

                <div class="tab-content">
                    <div class="tab-pane active" role="tabpanel" id="step1">

                        <div class="step_21">
                            <div class="row">
                            <table class="table" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Result</th>
                                        <th>Notes</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>PHP Version</td>
                                        <td class="checkResult" id="checkPHP"><i class="fa fa-spinner fa-spin lightblue"></i></td>
                                        <td>PHP 5.6.0 or higher is required</td>
                                    </tr>
                                    <tr>
                                        <td>$_SERVER variable</td>
                                        <td class="checkResult" id="checkSERVER"><i class="fa fa-spinner fa-spin lightblue"></i></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>PDO extension</td>
                                        <td class="checkResult" id="checkPDO"><i class="fa fa-spinner fa-spin lightblue"></i></td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>PDO MySQL extension</td>
                                        <td class="checkResult" id="checkPDOmysql"><i class="fa fa-spinner fa-spin lightblue"></i></td>
                                        <td>Required for MySQL database</td>
                                    </tr>
                                </tbody>
                            </table>                                    

                            </div>
                        </div>
                        
                        <div class="form-group">
                            <div class="center-block"><button type="button" id="btnRequirements" style="visibility: hidden" class="buttonAction next next-step">next step</button></div>
                        </div>                        
                        
                        
                    </div>                   
                    <div class="tab-pane" role="tabpanel" id="step2">
                        <form id="frmDatabase" action="#" method="post">
                        <div class="step1">
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="txtHostname">Hostname (*)</label>
                                    <input type="text" class="form-control" id="txtHostname" name="txtHostname" placeholder="Hostname" required="" autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <label for="txtPort">Port (*)</label>
                                    <input type="number"  min="1" max="65535" class="form-control" id="txtPort" name="txtPort" placeholder="Port" required="" autocomplete="off">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-8">
                                    <label for="txtDatabase">Database name (*)</label>
                                    <input type="text" class="form-control" id="txtDatabase" name="txtDatabase" placeholder="Database name" required="" autocomplete="off">
                                </div>
                                <div class="col-md-4">
                                    <label for="txtPrefix">Tables prefix</label>
                                    <div class="input-group">
                                        <span class="input-group-addon spaceIcon">tm_</span>
                                        <input type="text" class="form-control" id="txtPrefix" name="txtPrefix" placeholder="Tables prefix" autocomplete="off">
                                    </div>
                                </div>
                            </div>                            
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="txtUsername">Username (*)</label>
                                    <input type="text" class="form-control" id="txtUsername" name="txtUsername" placeholder="Username" required="" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label for="txtPassword">Password</label>
                                    <input type="password" class="form-control" id="txtPassword" name="txtPassword" placeholder="Password" autocomplete="off">
                                </div>
                            </div>
                            
                        </div>           

                        <br class="clearfix">
                        <div class="form-group">
                            <div class="center-block"><button type="submit" id="btnDatabase" class="buttonAction next">create database</button></div>
                        </div>
                        </form>
                        
                    </div>
                    <div class="tab-pane" role="tabpanel" id="step3">
                        <form id="frmAccount" action="#" method="post">
                        <div class="step1">                      
                            <div class="row">
                                <div class="col-md-6">
                                    <label for="txtUsername">Admin Username (*)</label>
                                    <input type="text" class="form-control" id="txtAdminUser" name="txtAdminUser" placeholder="Admin username" required="" autocomplete="off">
                                </div>
                                <div class="col-md-6">
                                    <label for="txtPassword">Admin Password (*)</label>
                                    <input type="password" class="form-control" id="txtAdminPass" name="txtAdminPass" placeholder="Admin password" required="" autocomplete="off">
                                </div>
                            </div>
                            
                        </div>           

                        <br class="clearfix">
                        <div class="form-group">
                            <div class="center-block"><button type="submit" id="btnAccount" class="buttonAction next">create account</button></div>
                        </div>
                        </form>                        

                    </div>
                    <div class="tab-pane" role="tabpanel" id="complete">
                        <div class="step44">
                            <div class="center-block">
                                <h1 class="green"><?php echo TITLE_APP ?></h1>
                                <h2 class="green">was installed successfully</h2>
                                <br class="clearfix">
                                <div class="center-block"><button type="button" id="btnGetStart" class="buttonAction getStart">Get start now !</button></div>
                                <br class="clearfix">
                            </div>         
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>

        </div>
    </section>
   </div>
                                
                                
                                
                                
                                
                            </div>
                      </div>
                    </div>
                </div>
            </div>            

            
        </div>

      </div>
    </div>

    <!-- jQuery -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- NProgress -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/nprogress/nprogress.js"></script>
    <!-- Moment -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/moment/moment-with-locales.min.js"></script>
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/moment-timezone/moment-timezone-with-data.min.js"></script> 
    <!-- Datetimepicker -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/datetimepicker/bootstrap-datetimepicker.min.js"></script>
    <!-- Bootstrap-colorpicker -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.js"></script>
    <!-- jQuery confirm -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/jquery-confirm/dist/jquery-confirm.min.js"></script>    
    <!-- jQuery Tags Input -->
    <script src="<?php echo APPLICATION_PATH?>/assets/vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>     
    <!-- Calendarmaker -->
    <script id="caljs" src="<?php echo APPLICATION_PATH?>/assets/vendors/calendarmaker/calendarMaker.min.js"></script>
    <!-- Custom Theme Scripts -->
    <script src="<?php echo APPLICATION_PATH?>/assets/js/custom.min.js"></script>
    
    <script type="text/javascript">

    $(document).ready(function () {

        $('.nav-tabs > li a[title]').tooltip();
        $('a[data-toggle="tab"]').on('show.bs.tab', function (e) {
            var $target = $(e.target);
            if ($target.parent().hasClass('disabled')) {
                return false;
            }
        });
        $(".next-step").click(function (e) {
            var $active = $('.wizard .nav-tabs li.active');
            $active.next().removeClass('disabled');
            nextTab($active);
        });
        $(".prev-step").click(function (e) {
            var $active = $('.wizard .nav-tabs li.active');
            prevTab($active);
        });

        /* Add Inactive Class To All Accordion Headers */
        $('.accordion-header').toggleClass('inactive-header');

        /* Set The Accordion Content Width */
        var contentwidth = $('.accordion-header').width();
        $('.accordion-content').css({});

        /* Open The First Accordion Section When Page Loads */
        $('.accordion-header').first().toggleClass('active-header').toggleClass('inactive-header');
        $('.accordion-content').first().slideDown().toggleClass('open-content');

        /* The Accordion Effect */
        $('.accordion-header').click(function () {
            if($(this).is('.inactive-header')) {
                $('.active-header').toggleClass('active-header').toggleClass('inactive-header').next().slideToggle().toggleClass('open-content');
                $(this).toggleClass('active-header').toggleClass('inactive-header');
                $(this).next().slideToggle().toggleClass('open-content');
            }else {
                $(this).toggleClass('active-header').toggleClass('inactive-header');
                $(this).next().slideToggle().toggleClass('open-content');
            }
        });
        checkRequirements();
        return false;

    });

    function nextTab(elem) {
        $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
        $(elem).prev().find('a[data-toggle="tab"]').click();
    }
    function checkRequirements() {

        $.ajax({
            url: '<?php echo APPLICATION_PATH ?>/install/$_requirements.php', data : null, cache : false, type : 'post', dataType: 'json',
            success : function (data) {
                if(data.status){
                    $("#checkPHP").html( data.checkPHP ? '<span class="passed">Passed</span>' : '<span class="fault">Failed</span>' );
                    $("#checkSERVER").html( data.checkSERVER ? '<span class="passed">Passed</span>' : '<span class="fault">Failed</span>' );
                    $("#checkPDO").html( data.checkPDO ? '<span class="passed">Passed</span>' : '<span class="fault">Failed</span>' );
                    $("#checkPDOmysql").html( data.checkPDOmysql ? '<span class="passed">Passed</span>' : '<span class="fault">Failed</span>' );
                    if(data.checkPHP && data.checkSERVER && data.checkPDO && data.checkPDOmysql){
                        $("#btnRequirements").css("visibility", "visible");
                        $('#btnRequirements').on("click", function(event){
                            $('#btnRequirements').replaceWith('<div class="center-block"><button type="button" id="btnRequirements" class="buttonAction saving" disabled>next step</button></div>');
                        });                    
                    }
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
                }
            },
            error: function (error) {
                alert( error );
            }
        });

    }

    $('#frmDatabase').on("submit", function(event){

        event.preventDefault();
        $('#btnDatabase').replaceWith('<div class="center-block"><button type="submit" id="btnDatabase" class="buttonAction saving" disabled>Saving ...</button></div>');

        $.ajax({
            url: '<?php echo APPLICATION_PATH ?>/install/$_database.php', data : $("#frmDatabase").serialize(), cache : false, type : 'post', dataType: 'json',
            success : function (data) {
                console.log(data);
                if(data.status){

                    var $active = $('.wizard .nav-tabs li.active');
                    $active.next().removeClass('disabled');
                    nextTab($active);
                    $('#btnDatabase').replaceWith('<div class="center-block"><button type="button" id="btnDatabase" class="buttonAction saving" disabled>create database</button></div>');

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
                    $('#btnDatabase').replaceWith('<div class="center-block"><button type="submit" id="btnDatabase" class="buttonAction next">create database</button></div>');
                }
            },
            error: function (error) {
                $('#btnDatabase').replaceWith('<div class="center-block"><button type="submit" id="btnDatabase" class="buttonAction next">create database</button></div>');
                alert( error );
            }
        });

    });

    $('#frmAccount').on("submit", function(event){

        event.preventDefault();
        $('#btnAccount').replaceWith('<div class="center-block"><button type="submit" id="btnAccount" class="buttonAction saving" disabled>Saving ...</button></div>');

        $.ajax({
            url: '<?php echo APPLICATION_PATH ?>/install/$_account.php', data : $("#frmAccount").serialize(), cache : false, type : 'post', dataType: 'json',
            success : function (data) {
                console.log(data);
                if(data.status){

                    var $active = $('.wizard .nav-tabs li.active');
                    $active.next().removeClass('disabled');
                    nextTab($active);
                    $('#btnAccount').replaceWith('<div class="center-block"><button type="button" id="btnAccount" class="buttonAction saving" disabled>create account</button></div>');

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
                    $('#btnAccount').replaceWith('<div class="center-block"><button type="submit" id="btnAccount" class="buttonAction next">create account</button></div>');
                }
            },
            error: function (error) {
                $('#btnAccount').replaceWith('<div class="center-block"><button type="submit" id="btnAccount" class="buttonAction next">create account</button></div>');
                alert( error );
            }
        });

    });

    $('#btnGetStart').on("click", function(event){
        event.preventDefault();
        location.href = '<?php echo LOGIN_PAGE ?>';
    });


    </script>	
  </body>
</html>
