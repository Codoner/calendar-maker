<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;
require dirname(__FILE__) . '/../class/calendarMaker.php';

$lang   = filter_input(INPUT_POST, "newLang", FILTER_SANITIZE_STRING);
$uuid   = filter_input(INPUT_POST, "newUUID", FILTER_SANITIZE_STRING);

use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();


$arr = [];
$arr['uuid']                    = $uuid;
$arr['lang']                    = $lang;
$arr['dateType']                = filter_input(INPUT_POST, "newDateType", FILTER_SANITIZE_STRING);
$arr['title']                   = filter_input(INPUT_POST, "newTitle", FILTER_SANITIZE_STRING, FILTER_FLAG_NO_ENCODE_QUOTES);
$arr['description']             = $_POST['newDescription2'];
$arr['recurring']               = filter_input(INPUT_POST, "newRecurring", FILTER_SANITIZE_STRING);
$arr['category']                = filter_input(INPUT_POST, "newCalendarCategory", FILTER_SANITIZE_STRING);
$arr['newMonthTimeRecurring']   = filter_input(INPUT_POST, "newMonthTimeRecurring", FILTER_SANITIZE_STRING);
$arr['newYearTimeRecurring']    = filter_input(INPUT_POST, "newYearTimeRecurring", FILTER_SANITIZE_STRING);
$arr['newEndRecurring']         = filter_input(INPUT_POST, "newEndRecurring", FILTER_SANITIZE_STRING);
$arr['dateType2']               = filter_input(INPUT_POST, "newDayOfWeek", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$arr['customFields']            = filter_input(INPUT_POST, "newCustom", FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
$arr['eachNumberDays']          = filter_input(INPUT_POST, "newEachNumberDays", FILTER_SANITIZE_NUMBER_INT);
$arr['eachNumberWeeks']         = filter_input(INPUT_POST, "newEachNumberWeeks", FILTER_SANITIZE_NUMBER_INT);
$arr['eachNumberMonths']        = filter_input(INPUT_POST, "newEachNumberMonths", FILTER_SANITIZE_NUMBER_INT);
$arr['endOccurrences']          = filter_input(INPUT_POST, "newEndOccurrences", FILTER_SANITIZE_NUMBER_INT);
$arr['colorBg']                 = filter_input(INPUT_POST, "newColorBg", FILTER_SANITIZE_STRING);
$arr['colorText']               = filter_input(INPUT_POST, "newColorText", FILTER_SANITIZE_STRING);
$arr['url']                     = filter_input(INPUT_POST, "newUrl", FILTER_SANITIZE_URL);
$arr['endDateRecurring']        = filter_input(INPUT_POST, "newendvaldp1", FILTER_SANITIZE_STRING);
if ((trim($arr['url']) !== "") && filter_var($arr['url'], FILTER_VALIDATE_URL) === false) { echo json_encode(['status' => false, 'msg' => 'Invalid URL : '.$arr['url']]); exit; }
if($arr['dateType'] === "allday"){
    $arr['start']               = filter_input(INPUT_POST, "newvaldp1", FILTER_SANITIZE_STRING);
    $arr['end']                 = filter_input(INPUT_POST, "newvaldp2", FILTER_SANITIZE_STRING);
}elseif($arr['dateType'] === "custom"){
    $arr['start']               = filter_input(INPUT_POST, "newvaldtp1", FILTER_SANITIZE_STRING);
    $arr['end']                 = filter_input(INPUT_POST, "newvaldtp2", FILTER_SANITIZE_STRING);
}else{
    echo json_encode(['status' => false, 'msg' => 'an error has occurred']); exit;
}

if( trim($arr['title']) === "" ){ echo json_encode(['status' => false, 'msg' => 'event title not defined']); exit; }


echo json_encode( $cA->addEvent($arr) );