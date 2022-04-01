<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace Kigkonsult\Icalcreator;

use Kigkonsult\Icalcreator\Vcalendar;
use Kigkonsult\Icalcreator\Util\Util;
use kigkonsult\iCalcreator\TimezoneHandler;
use DateTime;
use DateTimezone;


require dirname(__FILE__) . '/../class/momentPHP.php';
require dirname(__FILE__) . '/../class/iCalcreator-master/autoload.php';
require dirname(__FILE__) . '/../class/calendarMaker.php';

$uuid       = filter_input(INPUT_GET, "uuid", FILTER_SANITIZE_STRING);


use \ToolsMakers;
$cA = new ToolsMakers\calendarMaker();
$ev = $cA->getEvent(null, $uuid, "all");
$cal = $cA->getCalendar($uuid);

$result = $ev['event'];
        
if( count($ev['event']) > 0){

    $filename   = _DOMAIN . "[Calendar]";

    /* define time zone */
    $tz = date_default_timezone_get();

    /* create a new Vcalendar instance */
    $calendar = Vcalendar::factory( [ Vcalendar::UNIQUE_ID => _DOMAIN ] )

    /* required of some calendar software */
    ->setMethod( Vcalendar::PUBLISH )
    ->setXprop(  Vcalendar::X_WR_CALNAME,   $cal['calendar']['name'] )
    ->setXprop(  Vcalendar::X_WR_CALDESC,   $cal['calendar']['description'] )
    ->setXprop(  Vcalendar::X_WR_RELCALID,  $cal['calendar']['uuid'] )
    ->setXprop(  Vcalendar::X_WR_TIMEZONE,  $tz );


    for ($sEvent = 0; $sEvent < count($ev['event']); $sEvent++) {

        $Dtstart    = new \MomentPHP\MomentPHP($result[$sEvent]['start_event']);
        $Dtend      = new \MomentPHP\MomentPHP($result[$sEvent]['end_event']);

        /* create an calendar event component */
        $vevent1 = $calendar->newVevent()

            ->setSummary( $result[$sEvent]['title'] )
            ->setDescription( $result[$sEvent]['description'] );
        
            if($result[$sEvent]['allday'] == 1){
                $vevent1->setProperty( Util::$DTSTART, $Dtstart->format('Ymd'), [ "VALUE" => "DATE" ] );
                $vevent1->setProperty( Util::$DTEND, $Dtend->format('Ymd'), [ "VALUE" => "DATE" ] );
            }else{
                $vevent1->setDtstart( $Dtstart->format('Y-m-d H:i:s') );
                $vevent1->setDtend( $Dtend->format('Y-m-d H:i:s') );
            }


            if( ($result[$sEvent]['recurring'] !== "") && ( $result[$sEvent]['rrule'] !== "") ){ // rrule event

                if( $result[$sEvent]['recurring'] === "daily" ){

                    if($result[$sEvent]['allday'] == 1){
                        $vevent1->setProperty( Util::$DTSTART, $Dtstart->format('Ymd'), [ "VALUE" => "DATE" ] );
                        $vevent1->setProperty( Util::$DTEND, $Dtstart->add(1, 'day')->format('Ymd'), [ "VALUE" => "DATE" ] );
                    }else{
                        $vevent1->setDtstart( $Dtstart->format('Y-m-d H:i:s') );
                        $vevent1->setDtend( $Dtstart->format('Y-m-d ').$Dtend->format('H:i:s') );
                    }

                    $strRrule = explode(";", $result[$sEvent]['rrule']);
                    $varRRULE = []; unset($configRRULE); unset($configRDATE);
                    foreach ($strRrule as $key => $value) {
                        $varStr = explode("=", $value);
                        $varRRULE[$varStr[0]] = $varStr[1];
                    }

                    if (array_key_exists('FREQ', $varRRULE))        { $configRRULE[Vcalendar::FREQ] = $varRRULE['FREQ']; }
                    if (array_key_exists('BYDAY', $varRRULE))       { $configRRULE[Vcalendar::BYDAY] = [$varRRULE['BYDAY']]; }
                    if (array_key_exists('COUNT', $varRRULE))       { $configRRULE[Vcalendar::COUNT] = $varRRULE['COUNT']; }
                    if (array_key_exists('INTERVAL', $varRRULE))    { $configRRULE[Vcalendar::INTERVAL] = $varRRULE['INTERVAL']; }
                    if (array_key_exists('UNTIL', $varRRULE))       { $configRRULE[Vcalendar::UNTIL] = $Dtend->format('Ymd\THis\Z'); }

                    $vevent1->setRrule($configRRULE);

                }

                if( $result[$sEvent]['recurring'] === "weekly" ){

                    if($result[$sEvent]['allday'] == 1){
                        $vevent1->setProperty( Util::$DTSTART, $Dtstart->format('Ymd'), [ "VALUE" => "DATE" ] );
                        $vevent1->setProperty( Util::$DTEND, $Dtstart->add(1, 'day')->format('Ymd'), [ "VALUE" => "DATE" ] );
                    }else{
                        $vevent1->setDtstart( $Dtstart->format('Y-m-d H:i:s') );
                        $vevent1->setDtend( $Dtstart->format('Y-m-d ').$Dtend->format('H:i:s') );
                    }

                    $strRrule = explode(";", $result[$sEvent]['rrule']);
                    $varRRULE = []; unset($configRRULE); unset($configRDATE);
                    foreach ($strRrule as $key => $value) {
                        $varStr = explode("=", $value);
                        $varRRULE[$varStr[0]] = $varStr[1];
                    }

                    if (array_key_exists('FREQ', $varRRULE))        { $configRRULE[Vcalendar::FREQ] = $varRRULE['FREQ']; }
                    if (array_key_exists('BYDAY', $varRRULE))       { $configRRULE[Vcalendar::BYDAY] = [$varRRULE['BYDAY']]; }
                    if (array_key_exists('COUNT', $varRRULE))       { $configRRULE[Vcalendar::COUNT] = $varRRULE['COUNT']; }
                    if (array_key_exists('INTERVAL', $varRRULE))    { $configRRULE[Vcalendar::INTERVAL] = $varRRULE['INTERVAL']; }
                    if (array_key_exists('UNTIL', $varRRULE))       { $configRRULE[Vcalendar::UNTIL] = $Dtend->format('Ymd\THis\Z'); }

                    $vevent1->setRrule($configRRULE);

                }

                if( $result[$sEvent]['recurring'] === "monthly" ){

                    if($result[$sEvent]['allday'] == 1){
                        $vevent1->setProperty( Util::$DTSTART, $Dtstart->format('Ymd'), [ "VALUE" => "DATE" ] );
                        $vevent1->setProperty( Util::$DTEND, $Dtstart->add(1, 'day')->format('Ymd'), [ "VALUE" => "DATE" ] );
                    }else{
                        $vevent1->setDtstart( $Dtstart->format('Y-m-d H:i:s') );
                        $vevent1->setDtend( $Dtstart->format('Y-m-d ').$Dtend->format('H:i:s') );
                    }

                    $strRrule = explode(";", $result[$sEvent]['rrule']);
                    $varRRULE = []; unset($configRRULE); unset($configRDATE);
                    foreach ($strRrule as $key => $value) {
                        $varStr = explode("=", $value);
                        $varRRULE[$varStr[0]] = $varStr[1];
                    }

                    if (array_key_exists('FREQ', $varRRULE))        { $configRRULE[Vcalendar::FREQ] = $varRRULE['FREQ']; }
                    if (array_key_exists('BYDAY', $varRRULE))       { $configRRULE[Vcalendar::BYDAY] = [$varRRULE['BYDAY']]; }
                    if (array_key_exists('COUNT', $varRRULE))       { $configRRULE[Vcalendar::COUNT] = $varRRULE['COUNT']; }
                    if (array_key_exists('INTERVAL', $varRRULE))    { $configRRULE[Vcalendar::INTERVAL] = $varRRULE['INTERVAL']; }
                    if (array_key_exists('UNTIL', $varRRULE))       { $configRRULE[Vcalendar::UNTIL] = $Dtend->format('Ymd\THis\Z'); }
                    if (array_key_exists('BYSETPOS', $varRRULE))    { $configRRULE[Vcalendar::BYSETPOS] = $varRRULE['BYSETPOS']; }
                    if (array_key_exists('BYMONTHDAY', $varRRULE))  { $configRRULE[Vcalendar::BYMONTHDAY] = $varRRULE['BYMONTHDAY']; }

                    $vevent1->setRrule($configRRULE);

                }

                if( $result[$sEvent]['recurring'] === "yearly" ){

                    if($result[$sEvent]['allday'] == 1){
                        $vevent1->setProperty( Util::$DTSTART, $Dtstart->format('Ymd'), [ "VALUE" => "DATE" ] );
                        $vevent1->setProperty( Util::$DTEND, $Dtstart->add(1, 'day')->format('Ymd'), [ "VALUE" => "DATE" ] );
                    }else{
                        $vevent1->setDtstart( $Dtstart->format('Y-m-d H:i:s') );
                        $vevent1->setDtend( $Dtstart->format('Y-m-d ').$Dtend->format('H:i:s') );
                    }

                    $strRrule = explode(";", $result[$sEvent]['rrule']);
                    $varRRULE = []; unset($configRRULE); unset($configRDATE);
                    foreach ($strRrule as $key => $value) {
                        $varStr = explode("=", $value);
                        $varRRULE[$varStr[0]] = $varStr[1];
                    }

                    if (array_key_exists('FREQ', $varRRULE))        { $configRRULE[Vcalendar::FREQ] = $varRRULE['FREQ']; }
                    if (array_key_exists('BYDAY', $varRRULE))       { $configRRULE[Vcalendar::BYDAY] = [$varRRULE['BYDAY']]; }
                    if (array_key_exists('COUNT', $varRRULE))       { $configRRULE[Vcalendar::COUNT] = $varRRULE['COUNT']; }
                    if (array_key_exists('INTERVAL', $varRRULE))    { $configRRULE[Vcalendar::INTERVAL] = $varRRULE['INTERVAL']; }
                    if (array_key_exists('UNTIL', $varRRULE))       { $configRRULE[Vcalendar::UNTIL] = $Dtend->format('Ymd\THis\Z'); }
                    if (array_key_exists('BYSETPOS', $varRRULE))    { $configRRULE[Vcalendar::BYSETPOS] = $varRRULE['BYSETPOS']; }
                    if (array_key_exists('BYMONTHDAY', $varRRULE))  { $configRRULE[Vcalendar::BYMONTHDAY] = $varRRULE['BYMONTHDAY']; }
                    if (array_key_exists('BYMONTH', $varRRULE))     { $configRRULE[Vcalendar::BYMONTH] = $varRRULE['BYMONTH']; }

                    $vevent1->setRrule($configRRULE);

                }

                if( $result[$sEvent]['exdate'] != "" ){
                    $arrExdate = explode(",", $result[$sEvent]['exdate']);
                    foreach ($arrExdate as $value) {
                        $DtExdate    = new \MomentPHP\MomentPHP($value);
                        if($result[$sEvent]['allday'] == 1){
                            $vevent1->setExdate( $DtExdate->format('Ymd'), [ "VALUE" => "DATE" ]);
                        }else{
                            $vevent1->setExdate( new DateTime( $DtExdate->format('Y-m-d ').$DtExdate->format('H:i:s') , new DateTimezone( $tz )));
                        }
                    }
                }
            }


        }

        $calendarString = $calendar->vtimezonePopulate()->createCalendar();
        header("Content-Type: text/calendar; charset=utf-8");
        header("Content-Disposition: inline; filename=".$filename.".ics");
        echo $calendarString; exit;


}else{
    echo "No events"; exit;
}