<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

$lang       = filter_input(INPUT_POST, "lang", FILTER_SANITIZE_STRING);
$string     = file_get_contents("../resources/locales/".$lang.".json");
$i18n       = json_decode($string, true);

?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header" style="background-color: #f0f0f0">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <span class="col-sm-9" style="float: left"><h4 class=""><?php echo $i18n['import']['header']['title']?></h4></span>
            <span class="col-sm-2" style="float: left"></span>
        </div>
        <div class="modal-body">
            <div class="row__">
                <div id="exTab2">
                    <ul class="nav nav-tabs">
                        <li class="active">
                            <a href="#tabFromFile" data-toggle="tab"><?php echo $i18n['import']['body']['from_file']?></a>
                        </li>
                        <li>
                            <a href="#tabFromURL" data-toggle="tab"><?php echo $i18n['import']['body']['from_url']?></a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tabFromFile">

                            <form id="formLoadICS" method="post" action="#" enctype="multipart/form-data">
                                <div class="row">
                                    <br />
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"><?php echo $i18n['import']['body']['from_file']?></label>
                                        <div class="col-sm-8">
                                           <input type="file" name="file" id="file" class="form-control" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                      <label class="col-sm-4 control-label"><?php echo $i18n['import']['body']['file_content']?></label>
                                      <div class="col-sm-12">
                                          <textarea class="form-control" rows="5" id="fileContent" name="fileContent" maxlength="255" readonly=""></textarea>
                                      </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <button id="btn_upload" type="button" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-upload"></i>&nbsp;<?php echo $i18n['import']['body']['upload']?></button>
                                    </div>
                                </div>
                            </form>
                            
                        </div>
                        <div class="tab-pane" id="tabFromURL">

                            <form id="formLoadURL" method="post" action="#">
                                <input type="hidden" name="importType" value="url" />
                                <input type="hidden" name="lang" value="<?php echo $lang; ?>" />
                                <div class="row">
                                    <br />
                                    <div class="form-group">
                                        <label class="col-sm-4 control-label"><?php echo $i18n['import']['body']['ics_from_url']?></label>
                                        <div class="col-sm-8">
                                            <input type="url" name="urlICS" id="urlICS" class="form-control" placeholder="http[s]://" autocomplete="off" required="" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button id="btn_upload_from_URL" type="submit" class="btn btn-warning btn-block"><i class="glyphicon glyphicon-upload"></i>&nbsp;<?php echo $i18n['import']['body']['upload']?></button>
                                        </div>
                                    </div>   
                                </div>                             
                            </form>
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            
        </div>
    </div>
</div>