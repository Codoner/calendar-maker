<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace Kigkonsult\Icalcreator;
namespace ToolsMakers;
    
use Kigkonsult\Icalcreator\Vcalendar;
use Kigkonsult\Icalcreator\Util\Util;
use kigkonsult\iCalcreator\TimezoneHandler;
use DateTime;
use DateTimezone;
use ToolsMakers;

$out = ['status' => false, 'msg' => 'something is wrong'];

require dirname(__FILE__) . '/../class/momentPHP.php';
require dirname(__FILE__) . '/../class/iCalcreator-master/autoload.php';
require dirname(__FILE__) . '/../class/calendarMaker.php';

$type   = filter_input(INPUT_POST, "importType", FILTER_SANITIZE_STRING);
$url    = filter_input(INPUT_POST, "urlICS", FILTER_SANITIZE_URL);


if($type == "url"){
    
    $lang = filter_input(INPUT_POST, "lang", FILTER_SANITIZE_STRING);
    $config    = array( "unique_id" => _DOMAIN, "url" => $url );
    
}else{

    $lang = filter_input(INPUT_POST, "lang", FILTER_SANITIZE_STRING);
    $file_extension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

    if(in_array($file_extension, ["ics"])){

        $config    = array( "unique_id" => "kigkonsult.se", "directory" => dirname($_FILES["file"]["tmp_name"]), "filename" => basename($_FILES["file"]["tmp_name"]) );

    }else{

        echo json_encode(['status' => false, 'msg' => 'This file type is not supported : '.$file_extension]); exit;
    }

}

$cA = new ToolsMakers\calendarMaker();

$vcalendar = new vcalendar( $config );
$vcalendar->parse();

$ev = []; $i = 0;

while( $vevent = $vcalendar->getComponent( "vevent" )) {

    $ev[$i]['uid']          = $vevent->getProperty( "uid" );
    $ev[$i]['summary']      = $vevent->getProperty( "summary" );
    $ev[$i]['description']  = $vevent->getProperty( "description" );
    $t0 = $vevent->getProperty( "dtstart" );
    $T0year     = (isset($t0['year']) ? $t0['year'] : "0000");
    $T0month    = (isset($t0['month']) ? $t0['month'] : "00");
    $T0day      = (isset($t0['day']) ? $t0['day'] : "00");
    $T0hour     = (isset($t0['hour']) ? $t0['hour'] : "00");
    $T0min      = (isset($t0['min']) ? $t0['min'] : "00");
    $T0sec      = (isset($t0['sec']) ? $t0['sec'] : "00");
    $ev[$i]['start']        = $T0year."-".$T0month."-".$T0day."T".$T0hour.":".$T0min.":".$T0sec;
    
    $t1 = $vevent->getProperty( "dtend" );
    $T1year     = (isset($t1['year']) ? $t1['year'] : "0000");
    $T1month    = (isset($t1['month']) ? $t1['month'] : "00");
    $T1day      = (isset($t1['day']) ? $t1['day'] : "00");
    $T1hour     = (isset($t1['hour']) ? $t1['hour'] : "00");
    $T1min      = (isset($t1['min']) ? $t1['min'] : "00");
    $T1sec      = (isset($t1['sec']) ? $t1['sec'] : "00");
    $ev[$i]['end']          = $T1year."-".$T1month."-".$T1day."T".$T1hour.":".$T1min.":".$T1sec;
    if($ev[$i]['end'] === "0000-00-00T00:00:00"){ $ev[$i]['end'] = $T0year."-".$T0month."-".$T0day."T".($T0hour+1).":".$T0min.":".$T0sec; }
    $ev[$i]['allday']       = ((($T0hour.":".$T0min.":".$T0sec) == "00:00:00") && (($T1hour.":".$T1min.":".$T1sec) == "00:00:00")) ? 1 : 0;
    $ev[$i]['dtstart']      = ($ev[$i]['allday']==1) ? $T0year.$T0month.$T0day : $T0year.$T0month.$T0day."T".$T0hour.$T0min.$T0sec."Z";
    
    $rrules = $vevent->getProperty( "rrule" );
    
    if( $rrules ){
        
        $rrule = "";
        
        foreach( $rrules as $key => $value ) {
        
            if(is_array($value)){

                if ($key == "BYDAY"){

                    if(count($value) === 1){
                        $byDay = $value['DAY'];
                    }else if((count($value) > 1) && (is_array($value[0]))){
                        $byDay = implode(",", array_map(function($a) {  return array_pop($a); }, $value));
                    }else if((count($value) > 1) && (!is_array($value[0]))){
                        $byDay = $value[0].$value['DAY'];
                    }

                    $rrule .= "BYDAY=".$byDay.";";

                } else if($key == "UNTIL"){
                    $year   = $value['year'];
                    $month  = $value['month'];
                    $day    = $value['day'];
                    $hour   = isset($value['hour']) ? $value['hour'] : "";
                    $min    = isset($value['min']) ? $value['min'] : "";
                    $sec    = isset($value['sec']) ? $value['sec'] : "";
                    $tz     = isset($value['tz']) ? $value['tz'] : "";
                    $rrule .= ($hour.$min.$sec == "") ? "UNTIL=".$year . $month . $day . ";" : "UNTIL=".$year . $month . $day . "T" . $hour . $min . $sec . $tz . ";";

                } else { }

            }else{
                $rrule .= $key . "=" . $value .";";
            }
        }
        
        $ev[$i]['rrule'] = substr($rrule, 0, -1);
        
    }


    $i++;
    
}

if($type != "url"){
    $file_handle = file_get_contents($_FILES["file"]["tmp_name"]);
}else{
    $file_handle = "";
}
$outputArray = [];
foreach ($ev as $a => $b) {
    
    $dataArray = [];
    $dataArray['uid'] = $b['uid'];
    $dataArray['title'] = $b['summary'];
    $dataArray['description'] = str_replace(["\r\n", "\\n", "\n", "\r"], "<br />", $b['description']);
    $dataArray['allday'] = $b['allday'];
    $dataArray['start'] = $b['start'];
    $dataArray['end'] = $b['end'];
    $dataArray['color'] = '#fff000';
    $dataArray['textColor'] = '#000000';
    if(isset($b['rrule'])) { 
        $dataArray['rrule'] = "DTSTART:".$b['dtstart']."\nRRULE:".$b['rrule']; 
    }
    
    array_push($outputArray, $dataArray);
    
}

echo json_encode(['status' => true, 'msg' => 'ok', 'contentFile' => $file_handle, 'importedEvents' => $outputArray]); exit;