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
                            <h2 class="title_card"><i class="fa fa-book green"></i>New calendar instance <small><?php echo TITLE_APP ?></small></h2>
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
                                <div class="col-md-12"><h4>Create new calendar instance</h4></div>
                                <div class="col-md-12">
<pre class="language-markup charDim">
<code>&lt;script type=&quot;text/javascript&quot;&gt;
    
    var cal;
    document.addEventListener('DOMContentLoaded', function() {
        cal = $.fn.calendarMaker({
            uuidCalendar: '5988f9e2-fcab-40c1-8342-1a41d1d3425a',
            divCal: 'calendar',
            divLoad: 'loading',
            popOver: true,
            readOnly: false,
            barSearch: {txtSearch: 'inputVal', btnSearch: 'search', btnReset: 'reset'},
            barImport: {btnReset: 'resetCal', btnImport: 'import', btnExport: 'export'},
            barLanguage: {selector: 'calendarLang', enabled: {all:''} }
        });
    });
    
&lt;/script&gt;</code></pre>
                                </div>
                                <div class='col-md-12'>
                                    <br><blockquote>
                                    <p><b>uuidCalendar</b> (required) : unique identification (ID) for the calendar</p>
                                    <p><b>divCal</b> (required) : DIV element ID that contains the calendar<div class="highlight"><pre><code class="language-html" data-lang="html"><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"col-md-12"</span> <span class="na">id=</span><span class="s">"calendar"</span><span class="nt">&gt;</span><span class="nt">&lt;/div&gt;</span></code></pre></div></p>
                                    <p><b>divLoad</b> (optional) : DOM object ID that contains the loading
                                    <div class="highlight"><pre><code class="language-html" data-lang="html"><span class="nt">&lt;div</span> <span class="na">class=</span><span class="s">"col-md-12 col-sm-12 col-xs-12 right"</span><span class="nt">&gt;</span><span class="nt">&lt;/div&gt;</span></code>
    <code class="language-html" data-lang="html"><span class="nt">&lt;span</span> <span class="na">id=</span><span class="s">"loading"</span><span class="nt">&gt;</span><span class="nt">&lt;/span&gt;</span></code>
<code class="language-html" data-lang="html"><span class="nt">&lt;/div&gt;</span></code></pre></div>
                                    </p>
                                    <p><b>popOver</b> (optional) : On hover show events in popup. Default value is false</p>
                                    <p><b>readOnly</b> (optional) : Prevents users to create, modify and delete events. Default value is false</p>
                                    <p><b>barSearch</b> (optional) : You can search and filter events in the calendar using the "barSearch" search toolbar. The parameters in the "barSearch" array are as follows :</p>
                                    <ul>
                                        <li>inputVal : ID of the textbox containing the text to search for</li>
                                        <li>search : ID of the button that start the search</li>
                                        <li>reset : ID of the button that disable the search filter</li>
                                    </ul>
<div class="highlight"><pre class="language-markup charDim">
<code>...
barSearch: {txtSearch: 'inputVal', btnSearch: 'search', btnReset: 'reset'}
...
</code></pre></div>
                                    <p><b>barImport</b> (optional) : This toolbar enables calendar import and export functions. The parameters in the "barImport" array are as follows :</p>
                                    <ul>
                                        <li>resetCal : ID of the button that delete the imported calendar</li>
                                        <li>import : ID of the button that starts the import function</li>
                                        <li>export : ID of the button that exports the current calendar</li>
                                    </ul>                                    
<div class="highlight"><pre class="language-markup charDim">
<code>...
barImport: {btnReset: 'resetCal', btnImport: 'import', btnExport: 'export'}
...
</code></pre></div>
                                    <p><b>barLanguage</b> (optional) : Show language selector. The parameters in the "barLanguage" array are as follows :</p>
                                    <ul>
                                        <li>selector : ID of the combobox containing the available languages</li>
                                        <li>enabled : Array of language codes to be enabled for display ({all: ''})</li>
                                    </ul>
<div class="highlight"><pre class="language-markup charDim">
<code>...
/* Enable all language codes */
barLanguage: {selector: 'calendarLang', enabled: {all:''} } 
...
/* Enable only 'es' and 'zh-cn' language code */
barLanguage: {selector: 'calendarLang', enabled: {es:'español', 'zh-cn':'中文'} }
...
</code></pre></div>                                    
                                    <p><div class="highlight"><pre><code class="language-html" data-lang="html"><span class="nt">&lt;select</span> <span class="na">class=</span><span class="s">"btn dropdown-item"</span> <span class="na">id=</span><span class="s">"calendarLang"</span><span class="nt">&gt;</span><span class="nt">&lt;/select&gt;</span></code></pre></div></p>
</blockquote><br>
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