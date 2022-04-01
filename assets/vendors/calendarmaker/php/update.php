<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require dirname(__FILE__) . '/../class/calendarMaker.php';

use \ToolsMakers;

$info       = json_decode(file_get_contents('php://input'), true);

if(isset($info['param'])){
    /* DROP and RESIZE events */
    $cA = new ToolsMakers\calendarMaker();    
    echo json_encode( $cA->updateEvent( $info['param'][0], $info['uuid'] ) );
}else{
    /* MODIFY event */
    $arr = [];
    $arr['eventType']               = "update";
    $arr['uuid']                    = filter_input(INPUT_POST, "editUUID", FILTER_SANITIZE_STRING);
    $arr['editLang']                = filter_input(INPUT_POST, "editLang", FILTER_SANITIZE_STRING);
    $arr['idEvent']                 = filter_input(INPUT_POST, "editIdEvent", FILTER_SANITIZE_NUMBER_INT);
    $arr['dateType']                = filter_input(INPUT_POST, "editDateType", FILTER_SANITIZE_STRING);
    $arr['title']                   = filter_input(INPUT_POST, "editTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
    $arr['description']             = $_POST['editDescription2'];
    $arr['recurring']               = filter_input(INPUT_POST, "editRecurring", FILTER_SANITIZE_STRING);
    $arr['category']                = filter_input(INPUT_POST, "editCalendarCategory", FILTER_SANITIZE_STRING);    
    $arr['editMonthTimeRecurring']  = filter_input(INPUT_POST, "editMonthTimeRecurring", FILTER_SANITIZE_STRING);
    $arr['editYearTimeRecurring']   = filter_input(INPUT_POST, "editYearTimeRecurring", FILTER_SANITIZE_STRING);
    $arr['editEndRecurring']        = filter_input(INPUT_POST, "editEndRecurring", FILTER_SANITIZE_STRING);
    $arr['dateType2']               = filter_input(INPUT_POST, "editDayOfWeek", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
    $arr['customFields']            = filter_input(INPUT_POST, "editCustom", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);    
    $arr['eachNumberDays']          = filter_input(INPUT_POST, "editEachNumberDays", FILTER_SANITIZE_NUMBER_INT);
    $arr['eachNumberWeeks']         = filter_input(INPUT_POST, "editEachNumberWeeks", FILTER_SANITIZE_NUMBER_INT);
    $arr['eachNumberMonths']        = filter_input(INPUT_POST, "editEachNumberMonths", FILTER_SANITIZE_NUMBER_INT);
    $arr['endOccurrences']          = filter_input(INPUT_POST, "editEndOccurrences", FILTER_SANITIZE_NUMBER_INT);
    $arr['colorBg']                 = filter_input(INPUT_POST, "editColorBg", FILTER_SANITIZE_STRING);
    $arr['colorText']               = filter_input(INPUT_POST, "editColorText", FILTER_SANITIZE_STRING);
    $arr['url']                     = filter_input(INPUT_POST, "editUrl", FILTER_SANITIZE_URL);
    $arr['endDateRecurring']        = filter_input(INPUT_POST, "editendvaldp1", FILTER_SANITIZE_STRING);    
    if($arr['dateType'] === "allday"){
        $arr['start']      = filter_input(INPUT_POST, "editvaldp1", FILTER_SANITIZE_STRING);
        $arr['end']        = filter_input(INPUT_POST, "editvaldp2", FILTER_SANITIZE_STRING);
    }elseif($arr['dateType'] === "custom"){
        $arr['start']      = filter_input(INPUT_POST, "editvaldtp1", FILTER_SANITIZE_STRING);
        $arr['end']        = filter_input(INPUT_POST, "editvaldtp2", FILTER_SANITIZE_STRING);
    }else{
        echo json_encode(['status' => false, 'msg' => 'an error has occurred']); exit;
    }

    if( trim($arr['title']) === "" ){
        echo json_encode(['status' => false, 'msg' => 'event title not defined']); exit;
    }

    if(!isset($arr['editLang'])){ $arr['editLang'] = 'en'; }
    
    $cA = new ToolsMakers\calendarMaker();
    echo json_encode( $cA->updateEvent($arr, $arr['uuid']) );

}