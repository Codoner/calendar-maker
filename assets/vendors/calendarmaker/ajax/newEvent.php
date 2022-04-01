<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require dirname(__FILE__) . '/../class/calendarMaker.php';

$lang       = filter_input(INPUT_POST, "lang", FILTER_SANITIZE_STRING);
$uuid       = filter_input(INPUT_POST, "uuid", FILTER_SANITIZE_STRING);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
$cal = $cA->getCalendar($uuid);
        
$string = file_get_contents("../resources/locales/".$lang.".json");
$i18n = json_decode($string, true);

$arrCategories = (trim($cal['calendar']['categories']) != "") ? explode(",", $cal['calendar']['categories']) : null;
$arrCustomFields = (trim($cal['calendar']['customFields']) != "") ? explode(",", $cal['calendar']['customFields']) : null;

?>
<div class="modal-dialog">
    <form id="formNewEvent" method="post">
    <input type="hidden" name="newRecurring" id="newRecurring" value="<?php echo $i18n['newEvent']['body']['does_not_repeat']?>" />
    <input type="hidden" name="newCalendarCategory" id="newCalendarCategory" value="<?php echo ($i18n['custom']['categories']['none'] != "") ? $i18n['custom']['categories']['none'] : "Select category"; ?>" />
    <input type="hidden" name="newTypeRecurring" id="newTypeRecurring" value="<?php echo $i18n['newEvent']['body']['days']?>" />
    <input type="hidden" name="newMonthTimeRecurring" id="newMonthTimeRecurring" value="" />
    <input type="hidden" name="newYearTimeRecurring" id="newYearTimeRecurring" value="" />
    <input type="hidden" name="newEndRecurring" id="newEndRecurring" value="<?php echo $i18n['newEvent']['body']['never']?>" />
    <input type="hidden" name="newLang" id="newLang" value="<?php echo $lang; ?>" />
    <input type="hidden" name="newUUID" id="newUUID" value="<?php echo $uuid; ?>" />
    <input type="hidden" name="newDescription2" id="newDescription2" value="" />
    <div class="modal-content">
        <div class="modal-header" style="background-color: #f0f0f0">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span class="col-sm-4" style="float: left"><h4><?php echo $i18n['newEvent']['header']['title']?></h4></span>
            <span class="col-sm-7" style="float: left">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-primary active">
                        <input type="radio" name="newDateType" value="allday" checked> <?php echo $i18n['newEvent']['header']['allday']?>
                    </label>
                    <label class="btn btn-primary">
                        <input type="radio" name="newDateType" value="custom"> <?php echo $i18n['newEvent']['header']['custom']?>
                    </label>
                </div>
            </span>              
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $i18n['newEvent']['body']['title']?></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control mainField" id="newTitle" name="newTitle" placeholder="<?php echo $i18n['newEvent']['body']['placeholder_title']?>" value="" maxlength="255" autocomplete="off" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $i18n['newEvent']['body']['description']?></label>
                    <div class="col-sm-12">
                        <div class="btn-toolbar" data-role="editor-toolbar" data-target="#newDescription">
                            
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="<?php echo $i18n['core']['wysiwyg']['font_size']?>"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a data-edit="fontSize 5" class="fs-Five"><?php echo $i18n['core']['wysiwyg']['font_size_values']['huge']?></a></li>
                                    <li><a data-edit="fontSize 3" class="fs-Three"><?php echo $i18n['core']['wysiwyg']['font_size_values']['normal']?></a></li>
                                    <li><a data-edit="fontSize 1" class="fs-One"><?php echo $i18n['core']['wysiwyg']['font_size_values']['small']?></a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="<?php echo $i18n['core']['wysiwyg']['text_highlight_color']?>"><i class="fa fa-paint-brush"></i>&nbsp;<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a data-edit="backColor #00FFFF"><?php echo $i18n['core']['wysiwyg']['text_highlight_color_values']['blue']?></a></li>
                                    <li><a data-edit="backColor #00FF00"><?php echo $i18n['core']['wysiwyg']['text_highlight_color_values']['green']?></a></li>
                                    <li><a data-edit="backColor #FF7F00"><?php echo $i18n['core']['wysiwyg']['text_highlight_color_values']['orange']?></a></li>
                                    <li><a data-edit="backColor #FF0000"><?php echo $i18n['core']['wysiwyg']['text_highlight_color_values']['red']?></a></li>
                                    <li><a data-edit="backColor #FFFF00"><?php echo $i18n['core']['wysiwyg']['text_highlight_color_values']['yellow']?></a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="<?php echo $i18n['core']['wysiwyg']['font_color']?>"><i class="fa fa-font"></i>&nbsp;<b class="caret"></b></a>
                                <ul class="dropdown-menu">
                                    <li><a data-edit="foreColor #000000"><?php echo $i18n['core']['wysiwyg']['font_color_values']['black']?></a></li>
                                    <li><a data-edit="foreColor #0000FF"><?php echo $i18n['core']['wysiwyg']['font_color_values']['blue']?></a></li>
                                    <li><a data-edit="foreColor #30AD23"><?php echo $i18n['core']['wysiwyg']['font_color_values']['green']?></a></li>
                                    <li><a data-edit="foreColor #FF7F00"><?php echo $i18n['core']['wysiwyg']['font_color_values']['orange']?></a></li>
                                    <li><a data-edit="foreColor #FF0000"><?php echo $i18n['core']['wysiwyg']['font_color_values']['red']?></a></li>
                                    <li><a data-edit="foreColor #FFFF00"><?php echo $i18n['core']['wysiwyg']['font_color_values']['yellow']?></a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm" data-edit="bold" title="<?php echo $i18n['core']['wysiwyg']['bold']?>"><i class="fa fa-bold"></i></a>
                                <a class="btn btn-default btn-sm" data-edit="italic" title="<?php echo $i18n['core']['wysiwyg']['italic']?>"><i class="fa fa-italic"></i></a>
                                <a class="btn btn-default btn-sm" data-edit="strikethrough" title="<?php echo $i18n['core']['wysiwyg']['strikethrough']?>"><i class="fa fa-strikethrough"></i></a>
                                <a class="btn btn-default btn-sm" data-edit="underline" title="<?php echo $i18n['core']['wysiwyg']['underline']?>"><i class="fa fa-underline"></i></a>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm" data-edit="insertunorderedlist" title="<?php echo $i18n['core']['wysiwyg']['bullet_list']?>"><i class="fa fa-list-ul"></i></a>
                                <a class="btn btn-default btn-sm" data-edit="insertorderedlist" title="<?php echo $i18n['core']['wysiwyg']['number_list']?>"><i class="fa fa-list-ol"></i></a>
                                <a class="btn btn-default btn-sm" data-edit="outdent" title="<?php echo $i18n['core']['wysiwyg']['reduce_indent']?>"><i class="fa fa-outdent"></i></a>
                                <a class="btn btn-default btn-sm" data-edit="indent" title="<?php echo $i18n['core']['wysiwyg']['indent']?>"><i class="fa fa-indent"></i></a>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="<?php echo $i18n['core']['wysiwyg']['text_align']?>"><i class="fa fa-align-left"></i>&nbsp;<b class="caret"></b></a>
                                <div class="dropdown-menu">
                                    <a class="btn btn-default" data-edit="justifyleft" title="<?php echo $i18n['core']['wysiwyg']['align_left']?>"><i class="fa fa-align-left"></i></a>
                                    <a class="btn btn-default" data-edit="justifycenter" title="<?php echo $i18n['core']['wysiwyg']['align_center']?>"><i class="fa fa-align-center"></i></a>
                                    <a class="btn btn-default" data-edit="justifyright" title="<?php echo $i18n['core']['wysiwyg']['align_right']?>"><i class="fa fa-align-right"></i></a>
                                    <a class="btn btn-default" data-edit="justifyfull" title="<?php echo $i18n['core']['wysiwyg']['align_justify']?>"><i class="fa fa-align-justify"></i></a>
                                </div>
                            </div>                            
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" title="<?php echo $i18n['core']['wysiwyg']['hyperlink']?>"><i class="fa fa-link"></i></a>
                                <div class="dropdown-menu input-append">
                                    <input placeholder="URL" type="text" data-edit="createLink" />
                                    <button class="btn" type="button"><?php echo $i18n['core']['wysiwyg']['hyperlink_values']['add']?></button>
                                </div>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm" data-edit="unlink" title="<?php echo $i18n['core']['wysiwyg']['remove_hyperlink']?>"><i class="fa fa-unlink"></i></a>
                            </div>
                            <div class="btn-group">
                                <a class="btn btn-default btn-sm" data-edit="undo" title="<?php echo $i18n['core']['wysiwyg']['undo']?>"><i class="fa fa-undo"></i></a>
                                <a class="btn btn-default btn-sm" data-edit="redo" title="<?php echo $i18n['core']['wysiwyg']['redo']?>"><i class="fa fa-repeat"></i></a>
                            </div>
                            
                        </div>
                        <div id="newDescription" class="mainField"></div>
                    </div>
                </div>
            </div>

            <div class="divNewDateAllday" id="divNewDateAllday">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 col-xs-12 control-label"><?php echo $i18n['newEvent']['body']['start_end']?></label>
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group date" id="newdp1">
                                <input id="newvaldp1" name="newvaldp1" type="text" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="hidden-lg hidden-sm hidden-md col-xs-12"><br /></div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group date" id="newdp2">
                                <input id="newvaldp2" name="newvaldp2" type="text" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>                        
                    </div>
                </div>
                
            </div>
            <div class="divNewDateCustom" id="divNewDateCustom" style="display: none">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 col-xs-12 control-label"><?php echo $i18n['newEvent']['body']['start_end']?></label>
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group date" id="newdtp1">
                                <input id="newvaldtp1" name="newvaldtp1" type="text" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="hidden-lg hidden-sm hidden-md col-xs-12"><br /></div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group date" id="newdtp2">
                                <input id="newvaldtp2" name="newvaldtp2" type="text" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <?php if(count($arrCategories)>0) {?>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $i18n['newEvent']['body']['category']?></label>
                    <div class="col-sm-8 col-xs-12">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-block dropdown" type="button" id="newCategory" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span style="float: left"><?php echo ($i18n['custom']['categories']['none'] != "") ? $i18n['custom']['categories']['none'] : "Select category"; ?></span>
                                <span class="caret" style="margin-top: 8px; float: right"></span>
                            </button>
                            <ul class="dropdown-menu btn-block" id="newChooseCategory" aria-labelledby="newCategory">
                                <li><a id="newCat0" href="#" title="Select category"><?php echo ($i18n['custom']['categories']['none'] != "") ? $i18n['custom']['categories']['none'] : "Select category"; ?></a></li>
                                <?php foreach ($arrCategories as $key => $value) { ?>
                                <li><a id="newCat<?php echo $key+1?>" href="#" title="<?php echo $value ?>"><?php echo ($i18n['custom']['categories'][$value] != "") ? $i18n['custom']['categories'][$value] : $value;?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $i18n['newEvent']['body']['repeat']?></label>
                    <div class="col-sm-8 col-xs-12">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-block dropdown" type="button" id="newRepeat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span style="float: left"><?php echo $i18n['newEvent']['body']['does_not_repeat']?></span>
                                <span class="caret" style="margin-top: 8px; float: right"></span>
                            </button>
                            <ul class="dropdown-menu btn-block" id="newChooseRecurring" aria-labelledby="newRepeat">
                                <li><a id="newRep0" href="#"><?php echo $i18n['newEvent']['body']['does_not_repeat']?></a></li>
                                <li><a id="newRep1" href="#"><?php echo $i18n['newEvent']['body']['daily_recurring']?></a></li>
                                <li><a id="newRep2" href="#"><?php echo $i18n['newEvent']['body']['weekly_recurring']?></a></li>
                                <li><a id="newRep3" href="#"><?php echo $i18n['newEvent']['body']['monthly_recurring']?></a></li>
                                <li><a id="newRep4" href="#"><?php echo $i18n['newEvent']['body']['yearly_recurring']?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div id="divNewRecurring" style="display: none">
                
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 col-xs-12 control-label"></label>
                        <div class="col-sm-8 col-xs-12">
                            
                            <div id="newDivDaysRecurring" class="form-group col-md-12 col-xs-12" style="padding:0; display: none">
                                
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['newEvent']['body']['each']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="newEachNumberDays" name="newEachNumberDays" value="1" min="1" max="365" />
                                        <span class="input-group-addon">
                                            <span class=""><?php echo $i18n['newEvent']['body']['days']?></span>
                                        </span>
                                    </div>
                                </div>
                                
                            </div>

                            <div id="newDivWeeksRecurring" class="form-group col-md-12 col-xs-12" style="padding:0; display: none">
                                
                                    
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['newEvent']['body']['each']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="newEachNumberWeeks" name="newEachNumberWeeks" value="1" min="1" max="52" />
                                        <span class="input-group-addon">
                                            <span><?php echo $i18n['newEvent']['body']['weeks']?></span>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"><br></div>

                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label">&nbsp;</label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="btn-group btn-group-toggle btn-block btn-group-justified" data-toggle="buttons">
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="newDayOfWeek[]" value="0"> <?php echo strtoupper(substr($i18n['core']['days']['sunday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="newDayOfWeek[]" value="1"> <?php echo strtoupper(substr($i18n['core']['days']['monday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="newDayOfWeek[]" value="2"> <?php echo strtoupper(substr($i18n['core']['days']['tuesday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="newDayOfWeek[]" value="3"> <?php echo strtoupper(substr($i18n['core']['days']['wednesday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="newDayOfWeek[]" value="4"> <?php echo strtoupper(substr($i18n['core']['days']['thursday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="newDayOfWeek[]" value="5"> <?php echo strtoupper(substr($i18n['core']['days']['friday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="newDayOfWeek[]" value="6"> <?php echo strtoupper(substr($i18n['core']['days']['saturday'],0,1));?>
                                        </label>
                                    </div>
                                </div>

                            </div>
                            
                            <div id="newDivMonthsRecurring" class="form-group col-md-12 col-xs-12" style="padding:0; display: none">

                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['newEvent']['body']['each']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="newEachNumberMonths" name="newEachNumberMonths" value="1" min="1" max="12" />
                                        <span class="input-group-addon">
                                            <span><?php echo $i18n['newEvent']['body']['months']?></span>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"><br></div>
                                
                                
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label">&nbsp;</label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle btn-block" type="button" id="newChooseMonthTime" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span style="float: left"></span>
                                            <span class="caret" style="margin-top: 8px; float: right"></span>
                                        </button>
                                        <ul class="dropdown-menu btn-block" id="newChooseMonthTimeRecurring" aria-labelledby="newChooseMonthTime">
                                            <li><a id="newRepMonth0" href="#"></a></li>
                                            <li><a id="newRepMonth1" href="#"></a></li>
                                        </ul>
                                    </div>                                
                                </div>                                
                                
                            </div>
                            
                            <div id="newDivYearsRecurring" class="form-group col-md-12 col-xs-12" style="padding:0; display: none">
                                
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['newEvent']['body']['each']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle btn-block" type="button" id="newChooseYearTime" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span style="float: left"></span>
                                            <span class="caret" style="margin-top: 8px; float: right"></span>
                                        </button>
                                        <ul class="dropdown-menu btn-block" id="newChooseYearTimeRecurring" aria-labelledby="newChooseYearTime">
                                            <li><a id="newRepYear0" href="#"></a></li>
                                            <li><a id="newRepYear1" href="#"></a></li>
                                        </ul>
                                    </div>                                
                                </div>                                   
                            </div>
                            
                            <div class="form-group col-md-12 col-xs-12" style="padding:0">
                                
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['newEvent']['body']['end']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    
                                    <ul class="nav nav-pills nav-justified" id="newEndRecurring" role="tablist">
                                        <li class="nav-item">
                                            <a style="padding: 1px; margine: 0" class="nav-link" id="new-pills-never-tab" data-toggle="pill" href="#new-pills-never" role="tab" aria-controls="new-pills-never" aria-selected="true"><?php echo $i18n['newEvent']['body']['never']?></a>
                                        </li>
                                        <li class="nav-item" style="padding: 1px; margine: 0">
                                            <a style="padding: 1px; margine: 0" class="nav-link" id="new-pills-date-tab" data-toggle="pill" href="#new-pills-date" role="tab" aria-controls="new-pills-date" aria-selected="false"><?php echo $i18n['newEvent']['body']['date']?></a>
                                        </li>
                                        <li class="nav-item" style="padding: 1px; margine: 0">
                                            <a style="padding: 1px; margine: 0" class="nav-link" id="new-pills-after-tab" data-toggle="pill" href="#new-pills-after" role="tab" aria-controls="new-pills-after" aria-selected="false"><?php echo $i18n['newEvent']['body']['after']?></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="new-pills-never" role="tabpanel" aria-labelledby="new-pills-never-tab"></div>
                                        <div class="tab-pane fade" id="new-pills-date" role="tabpanel" aria-labelledby="new-pills-date-tab">
                                            <div class="row" style="text-align: right; padding: 0; margin-left: 0; margin-right: 0">
                                                <div class="input-group date" id="newenddp1">
                                                    <input id="newendvaldp1" name="newendvaldp1" type="text" class="form-control" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="new-pills-after" role="tabpanel" aria-labelledby="new-pills-after-tab">
                                            <div class="row" style="text-align: right; padding: 0; margin-left: 0; margin-right: 0">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="newEndOccurrences" name="newEndOccurrences" value="1" max="50" min="1" />
                                                    <span class="input-group-addon"><?php echo $i18n['newEvent']['body']['occurrences']?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
                
            </div>            


            <div class="row">
                <div class="form-group">
                  <label class="col-sm-4 col-xs-12 control-label"><?php echo $i18n['newEvent']['body']['event_color']?></label>
                  <div class="col-sm-4 col-xs-6">
                     <div class="input-group">
                        <div id="cp1" class="input-group colorpicker-component">
                            <span class="input-group-addon"><i></i></span>
                            <input id="newColorBg" name="newColorBg" type="text" value="#00AABB" class="form-control" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-background"></span></span>
                        </div>  
                     </div>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <div class="input-group">
                        <div id="cp2" class="input-group colorpicker-component">
                            <span class="input-group-addon"><i></i></span>
                            <input id="newColorText" name="newColorText" type="text" value="#00AABB" class="form-control" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-color"></span></span>
                        </div>
                     </div>
                  </div>
                </div>
            </div>            
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $i18n['newEvent']['body']['url']?></label>
                    <div class="col-sm-8 col-xs-12">
                        <div class="input-group">
                            <input id="newUrl" name="newUrl" type="url" class="form-control" placeholder="<?php echo $i18n['newEvent']['body']['placeholder_url']?>" value="" maxlength="255" autocomplete="off" />
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-link"></span>
                            </span>
                        </div>
                    </div>               
                </div>
            </div>
            <?php for($cF=0; $cF < count($arrCustomFields); $cF++){ ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo ($i18n['custom']['fields'][$arrCustomFields[$cF]] != "") ? $i18n['custom']['fields'][$arrCustomFields[$cF]] : $arrCustomFields[$cF];?></label>
                    <div class="col-sm-8">
                        <input type="text" class="form-control" name="newCustom[<?php echo $arrCustomFields[$cF] ?>]" value="" maxlength="255" autocomplete="off" />
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="modal-footer">
            <button id="saveNew" type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-save"></i>&nbsp;<?php echo $i18n['newEvent']['footer']['save']?></button>
        </div>
    </div>
    </form>
</div>
<!-- wysiwyg editor CSS -->
<link href="<?php echo APPLICATION_PATH?>/assets/vendors/prettify/prettify.css" rel="stylesheet" />
<link href="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap-wysiwyg/css/style.css" rel="stylesheet" />
<!-- wysiwyg editor JS -->
<script src="<?php echo APPLICATION_PATH?>/assets/vendors/hotkeys/jquery.hotkeys.js"></script>
<script src="<?php echo APPLICATION_PATH?>/assets/vendors/prettify/prettify.js"></script>
<script src="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
<script type="text/javascript">
    $(function(){
        function initToolbarBootstrapBindings() {
            var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier', 
                'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
                'Times New Roman', 'Verdana'],
                fontTarget = $('[title=Font]').siblings('.dropdown-menu');
            $.each(fonts, function (idx, fontName) {
                fontTarget.append($('<li><a data-edit="fontName ' + fontName +'" style="font-family:\''+ fontName +'\'">'+fontName + '</a></li>'));
            });
            $('.btn-toolbar a[title]').tooltip({container:'body'});
                $('.dropdown-menu input').click(function() {return false;})
                    .change(function () {$(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');})
                    .keydown('esc', function () {this.value='';$(this).change();});

            $('[data-role=magic-overlay]').each(function () { 
                var overlay = $(this), target = $(overlay.data('target')); 
                overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
            });
            if ("onwebkitspeechchange"  in document.createElement("input")) {
                var editorOffset = $('#newDescription').offset();
                $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#newDescription').innerWidth()-35});
            } else {
                $('#voiceBtn').hide();
            }
        };
        initToolbarBootstrapBindings();  
        $('#newDescription').wysiwyg();
        window.prettyPrint && prettyPrint();
    });
</script>