<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;

$deleteType = filter_input(INPUT_POST, "deleteType", FILTER_SANITIZE_STRING);
$lang       = filter_input(INPUT_POST, "lang", FILTER_SANITIZE_STRING);
$uuid       = filter_input(INPUT_POST, "uuid", FILTER_SANITIZE_STRING);
$id         = filter_input(INPUT_POST, "id", FILTER_SANITIZE_NUMBER_INT);
$readOnly   = filter_input(INPUT_POST, "readOnly", FILTER_VALIDATE_BOOLEAN);

$string = file_get_contents("../resources/locales/".$lang.".json");
$i18n = json_decode($string, true);

require dirname(__FILE__) . '/../class/calendarMaker.php';

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
$cal = $cA->getCalendar($uuid);
$event = $cA->getEvent($id, $uuid);

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #f0f0f0">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span class="col-sm-9" style="float: left"><h4><?php echo $i18n['showEvent']['header']['title'] . (($deleteType == "recurring") ? (" [".$i18n['core']['recurring_event']."]") : "");?></h4></span>
            <span class="col-sm-2" style="float: left"></span>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="form-group">
                    <label class="col-sm-2 control-label"><?php echo $i18n['showEvent']['body']['title']?></label>
                    <div class="col-sm-10">
                        <div class="input-group">
                            <span class="input-group-addon spaceIcon"><i id="bgColorBullet" class="glyphicon glyphicon-stop"></i></span>
                            <input type="text" class="form-control" id="showTitle" name="showTitle" placeholder="<?php echo $i18n['showEvent']['body']['placeholder_title']?>" readonly="" />
                        </div>
                    </div>
                </div>               
            </div>
            <div class="row">
                <div class="form-group">
                  <label class="col-sm-2 control-label"><?php echo $i18n['showEvent']['body']['description']?></label>
                  <div class="col-sm-10">
                      <div id="showDescription" class="mainField"></div>
                  </div>
                </div>
            </div>       
            <div class="userExist" id="divUtenteEsistente">
                <div class="row">
                    <div class="form-group">
                        <label class="col-sm-2 col-xs-12 control-label"><?php echo $i18n['showEvent']['body']['start_end']?></label>
                        <div class="col-sm-5 col-xs-12">
                            <input id="showStartAt" type="text" class="form-control" readonly="" />
                        </div>
                        <div class="hidden-lg hidden-sm hidden-md col-xs-12"><br /></div>
                        <div class="col-sm-5 col-xs-12">
                            <input id="showEndAt" type="text" class="form-control" readonly="" />
                        </div>                        
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <?php if($readOnly){ ?>
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-primary" data-dismiss="modal" aria-hidden="true"><?php echo $i18n['showEvent']['footer']['close']?></button>
            </div>
            <?php }else{ ?>
            <div class="btn-group" role="group">
                <?php if($deleteType == "recurring") {?>
                <div class="btn-group dropup" role="group">
                    <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="glyphicon glyphicon-remove-sign"></i>&nbsp;<?php echo $i18n['showEvent']['footer']['delete']?>&nbsp;<span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu">
                        <li><a id="btnDeleteSingleEvent" href="#"><?php echo $i18n['showEvent']['footer']['delete_this_event']?></a></li>
                        <li><a id="bntDeleteEvent" href="#"><?php echo $i18n['showEvent']['footer']['delete_all_events']?></a></li>
                    </ul>
                </div>
                <?php }else{ ?>
                <div class="btn-group dropup" role="group">
                    <button id="bntDeleteEvent" type="button" class="btn btn-danger"><i class="glyphicon glyphicon-remove-sign"></i>&nbsp;<?php echo $i18n['showEvent']['footer']['delete']?></button>
                </div>
                <?php } ?>
                <button id="btnEditEvent" type="button" class="btn btn-primary" style="float: left"><i class="glyphicon glyphicon-edit"></i>&nbsp;<?php echo $i18n['showEvent']['footer']['edit']?></button>
                <button id="btnExportEvent" type="button" class="btn btn-warning" style="float: left"><i class="glyphicon glyphicon-export"></i>&nbsp;<?php echo $i18n['showEvent']['footer']['export']?></button>
            </div>
            <?php }?>

        </div>
    </div>
</div>