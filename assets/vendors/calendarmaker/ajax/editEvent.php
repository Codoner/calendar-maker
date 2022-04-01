<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require dirname(__FILE__) . '/../class/calendarMaker.php';

$info = json_decode(file_get_contents('php://input'), true);
$uuid = $info['uuid'];

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
$cal = $cA->getCalendar($uuid);

$string = file_get_contents("../resources/locales/".$info['lang'].".json");
$i18n = json_decode($string, true);

$arrCategories = (trim($cal['calendar']['categories']) != "") ? explode(",", $cal['calendar']['categories']) : null;
$arrCustomFields = (trim($cal['calendar']['customFields']) != "") ? explode(",", $cal['calendar']['customFields']) : null;

?>
<div class="modal-dialog">
    <form id="formEditEvent" method="post">
    <input type="hidden" name="editRecurring" id="editRecurring" value="<?php echo ($info['param']['event']['recurring'] !== "") ? $i18n['editEvent']['body']['does_not_repeat'] : $info['param']['event']['recurring'];?>" />
    <input type="hidden" name="editCalendarCategory" id="editCalendarCategory" value="<?php echo ($info['param']['event']['category'] != "") ? $info['param']['event']['category'] : "Select category"; ?>" />
    <input type="hidden" name="editTypeRecurring" id="editTypeRecurring" value="" />
    <input type="hidden" name="editMonthTimeRecurring" id="editMonthTimeRecurring" value="" />
    <input type="hidden" name="editYearTimeRecurring" id="editYearTimeRecurring" value="" />
    <input type="hidden" name="editEndRecurring" id="editEndRecurring" value="<?php echo $i18n['editEvent']['body']['never']?>" />
    <input type="hidden" name="editIdEvent" value="<?php echo $info['param']['event']['id']?>" />
    <input type="hidden" name="editLang" id="editLang" value="<?php echo $info['lang']?>" />
    <input type="hidden" name="editUUID" id="editUUID" value="<?php echo $info['uuid']?>" />
    <input type="hidden" name="editDescription2" id="editDescription2" value="<?php echo htmlspecialchars($info['param']['event']['description']);?>" />
    <div class="modal-content">
        <div class="modal-header" style="background-color: #f0f0f0">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span class="col-sm-4" style="float: left"><h4 class=""><?php echo $i18n['editEvent']['header']['title']?></h4></span>
            <span class="col-sm-7" style="float: left">
                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                    <label class="btn btn-primary<?php if($info['param']['event']['allday']=="1"){ echo ' active';}?>">
                        <input type="radio" name="editDateType" value="allday" data-toggle="button" <?php if($info['param']['event']['allday']=="1"){ echo ' checked';}?>> <?php echo $i18n['editEvent']['header']['allday']?>
                    </label>
                    <label class="btn btn-primary<?php if($info['param']['event']['allday']=="0"){ echo ' active';}?>">
                        <input type="radio" name="editDateType" value="custom"  data-toggle="button" <?php if($info['param']['event']['allday']=="0"){ echo ' checked';}?>> <?php echo $i18n['editEvent']['header']['custom']?>
                    </label>
                </div>                        
            </span>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-12 control-label"><?php echo $i18n['editEvent']['body']['title']?></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control mainField" id="editTitle" name="editTitle" placeholder="<?php echo $i18n['editEvent']['body']['placeholder_title']?>" value="<?php echo htmlspecialchars($info['param']['event']['title']);?>" autocomplete="off" required />
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-group">
                    <div class="col-sm-12">
                        <div class="btn-toolbar" data-role="editor-toolbar" data-target="#editDescription">
                            
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
                        <div id="editDescription" class="mainField"><?php echo $info['param']['event']['description'] ?></div>
                    </div>
                </div>
            </div>
            <div class="divEditDateAllday" id="divEditDateAllday"<?php if($info['param']['event']['allday']=="0"){ echo ' style="display: none"';}?>>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 col-xs-12 control-label"><?php echo $i18n['editEvent']['body']['start_end']?></label>
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group date" id="editdp1">
                                <input id="editvaldp1" name="editvaldp1" type="text" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="hidden-lg hidden-sm hidden-md col-xs-12"><br /></div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group date" id="editdp2">
                                <input id="editvaldp2" name="editvaldp2" type="text" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>                        
                    </div>
                </div>
            </div>
            <div class="divEditDateCustom" id="divEditDateCustom"<?php if($info['param']['event']['allday']=="1"){ echo ' style="display: none"';}?>>
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 col-xs-12 control-label"><?php echo $i18n['editEvent']['body']['start_end']?></label>
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group date" id="editdtp1">
                                <input id="editvaldtp1" name="editvaldtp1" type="text" class="form-control" />
                                <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                </span>
                            </div>
                        </div>
                        <div class="hidden-lg hidden-sm hidden-md col-xs-12"><br /></div>
                        <div class="col-sm-4 col-xs-12">
                            <div class="input-group date" id="editdtp2">
                                <input id="editvaldtp2" name="editvaldtp2" type="text" class="form-control" />
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
                    <label class="col-sm-4 control-label"><?php echo $i18n['editEvent']['body']['category']?></label>
                    <div class="col-sm-8 col-xs-12">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-block dropdown" type="button" id="editCategory" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span style="float: left"><?php echo ($i18n['custom']['categories']['none'] != "") ? $i18n['custom']['categories']['none'] : "Select category"; ?></span>
                                <span class="caret" style="margin-top: 8px; float: right"></span>
                            </button>
                            <ul class="dropdown-menu btn-block" id="editChooseCategory" aria-labelledby="editCategory">
                                <li><a id="editCat0" href="#" title="Select category"><?php echo ($i18n['custom']['categories']['none'] != "") ? $i18n['custom']['categories']['none'] : "Select category"; ?></a></li>
                                <?php foreach ($arrCategories as $key => $value) { ?>
                                <li><a id="editCat<?php echo $key+1?>" href="#" title="<?php echo $value ?>"><?php echo ($i18n['custom']['categories'][$value] != "") ? $i18n['custom']['categories'][$value] : $value;?></a></li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $i18n['editEvent']['body']['repeat']?></label>
                    <div class="col-sm-8 col-xs-12">
                        <div class="dropdown">
                            <button class="btn btn-primary btn-block dropup" type="button" id="editRepeat" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span style="float: left"><?php echo $i18n['editEvent']['body']['does_not_repeat']?></span>
                                <span class="caret" style="margin-top: 8px; float: right"></span>
                            </button>
                            <ul class="dropdown-menu btn-block" id="editChooseRecurring" aria-labelledby="editRepeat">
                                <li><a id="editRep0" href="#"><?php echo $i18n['editEvent']['body']['does_not_repeat']?></a></li>
                                <li><a id="editRep1" href="#"><?php echo $i18n['editEvent']['body']['daily_recurring']?></a></li>
                                <li><a id="editRep2" href="#"><?php echo $i18n['editEvent']['body']['weekly_recurring']?></a></li>
                                <li><a id="editRep3" href="#"><?php echo $i18n['editEvent']['body']['monthly_recurring']?></a></li>
                                <li><a id="editRep4" href="#"><?php echo $i18n['editEvent']['body']['yearly_recurring']?></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>            
            <div id="divEditRecurring" style="display: none">
                
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-4 col-xs-12 control-label"></label>
                        <div class="col-sm-8 col-xs-12">
                            
                            <div id="editDivDaysRecurring" class="form-group col-md-12 col-xs-12" style="padding:0; display: none">
                                
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['editEvent']['body']['each']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="editEachNumberDays" name="editEachNumberDays" value="1" min="1" max="365" />
                                        <span class="input-group-addon">
                                            <span class=""><?php echo $i18n['editEvent']['body']['days']?></span>
                                        </span>
                                    </div>
                                </div>
                                
                            </div>

                            <div id="editDivWeeksRecurring" class="form-group col-md-12 col-xs-12" style="padding:0; display: none">
                                    
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['editEvent']['body']['each']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="editEachNumberWeeks" name="editEachNumberWeeks" value="1" min="1" max="52" />
                                        <span class="input-group-addon">
                                            <span><?php echo $i18n['editEvent']['body']['weeks']?></span>
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
                                            <input type="checkbox" name="editDayOfWeek[]" value="0"> <?php echo strtoupper(substr($i18n['core']['days']['sunday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="editDayOfWeek[]" value="1"> <?php echo strtoupper(substr($i18n['core']['days']['monday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="editDayOfWeek[]" value="2"> <?php echo strtoupper(substr($i18n['core']['days']['tuesday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="editDayOfWeek[]" value="3"> <?php echo strtoupper(substr($i18n['core']['days']['wednesday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="editDayOfWeek[]" value="4"> <?php echo strtoupper(substr($i18n['core']['days']['thursday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="editDayOfWeek[]" value="5"> <?php echo strtoupper(substr($i18n['core']['days']['friday'],0,1));?>
                                        </label>
                                        <label class="btn btn-small btn-default">
                                            <input type="checkbox" name="editDayOfWeek[]" value="6"> <?php echo strtoupper(substr($i18n['core']['days']['saturday'],0,1));?>
                                        </label>
                                    </div>
                                </div>

                            </div>
                            
                            <div id="editDivMonthsRecurring" class="form-group col-md-12 col-xs-12" style="padding:0; display: none">

                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['editEvent']['body']['each']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="input-group">
                                        <input type="number" class="form-control" id="editEachNumberMonths" name="editEachNumberMonths" value="1" min="1" max="12" />
                                        <span class="input-group-addon">
                                            <span><?php echo $i18n['editEvent']['body']['months']?></span>
                                        </span>
                                    </div>
                                </div>
                                
                                <div class="col-md-12 col-sm-12 col-xs-12"><br></div>
                                
                                
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label">&nbsp;</label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle btn-block" type="button" id="editChooseMonthTime" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span style="float: left"></span>
                                            <span class="caret" style="margin-top: 8px; float: right"></span>
                                        </button>
                                        <ul class="dropdown-menu btn-block" id="editChooseMonthTimeRecurring" aria-labelledby="editChooseMonthTime">
                                            <li><a id="editRepMonth0" href="#"></a></li>
                                            <li><a id="editRepMonth1" href="#"></a></li>
                                        </ul>
                                    </div>                                
                                </div>                                
                                
                            </div>
                            
                            <div id="editDivYearsRecurring" class="form-group col-md-12 col-xs-12" style="padding:0; display: none">
                                
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['editEvent']['body']['each']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    <div class="dropdown">
                                        <button class="btn btn-default dropdown-toggle btn-block" type="button" id="editChooseYearTime" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <span style="float: left"></span>
                                            <span class="caret" style="margin-top: 8px; float: right"></span>
                                        </button>
                                        <ul class="dropdown-menu btn-block" id="editChooseYearTimeRecurring" aria-labelledby="editChooseYearTime">
                                            <li><a id="editRepYear0" href="#"></a></li>
                                            <li><a id="editRepYear1" href="#"></a></li>
                                        </ul>
                                    </div>                                
                                </div>                                   
                            </div>
                            
                            <div class="form-group col-md-12 col-xs-12" style="padding:0">
                                
                                <div class="col-md-3 col-sm-3 col-xs-12" style="padding:0; text-align: left">
                                    <label class="control-label"><?php echo $i18n['editEvent']['body']['end']?></label>
                                </div>
                                <div class="col-md-9 col-sm-9 col-xs-12" style="padding:0; text-align: right">
                                    
                                    <ul class="nav nav-pills nav-justified" id="editEndRecurring" role="tablist">
                                        <li class="nav-item">
                                            <a style="padding: 1px; margine: 0" class="nav-link" id="edit-pills-never-tab" data-toggle="pill" href="#edit-pills-never" role="tab" aria-controls="edit-pills-never" aria-selected="true"><?php echo $i18n['editEvent']['body']['never']?></a>
                                        </li>
                                        <li class="nav-item" style="padding: 1px; margine: 0">
                                            <a style="padding: 1px; margine: 0" class="nav-link" id="edit-pills-date-tab" data-toggle="pill" href="#edit-pills-date" role="tab" aria-controls="edit-pills-date" aria-selected="false"><?php echo $i18n['editEvent']['body']['date']?></a>
                                        </li>
                                        <li class="nav-item" style="padding: 1px; margine: 0">
                                            <a style="padding: 1px; margine: 0" class="nav-link" id="edit-pills-after-tab" data-toggle="pill" href="#edit-pills-after" role="tab" aria-controls="edit-pills-after" aria-selected="false"><?php echo $i18n['editEvent']['body']['after']?></a>
                                        </li>
                                    </ul>
                                    <div class="tab-content" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="edit-pills-never" role="tabpanel" aria-labelledby="edit-pills-never-tab"></div>
                                        <div class="tab-pane fade" id="edit-pills-date" role="tabpanel" aria-labelledby="edit-pills-date-tab">
                                            <div class="row" style="text-align: right; padding: 0; margin-left: 0; margin-right: 0">
                                                <div class="input-group date" id="editenddp1">
                                                    <input id="editendvaldp1" name="editendvaldp1" type="text" class="form-control" />
                                                    <span class="input-group-addon">
                                                        <span class="glyphicon glyphicon-calendar"></span>
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="tab-pane fade" id="edit-pills-after" role="tabpanel" aria-labelledby="edit-pills-after-tab">
                                            <div class="row" style="text-align: right; padding: 0; margin-left: 0; margin-right: 0">
                                                <div class="input-group">
                                                    <input type="number" class="form-control" id="editEndOccurrences" name="editEndOccurrences" value="1" max="50" min="1" />
                                                    <span class="input-group-addon"><?php echo $i18n['editEvent']['body']['occurrences']?></span>
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
                  <label class="col-sm-4 col-xs-12 control-label"><?php echo $i18n['editEvent']['body']['event_color']?></label>
                  <div class="col-sm-4 col-xs-6">
                     <div class="input-group">
                        <div id="editCP1" class="input-group colorpicker-component">
                            <span class="input-group-addon"><i></i></span>
                            <input id="editColorBg" name="editColorBg" type="text" value="<?php echo trim($info['param']['event']['color'])?>" class="form-control" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-background"></span></span>
                        </div>  
                     </div>
                  </div>
                  <div class="col-sm-4 col-xs-6">
                     <div class="input-group">
                        <div id="editCP2" class="input-group colorpicker-component">
                            <span class="input-group-addon"><i></i></span>
                            <input id="editColorText" name="editColorText" type="text" value="<?php echo trim($info['param']['event']['text_color'])?>" class="form-control" />
                            <span class="input-group-addon"><span class="glyphicon glyphicon-text-color"></span></span>
                        </div>
                     </div>
                  </div>
                </div>
            </div>            
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-4 control-label"><?php echo $i18n['editEvent']['body']['url']?></label>
                    <div class="col-sm-8 col-xs-12">
                        <div class="input-group">
                            <input id="editUrl" name="editUrl" type="url" class="form-control" placeholder="<?php echo $i18n['editEvent']['body']['placeholder_url']?>" maxlength="255" autocomplete="off" value="<?php echo $info['param']['event']['url'];?>" />
                            <span class="input-group-addon">
                                <?php if(trim($info['param']['event']['url'])!=""){ ?>
                                <a href="<?php echo trim($info['param']['event']['url'])?>" target="_blank" id="editGoUrl"><span class="glyphicon glyphicon-link"></span></a>
                                <?php }else{ ?>
                                <span class="glyphicon glyphicon-link"></span>
                                <?php } ?>
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
                        <input type="text" class="form-control" name="editCustom[<?php echo $arrCustomFields[$cF] ?>]" value="<?php echo htmlspecialchars($info['param']['event']['extendedProps'][$arrCustomFields[$cF]]);?>" maxlength="255" autocomplete="off" />
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
        <div class="modal-footer">
            <button id="updateEvent" type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-save"></i>&nbsp;<?php echo $i18n['editEvent']['footer']['update']?></button>
        </div>
    </div>
    </form>
</div>
<!-- Wysiwyg editor CSS -->
<link href="<?php echo APPLICATION_PATH?>/assets/vendors/prettify/prettify.css" rel="stylesheet" />
<link href="<?php echo APPLICATION_PATH?>/assets/vendors/bootstrap-wysiwyg/css/style.css" rel="stylesheet" />
<!-- Wysiwyg editor JS -->
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
                var editorOffset = $('#editDescription').offset();
                $('#voiceBtn').css('position','absolute').offset({top: editorOffset.top, left: editorOffset.left+$('#editDescription').innerWidth()-35});
            } else {
                $('#voiceBtn').hide();
            }
        };
        initToolbarBootstrapBindings();  
        $('#editDescription').wysiwyg();
        window.prettyPrint && prettyPrint();
    });
  
</script>
    