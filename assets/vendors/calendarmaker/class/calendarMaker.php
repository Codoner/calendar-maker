<?php

/*!
 * Featured Calendar Maker v1.0
 * Copyright 2020 ToolsMakers
 * Docs & License: https://www.toolsmakers.com/
 */

namespace ToolsMakers;

##########################################################################################
##########################################################################################
###
###                                  Global Variables
###

error_reporting(0);

# Load configuration file
$_CONFIG = (file_exists((dirname(__FILE__)).'/config.php') ? require_once 'config.php' : '');
# Check if installed application
define('INSTALLED', is_array($_CONFIG) ? true : false);
# Domain name
define('_DOMAIN', preg_replace("/^(.*\.)?([^.]*\..*)$/", "$2", $_SERVER['HTTP_HOST']));
# Define URL HTTP/HTTPS
define('_URLSECURE', (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST']);
# Application name
define('TITLE_APP', 'Featured Calendar Maker v1.0');        
# Applcation company
define('COMPANY_APP', 'ToolsMakers');
# Company website
define('COMPANY_WEBSITE', 'https://www.toolsmakers.com');
# Name of the calendar settings table
define('TBL_SETTINGS', $_CONFIG['db']['table_settings']);                          
# Name of the calendar table
define('TBL_EVENTS', $_CONFIG['db']['table_events']);                              
# Name of the calendar users table
define('TBL_USERS', $_CONFIG['db']['table_users']);                                
# Default event text color
define('TEXT_COLOR', '#ffffff');                                    
# Default event background color
define('BG_COLOR', '#7da800');                                      
# Default calendar language
define('DEF_LANG', 'en');
# Root application path
define('__ROOT__', dirname(dirname(__FILE__)));
# Path of application
define('APPLICATION_PATH', _URLSECURE . (($_CONFIG['application_path']) ? $_CONFIG['application_path'] : dirname(dirname( $_SERVER['PHP_SELF']) )));
# Backend path
define('_DIR_BE', APPLICATION_PATH . '/admin');
# Install path
define('INSTALL_PAGE', APPLICATION_PATH . '/install');
# Login page
define('LOGIN_PAGE', _DIR_BE . '/login.php');
# Logout page
define('LOGOUT_PAGE', _DIR_BE . '/logout.php');
# Database connection parameters
define('DB_CONN_HOSTNAME', $_CONFIG['db']['hostname']);
define('DB_CONN_PORT', $_CONFIG['db']['port']);
define('DB_CONN_DBNAME', $_CONFIG['db']['dbname']);
define('DB_CONN_USER', $_CONFIG['db']['user']);
define('DB_CONN_PASS', $_CONFIG['db']['pass']);

###
##########################################################################################
##########################################################################################

class calendarMaker {

    private static $dbh;
    private static $tblEvents = TBL_EVENTS;
    private static $tblSettings = TBL_SETTINGS;
    private static $tblUsers = TBL_USERS;
    private static $db_conn = ['hostname' => DB_CONN_HOSTNAME, 'port' => DB_CONN_PORT, 'dbname' => DB_CONN_DBNAME, 'user' => DB_CONN_USER, 'pass' => DB_CONN_PASS];
    public static $initialized;
    private static $lang = "en";
    public $i18n = [];
    
    
    public function __construct() {
        if(!isset($_SESSION)){ session_start(); }
    }
    
    private static function init(){
        
        try {

            $dsn = 'mysql:host=' . self::$db_conn['hostname'] . ';dbname=' . self::$db_conn['dbname'] . ';port=' . self::$db_conn['port'] .';connect_timeout=15';
            self::$dbh = new \PDO($dsn, self::$db_conn['user'], self::$db_conn['pass']);
            self::$dbh->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $s = self::$dbh->prepare("SET NAMES 'utf8'"); $s->execute();
            return ['status' => true, 'msg' => 'ok'];

            
        } catch (\PDOException $e) {
            
            return ['status' => false, 'msg' => 'Database connection error : '.$e->getMessage().' FILE : '.$e->getFile()." LINE : ". $e->getLine()];
            
        }

    }
    
    private static function loadI18n($lang){
        
        try {
            if(file_exists(dirname(__FILE__) . "/../resources/locales/".$lang.".json")){
                $string = file_get_contents( dirname(__FILE__) . "/../resources/locales/".$lang.".json");
                return json_decode($string, true);
            }else{
                $string = file_get_contents( dirname(__FILE__) . "/../resources/locales/".self::$lang.".json");
                return json_decode($string, true);  
            }

        } catch (Exception $exc) {
            //echo $exc->getTraceAsString();
            $string = file_get_contents( dirname(__FILE__) . "/../resources/locales/".self::$lang.".json");
            return json_decode($string, true);            
        }
        
    }

    private static function RandomToken($length = 16){
        
        if(!isset($length) || intval($length) <= 8 ){
          $length = 32;
        }
        if (function_exists('random_bytes')) {
            return bin2hex(random_bytes($length));
        }
        if (function_exists('mcrypt_create_iv')) {
            return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
        }
        if (function_exists('openssl_random_pseudo_bytes')) {
            return bin2hex(openssl_random_pseudo_bytes($length));
        }
        
    }
    
    private static function getDuration($dt1, $dt2){
        
        $origin = new \DateTime($dt1);
        $interval = $origin->diff(new \DateTime($dt2));
        return sprintf("%02d:%02d", $interval->h, $interval->i);
        
    }
    
    public static function generate_UUID(){
        
        return sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x',mt_rand(0,0xffff),mt_rand(0,0xffff),mt_rand(0,0xffff),mt_rand(0,0x0C2f)|0x4000,mt_rand(0,0x3fff)|0x8000,mt_rand(0,0x2Aff),mt_rand(0,0xffD3),mt_rand(0,0xff4B));
        
    }
    
    public function getEvent($id = null, $uuid = null, $cmd = null) {

        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }
        if( trim($uuid) === "" ) { return ["status" => false, "msg" => "UUID calendar not specified" ]; }

        try {
            
            if( strtolower(trim($cmd)) == "all") {
                
                $q = "SELECT e.* FROM ".self::$tblSettings." s LEFT JOIN ".self::$tblEvents." e ON e.calId = s.id WHERE s.uuid = :uuid";
                $s = self::$dbh->prepare($q);
                $s->execute(['uuid' => $uuid]);
                $rs = $s->fetchAll(\PDO::FETCH_ASSOC);
                self::$dbh = null;
                return ($s->rowCount() > 0) ? ['status' => true, 'event' => $rs] : ['status' => false, 'msg' => 'Event not found'];
                
            }else{

                if($id > 0) {

                    $q = "SELECT e.* FROM ".self::$tblSettings." s LEFT JOIN ".self::$tblEvents." e ON e.calId = s.id AND e.id = :id WHERE s.uuid = :uuid";
                    $s = self::$dbh->prepare($q);
                    $s->execute(['id' => $id, 'uuid' => $uuid]);
                    $rs = $s->fetchAll(\PDO::FETCH_ASSOC);
                    self::$dbh = null;
                    
                    if(trim($rs[0]['custom']) === ""){
                        $events = $rs[0];
                    } else {
                        $rs[0]['extendedProps'] = json_decode($rs[0]['custom'], false);
                        unset($rs[0]['custom']);
                        $events = $rs[0];
                    }
                    $events = $rs[0];
                    return ($s->rowCount() > 0) ? ['status' => true, 'event' => $events] : ['status' => false, 'msg' => 'Event not found'];

                }else{
                    
                    self::$dbh = null;
                    return ['status' => true, 'msg' => 'Read only content cannot be changed', 'import' => 1];
                    
                }
                
            }
            

        } catch (\Exception $exc) {

            self::$dbh = null;
            return ['status' => false, 'msg' => $exc->getMessage() ];

        }        
        

    }  
    
    public function getCalendar($uuid = null, $cmd = null) {
        
        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }
        
        try {

            if( strtolower(trim($cmd)) == "all") {
                
                $q = "SELECT * FROM ".self::$tblSettings;
                $s = self::$dbh->prepare($q);
                $s->execute();
                $rs = $s->fetchAll(\PDO::FETCH_ASSOC);
                self::$dbh = null;
                return ($s->rowCount() > 0) ? ['status' => true, 'calendar' => $rs] : ['status' => true, 'calendar' => null, 'msg' => 'Calendar not found'];
                
            }else{

                if( trim($uuid) <> "") {

                    $q = "SELECT * FROM ".self::$tblSettings." WHERE uuid = :uuid";
                    $s = self::$dbh->prepare($q);
                    $s->execute(['uuid' => $uuid]);
                    $rs = $s->fetchAll(\PDO::FETCH_ASSOC);
                    self::$dbh = null;
                    return ($s->rowCount() > 0) ? ['status' => true, 'calendar' => $rs[0]] : ['status' => false, 'msg' => 'Calendar not found'];                

                }else{

                    self::$dbh = null;
                    return ['status' => false, 'msg' => 'Missing UUID calendar'];

                }

            }
            


        } catch (\Exception $exc) {

            self::$dbh = null;
            return ['status' => false, 'msg' => $exc->getMessage() ];

        }

    }    
    
    public function deleteEvent($id = null, $eventDate = null, $uuid = null) {

        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }
        
        if($id > 0) {
            
            if( $eventDate == null){
                // single event
                try {

                    $q = "DELETE FROM ".self::$tblEvents." WHERE calId = (SELECT id FROM ".self::$tblSettings." WHERE uuid = :uuid) AND ".self::$tblEvents.".id = :id";
                    $s = self::$dbh->prepare($q);
                    return ($s->execute(['id' => $id, 'uuid' => $uuid])) ? ['status' => true, 'msg' => 'ok'] : ['status' => false, 'msg' => 'Error: the selected event was not deleted'];

                } catch (\Exception $exc) {

                    return ['status' => false, 'msg' => $exc->getMessage() ];

                }
            
            }else{
                // rrule event
                try {

                    $q = "SELECT e.* FROM ".self::$tblEvents." e LEFT JOIN ".self::$tblSettings." s ON e.calId = s.id AND s.uuid = :uuid WHERE e.id = :id";
                    $s = self::$dbh->prepare($q);
                    if(!$s->execute(['id' => $id, 'uuid' => $uuid])){ return ['status' => false, 'msg' => 'I cannot select the data for this event']; }
                    $rs = $s->fetchAll();

                    if( $s->rowCount() > 0 ){

                        if($rs[0]['recurring'] !== ""){
                            
                            $newExdate = (strlen($rs[0]['dtstart']) == 8) ? $eventDate : $eventDate . substr($rs[0]['dtstart'], 8);

                            # Get the actual exdate
                            if(trim($rs[0]['exdate']) != ""){
                                $a = explode(",", trim($rs[0]['exdate']));
                                if(count($a) >= 15){ return ['status' => false, 'msg' => 'Reached the maximum number of events that can be eliminated (15)']; }
                            }else{
                                $a = [];
                            }

                            array_push($a, $newExdate); $exdate = implode(",", $a);

                            $q1 = "UPDATE ".self::$tblEvents." e INNER JOIN ".self::$tblSettings." s ON e.calId = s.id AND s.uuid = :uuid SET e.exdate=:exdate WHERE e.id = :id";
                            $s1 = self::$dbh->prepare($q1);
                            return ($s1->execute([':uuid' => $uuid, ':exdate' => $exdate, ':id' => $id])) ? ['status' => true, 'msg' => 'ok'] : ['status' => false, 'msg' => 'Error updating exdate field of this event'];

                        }else{
                            return ['status' => false, 'msg' => 'Event ID not found'];
                        }
                        
                    }else{
                       return ['status' => false, 'msg' => 'Event ID not found'];
                    }


                } catch (\Exception $exc) {

                    return ['status' => false, 'msg' => $exc->getMessage() ];

                }
                
            }
            

        }else{
            return ['status' => false, 'msg' => 'Read only content cannot be changed']; // No event selected
        }

    }    
    
    public function addEvent($arr) {

        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }
        
        $this->i18n = self::loadI18n($arr['lang']);
        
        if(is_array($arr)) {

            require dirname(__FILE__) . '/../class/momentPHP.php';

            $m1 = new \MomentPHP\MomentPHP( $arr['start'] );
            $m2 = new \MomentPHP\MomentPHP( $arr['end'] );
            $dtStart = ""; $duration = "";
            
            if($arr['recurring'] === $this->i18n['newEvent']['body']['does_not_repeat']){

                $recurrence = NULL;
                $rrule = "";

            } else {

                $dtStart        = ($arr['dateType'] === 'allday') ? $m1->format('Ymd') : $m1->format('Ymd\THis\Z');
                $duration       = ($arr['dateType'] === 'allday') ? NULL : self::getDuration($m1->format('Y-m-d H:i'), $m2->format('Y-m-d H:i'));

                switch ( $arr['recurring'] ) {
                    
                    case $this->i18n['newEvent']['body']['daily_recurring']:

                        $recurrence     = "daily";

                        if($arr['newEndRecurring'] === $this->i18n['newEvent']['body']['date'] ){

                            $mEnd = new \MomentPHP\MomentPHP( $arr['endDateRecurring'] );
                            $rrule = "FREQ=DAILY;INTERVAL=".$arr['eachNumberDays'].";UNTIL=".$mEnd->format('Ymd\THis\Z');

                        }else if($arr['newEndRecurring'] === $this->i18n['newEvent']['body']['after'] ){

                            $rrule = "FREQ=DAILY;INTERVAL=".$arr['eachNumberDays'].";COUNT=".$arr['endOccurrences'];
                            $p = new \MomentPHP\MomentPHP(   $m1->format('Y-m-d ') . $m2->format('H:i:s')  );
                            $p->add(($arr['eachNumberDays'] * $arr['endOccurrences']), 'days'); $m2 = $p;

                        }else{

                            $rrule = "FREQ=DAILY;INTERVAL=".$arr['eachNumberDays'];

                        }

                        break;

                    case $this->i18n['newEvent']['body']['weekly_recurring']:

                        $recurrence     = "weekly";
                        $daysOfWeeks    = isset($arr['dateType2']) ? str_replace([0,1,2,3,4,5,6], ['SU','MO','TU','WE','TH','FR','SA'], implode(",",$arr['dateType2'])) : NULL;


                        if($arr['newEndRecurring'] === $this->i18n['newEvent']['body']['date'] ){

                            $mEnd = new \MomentPHP\MomentPHP( $arr['endDateRecurring'] );
                            $rrule = "FREQ=WEEKLY;BYDAY=".$daysOfWeeks.";INTERVAL=".$arr['eachNumberWeeks'].";UNTIL=".$mEnd->format('Ymd\THis\Z');

                        }else if($arr['newEndRecurring'] === $this->i18n['newEvent']['body']['after'] ){

                            $rrule = "FREQ=WEEKLY;BYDAY=".$daysOfWeeks.";INTERVAL=".$arr['eachNumberWeeks'].";COUNT=".$arr['endOccurrences'];
                            $p = new \MomentPHP\MomentPHP(   $m1->format('Y-m-d ') . $m2->format('H:i:s')  );
                            $p->add(($arr['eachNumberDays'] * $arr['endOccurrences'] * 7), 'days'); $m2 = $p;

                        }else{

                            $rrule = "FREQ=WEEKLY;BYDAY=".$daysOfWeeks.";INTERVAL=".$arr['eachNumberWeeks'];

                        }

                        break;

                    case $this->i18n['newEvent']['body']['monthly_recurring']:

                        $recurrence     = "monthly";

                        if(strpos($arr['newMonthTimeRecurring'], $this->i18n['core']['every_month_on_day']) !== false){
                            
                            $byMonthDay = intval( str_replace($this->i18n['core']['every_month_on_day']." ", "", $arr['newMonthTimeRecurring']) );
                            $rrule = "FREQ=MONTHLY;BYMONTHDAY=".$byMonthDay.";INTERVAL=".$arr['eachNumberMonths'];
                            
                        }else{

                            $a = explode(" ", str_replace($this->i18n['core']['monthly_on_the']." ", "", $arr['newMonthTimeRecurring']));
                            $bySetpos = str_ireplace( $this->i18n['core']['week_of_month'], [1,2,3,4,-1], $a[0]);
                            if($bySetpos === ""){ return ['status' => false, 'msg' => 'Error mapping value : '.$a[0]]; }
                            $dayConv = str_ireplace( $this->i18n['core']['days'], ['SU','MO','TU','WE','TH','FR','SA'], $a[1]);
                            if($dayConv === ""){ return ['status' => false, 'msg' => 'Error mapping day of week value : '.$a[1]]; }
                            $byMonthDay = $bySetpos.strtoupper(substr($dayConv,0,2));
                            $rrule = "FREQ=MONTHLY;BYDAY=".$byMonthDay.";INTERVAL=".$arr['eachNumberMonths'];
                            
                        }


                        if($arr['newEndRecurring'] === $this->i18n['newEvent']['body']['date'] ){

                            $mEnd = new \MomentPHP\MomentPHP( $arr['endDateRecurring'] );
                            $rrule .= ";UNTIL=".$mEnd->format('Ymd\THis\Z');

                        }else if($arr['newEndRecurring'] === $this->i18n['newEvent']['body']['after']){

                            $rrule .= ";COUNT=".$arr['endOccurrences'];
                            $p = new \MomentPHP\MomentPHP(   $m1->format('Y-m-d ') . $m2->format('H:i:s')  );
                            $p->add(($arr['eachNumberMonths'] * $arr['endOccurrences']), 'months'); $m2 = $p;

                        }else{}

                        break;

                    case $this->i18n['newEvent']['body']['yearly_recurring']:

                        $recurrence     = "yearly";

                        if( strpos($arr['newYearTimeRecurring'], $this->i18n['core']['yearly_on'] ) !== false){

                            $e = explode(" ", trim(str_replace($this->i18n['core']['yearly_on']." ", "", $arr['newYearTimeRecurring'])));
                            $byMonthDay = intval($e[0]);
                            $bySetpos = str_ireplace($this->i18n['core']['months'], [1,2,3,4,5,6,7,8,9,10,11,12], $e[1]);
                            if($bySetpos === ""){ return ['status' => false, 'msg' => 'Error mapping month value : '.$e[1]]; }
                            $rrule = "FREQ=YEARLY;BYMONTHDAY=".$byMonthDay.";BYMONTH=".$bySetpos;

                        }else{

                            $e = explode(" ", trim(str_replace([$this->i18n['core']['every']." ", $this->i18n['core']['of']." "], ["", ""], $arr['newYearTimeRecurring'])));
                            $bySetpos = str_ireplace( $this->i18n['core']['week_of_month'], [1,2,3,4,-1], $e[0]);
                            if($bySetpos === ""){ return ['status' => false, 'msg' => 'Error mapping week value : '.$e[0]]; }             
                            $dayConv = str_ireplace( $this->i18n['core']['days'], ['SU','MO','TU','WE','TH','FR','SA'], $e[1]);
                            $byDay = strtoupper(substr($dayConv,0,2));
                            $byMonth = str_ireplace( $this->i18n['core']['months'], [1,2,3,4,5,6,7,8,9,10,11,12], $e[2]);
                            if($byMonth === ""){ return ['status' => false, 'msg' => 'Error mapping month value : '.$e[2]]; }
                            $rrule = "FREQ=YEARLY;BYDAY=".$byDay.";BYSETPOS=".$bySetpos.";BYMONTH=".$byMonth;

                        }

                        if( $arr['newEndRecurring'] === $this->i18n['newEvent']['body']['date'] ){

                            $mEnd = new \MomentPHP\MomentPHP( $arr['endDateRecurring'] );
                            $rrule .= ";UNTIL=".$mEnd->format('Ymd\THis\Z');

                        }else if($arr['newEndRecurring'] === $this->i18n['newEvent']['body']['after'] ){

                            $rrule .= ";COUNT=".$arr['endOccurrences'];
                            $p = new \MomentPHP\MomentPHP(   $m1->format('Y-m-d ') . $m2->format('H:i:s')  );
                            $p->add(intval($arr['endOccurrences']), 'years'); $m2 = $p;

                        }else{}            

                        break;

                    default: return ['status' => false, 'msg' => 'Unexpected error has occurred'];

                }

            }

            
            $q = "INSERT INTO ".self::$tblEvents." (calId, groupId, title, description, recurring, category, custom, dtstart, duration, rrule, start_event, end_event, url, color, text_color, lastModify, allday) VALUES((SELECT id FROM ".self::$tblSettings." WHERE uuid = :uuid),:groupId, :title, :description, :recurring, :category, :custom, :dtstart, :duration, :rrule, :start_event, :end_event, :url, :color, :text_color, :lastModify, :allday)";
            $s = self::$dbh->prepare($q);
            $s->execute(
                [
                    ':uuid'         => $arr['uuid'],
                    ':groupId'      => self::RandomToken(16),
                    ':title'        => $arr['title'],
                    ':description'  => $arr['description'],
                    ':recurring'    => $recurrence,
                    ':category'     => ($arr['category'] !== "Select category") ? $arr['category'] : NULL,
                    ':custom'       => ($arr['customFields'] !== "") ? json_encode($arr['customFields']) : NULL,
                    ':dtstart'      => ($dtStart !== '') ? $dtStart : NULL,
                    ':duration'     => ($duration !== '') ? $duration : NULL,
                    ':rrule'        => $rrule ? $rrule : NULL,
                    ':start_event'  => $m1->format('Y-m-d\TH:i:s'),
                    ':end_event'    => $m2->format('Y-m-d\TH:i:s'),
                    ':url'          => $arr['url'] ? $arr['url'] : NULL,
                    ':color'        => $arr['colorBg'],
                    ':text_color'   => $arr['colorText'],
                    ':lastModify'   => time(),
                    ':allday'       => ($arr['dateType'] === 'allday') ? true : false
                ]
            );
            
            return ['status' => true, 'msg' => 'ok'];
            

        }else{
            return ['status' => false, 'msg' => 'Argument must be an array'];
        }

    }    


    public function updateEvent($arr, $uuid = null) {

        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }        

        if(is_array($arr)) {

            require dirname(__FILE__) . '/../class/momentPHP.php';

            switch ( $arr['eventType'] ) {

                case "resize":

                    $id         = $arr['idEvent'];
                    $start      = $arr['start'];
                    $end        = $arr['end'];
                    $endDelta   = $arr['endDelta'];

                    $m1 = new \MomentPHP\MomentPHP($start);
                    $m2 = new \MomentPHP\MomentPHP($end);


                    if( $id > 0 ){


                        $q = "SELECT e.* FROM ".self::$tblSettings." s LEFT JOIN ".self::$tblEvents." e ON e.calId = s.id AND e.id = ".$id." WHERE s.uuid = '".$uuid."'";
                        $s = self::$dbh->prepare($q);
                        $s->execute(['id' => $id, 'uuid' => $uuid]);
                        $rs = $s->fetchAll(\PDO::FETCH_ASSOC);


                        if( $s->rowCount() > 0 ){

                            if(in_array($rs[0]['recurring'], ['daily', 'weekly', 'monthly', 'yearly'])){     // rrule event

                                return ['status' => false, 'msg' => 'Action not available for rrule event. Please edit this event from GUI'];

                            }else {

                                $q = "UPDATE ".self::$tblEvents." e INNER JOIN ".self::$tblSettings." s ON e.calId = s.id AND s.uuid = :uuid SET e.start_event=:start_event, e.end_event=:end_event, e.lastModify=:lastModify WHERE e.id = :id";
                                $s = self::$dbh->prepare($q);
                                $s->execute(
                                    [
                                        ':uuid'         => $uuid,
                                        ':start_event'  => $m1->format('Y-m-d\TH:i:s'),
                                        ':end_event'    => $m2->format('Y-m-d\TH:i:s'),
                                        ':lastModify'   => time(),
                                        ':id'           => $id
                                    ]
                                );

                                $debug = ['recurring' => 'none', 'start event' => $m1->format('Y-m-d\TH:i:s'), 'end event' => $m2->format('Y-m-d\TH:i:s')];
                                return ['status' => true, 'msg' => 'ok', 'debug' => $debug];

                            }

                        }else{
                            
                            return ['status' => false, 'msg' => 'Event ID not found : '.$q];
                            
                        }       

                    }else{
                        
                        return ['status' => false, 'msg' => 'event not defined'];
                        
                    }

                    break;

                case "drop":

                    $id             = $arr['idEvent'];
                    $delta          = $arr['delta'];
                    $newAllDay      = ($arr['newAllDay'] == "1") ? 1 : 0;
                    $newStart       = $arr['newStart'];
                    $newEnd         = $arr['newEnd'];
                    $oldAllDay      = ($arr['oldAllDay'] == "1") ? 1 : 0;
                    $oldStart       = $arr['oldStart'];
                    $oldEnd         = $arr['oldEnd'];

                    $q = "SELECT * FROM ".self::$tblEvents." WHERE id = :id";
                    $s = self::$dbh->prepare($q);
                    $s->execute(['id' => $id]);
                    $rs = $s->fetchAll(\PDO::FETCH_ASSOC);

                    if( $s->rowCount() > 0){

                        if( in_array($rs[0]['recurring'], ['daily', 'weekly', 'monthly', 'yearly']) ){
                            
                            # rrule event
                            return ['status' => false, 'msg' => 'Action not available for rrule event. Please edit this event from GUI'];

                        }else{

                            $m1 = new \MomentPHP\MomentPHP($newStart);
                            $m2 = new \MomentPHP\MomentPHP($newEnd);
                            $o1 = new \MomentPHP\MomentPHP($oldStart);
                            $o2 = new \MomentPHP\MomentPHP($oldEnd);
                            
                            # if true old and new update only start/end event
                            $q = "UPDATE ".self::$tblEvents." e INNER JOIN ".self::$tblSettings." s ON e.calId = s.id AND s.uuid = :uuid SET e.start_event=:start_event, e.end_event=:end_event, e.allday=:allday, e.lastModify=:lastModify WHERE e.id = :id";
                            $s = self::$dbh->prepare($q);
                            $s->execute(
                                [
                                    ':uuid'         => $uuid,
                                    ':start_event'  => $m1->format('Y-m-d\TH:i:s'),
                                    ':end_event'    => (($oldAllDay == 1) && ($newAllDay == 0)) ? $m2->add(30, 'min')->format('Y-m-d\TH:i:s') : $m2->format('Y-m-d\TH:i:s'),
                                    ':allday'       => $newAllDay,    
                                    ':lastModify'   => time(),
                                    ':id'           => $id
                                ]
                            );

                            
                            return ['status' => true, 'msg' => 'ok'];

                        }

                    }else{
                        
                        return ['status' => false, 'msg' => 'Event ID not found'];
                        
                    }

                    break;
                
                case "update":
                    
                    /* update from GUI */
                    $this->i18n = self::loadI18n($arr['editLang']);
                    
                    
                    $m1 = new \MomentPHP\MomentPHP( $arr['start'] );
                    $m2 = new \MomentPHP\MomentPHP( $arr['end'] );
                    $dtStart = ""; $duration = "";                     
                    
                    if($arr['recurring'] === $this->i18n['editEvent']['body']['does_not_repeat']){

                        $recurrence = NULL;
                        $rrule = "";

                    } else {

                        $dtStart        = ($arr['dateType'] === 'allday') ? $m1->format('Ymd') : $m1->format('Ymd\THis\Z');
                        $duration       = ($arr['dateType'] === 'allday') ? NULL : self::getDuration($m1->format('Y-m-d H:i'), $m2->format('Y-m-d H:i'));

                        switch ( $arr['recurring'] ) {
                            
                            case $this->i18n['editEvent']['body']['daily_recurring']:

                                $recurrence     = "daily";

                                if( $arr['editEndRecurring'] === $this->i18n['editEvent']['body']['date'] ){

                                    $mEnd = new \MomentPHP\MomentPHP( $arr['endDateRecurring'] );
                                    $rrule = "FREQ=DAILY;INTERVAL=".$arr['eachNumberDays'].";UNTIL=".$mEnd->format('Ymd\THis\Z');

                                }else if( $arr['editEndRecurring'] === $this->i18n['editEvent']['body']['after'] ){

                                    $rrule = "FREQ=DAILY;INTERVAL=".$arr['eachNumberDays'].";COUNT=".$arr['endOccurrences'];
                                    $p = new \MomentPHP\MomentPHP(   $m1->format('Y-m-d ') . $m2->format('H:i:s')  );
                                    $p->add(($arr['eachNumberDays'] * $arr['endOccurrences']), 'days'); $m2 = $p;

                                }else{

                                    $rrule = "FREQ=DAILY;INTERVAL=".$arr['eachNumberDays'];

                                }

                                break;

                            case $this->i18n['editEvent']['body']['weekly_recurring']:

                                $recurrence     = "weekly";
                                $daysOfWeeks    = isset($arr['dateType2']) ? str_replace([0,1,2,3,4,5,6], ['SU','MO','TU','WE','TH','FR','SA'], implode(",",$arr['dateType2'])) : NULL;

                                if( $arr['editEndRecurring'] === $this->i18n['editEvent']['body']['date'] ){

                                    $mEnd = new \MomentPHP\MomentPHP( $arr['endDateRecurring'] );
                                    $rrule = "FREQ=WEEKLY;BYDAY=".$daysOfWeeks.";INTERVAL=".$arr['eachNumberWeeks'].";UNTIL=".$mEnd->format('Ymd\THis\Z');

                                }else if( $arr['editEndRecurring'] === $this->i18n['editEvent']['body']['after'] ){

                                    $rrule = "FREQ=WEEKLY;BYDAY=".$daysOfWeeks.";INTERVAL=".$arr['eachNumberWeeks'].";COUNT=".$arr['endOccurrences'];
                                    $p = new \MomentPHP\MomentPHP(   $m1->format('Y-m-d ') . $m2->format('H:i:s')  );
                                    $p->add(($arr['eachNumberDays'] * $arr['endOccurrences'] * 7), 'days'); $m2 = $p;

                                }else{

                                    $rrule = "FREQ=WEEKLY;BYDAY=".$daysOfWeeks.";INTERVAL=".$arr['eachNumberWeeks'];

                                }

                                break;

                            case $this->i18n['editEvent']['body']['monthly_recurring']:

                                $recurrence     = "monthly";

                                if(strpos($arr['editMonthTimeRecurring'], $this->i18n['core']['every_month_on_day']) !== false){

                                    $byMonthDay = intval( str_replace($this->i18n['core']['every_month_on_day']." ", "", $arr['editMonthTimeRecurring']) );
                                    $rrule = "FREQ=MONTHLY;BYMONTHDAY=".$byMonthDay.";INTERVAL=".$arr['eachNumberMonths'];
                                    
                                }else{
                                    
                                    $a = explode(" ", str_replace($this->i18n['core']['monthly_on_the']." ", "", $arr['editMonthTimeRecurring']));
                                    $bySetpos = str_ireplace( $this->i18n['core']['week_of_month'], [1,2,3,4,-1], $a[0]);
                                    if($bySetpos === ""){ return ['status' => false, 'msg' => 'Error mapping value : '.$a[0]]; }
                                    $dayConv = str_ireplace( $this->i18n['core']['days'], ['SU','MO','TU','WE','TH','FR','SA'], $a[1]);
                                    if($dayConv === ""){ return ['status' => false, 'msg' => 'Error mapping day of week value : '.$a[1]]; }
                                    $byMonthDay = $bySetpos.strtoupper(substr($dayConv,0,2));
                                    $rrule = "FREQ=MONTHLY;BYDAY=".$byMonthDay.";INTERVAL=".$arr['eachNumberMonths'];

                                }

                                if( $arr['editEndRecurring'] === $this->i18n['editEvent']['body']['date'] ){

                                    $mEnd = new \MomentPHP\MomentPHP( $arr['endDateRecurring'] );
                                    $rrule .= ";UNTIL=".$mEnd->format('Ymd\THis\Z');

                                }else if( $arr['editEndRecurring'] === $this->i18n['editEvent']['body']['after'] ){

                                    $rrule .= ";COUNT=".$arr['endOccurrences'];
                                    $p = new \MomentPHP\MomentPHP(   $m1->format('Y-m-d ') . $m2->format('H:i:s')  );
                                    $p->add(($arr['eachNumberMonths'] * $arr['endOccurrences']), 'months'); $m2 = $p;

                                }else{}

                                break;

                            case $this->i18n['editEvent']['body']['yearly_recurring']:

                                $recurrence     = "yearly";

                                if( strpos($arr['editYearTimeRecurring'], $this->i18n['core']['yearly_on'] ) !== false){
                                    
                                    $e = explode(" ", trim(str_replace($this->i18n['core']['yearly_on']." ", "", $arr['editYearTimeRecurring'])));
                                    $byMonthDay = intval($e[0]);
                                    $bySetpos = str_ireplace($this->i18n['core']['months'], [1,2,3,4,5,6,7,8,9,10,11,12], $e[1]);
                                    if($bySetpos === ""){ return ['status' => false, 'msg' => 'Error mapping month value : '.$e[1]]; }
                                    $rrule = "FREQ=YEARLY;BYMONTHDAY=".$byMonthDay.";BYMONTH=".$bySetpos;

                                }else{

                                    $e = explode(" ", trim(str_replace([$this->i18n['core']['every']." ", $this->i18n['core']['of']." "], ["", ""], $arr['editYearTimeRecurring'])));
                                    $bySetpos = str_ireplace( $this->i18n['core']['week_of_month'], [1,2,3,4,-1], $e[0]);
                                    if($bySetpos === ""){ return ['status' => false, 'msg' => 'Error mapping week value : '.$e[0]]; }             
                                    $dayConv = str_ireplace( $this->i18n['core']['days'], ['SU','MO','TU','WE','TH','FR','SA'], $e[1]);
                                    $byDay = strtoupper(substr($dayConv,0,2));
                                    $byMonth = str_ireplace( $this->i18n['core']['months'], [1,2,3,4,5,6,7,8,9,10,11,12], $e[2]);
                                    if($byMonth === ""){ return ['status' => false, 'msg' => 'Error mapping month value : '.$e[2]]; }
                                    $rrule = "FREQ=YEARLY;BYDAY=".$byDay.";BYSETPOS=".$bySetpos.";BYMONTH=".$byMonth;

                                }

                                if( $arr['editEndRecurring'] === $this->i18n['editEvent']['body']['date'] ){

                                    $mEnd = new \MomentPHP\MomentPHP( $arr['endDateRecurring'] );
                                    $rrule .= ";UNTIL=".$mEnd->format('Ymd\THis\Z');

                                }else if( $arr['editEndRecurring'] === $this->i18n['editEvent']['body']['after'] ){

                                    $rrule .= ";COUNT=".$arr['endOccurrences'];
                                    $p = new \MomentPHP\MomentPHP(   $m1->format('Y-m-d ') . $m2->format('H:i:s')  );
                                    $p->add(intval($arr['endOccurrences']), 'years'); $m2 = $p;

                                }else{}            

                                break;

                            default: return ['status' => false, 'msg' => 'Unexpected error has occurred'];

                        }

                    }

                    $q = "UPDATE ".self::$tblEvents." e INNER JOIN ".self::$tblSettings." s ON e.calId = s.id AND s.uuid = :uuid SET e.title=:title, e.description=:description, e.recurring=:recurring, e.category=:category, e.custom=:custom, e.dtstart=:dtstart, e.duration=:duration, e.rrule=:rrule, e.start_event=:start_event, e.end_event=:end_event, e.url=:url, e.color=:color, e.text_color=:text_color, e.allday=:allday, e.lastModify=:lastModify WHERE e.id = :id";
                    
                    $s = self::$dbh->prepare($q);
                    $sql =
                        [
                            ':uuid'         => $uuid,
                            ':title'        => $arr['title'],
                            ':description'  => $arr['description'],
                            ':recurring'    => $recurrence,
                            ':category'     => ($arr['category'] !== "Select category") ? $arr['category'] : NULL,
                            ':custom'       => ($arr['customFields'] !== "") ? json_encode($arr['customFields']) : NULL,
                            ':dtstart'      => ($dtStart !== '') ? $dtStart : NULL,
                            ':duration'     => ($duration !== '') ? $duration : NULL,
                            ':rrule'        => $rrule ? $rrule : NULL,
                            ':start_event'  => $m1->format('Y-m-d\TH:i:s'),
                            ':end_event'    => $m2->format('Y-m-d\TH:i:s'),
                            ':url'          => $arr['url'] ? $arr['url'] : NULL,
                            ':color'        => $arr['colorBg'],
                            ':text_color'   => $arr['colorText'],
                            ':allday'       => ($arr['dateType'] == 'allday') ? true : false,
                            ':lastModify'   => time(),
                            ':id'           => $arr['idEvent']
                        ];

                    return ($s->execute($sql)) ? ['status' => true, 'msg' => 'ok'] : ['status' => false, 'msg' => $s->errorInfo()];
                    
                
                default: return ['status' => false, 'msg' => 'Unhandled event'];

            }

        }else{
            return ['status' => false, 'msg' => 'Argument must be an array'];
        }

    }    
    
    
    public function loadEvents($arr) {

        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }
        
        try {
            
            $this->i18n = self::loadI18n($arr['lang']);
            
            // Short-circuit if the client did not give us a date range.
            if (!isset($arr['start']) || !isset($arr['end'])) { return ['status' => false, 'msg' => 'Invalid date range']; }

            // Parse the start/end parameters.
            // These are assumed to be ISO8601 strings with no time nor timeZone, like "2013-12-29".
            // Since no timeZone will be present, they will parsed as UTC.
            $start    = parseDateTime( $arr['start'] );
            $end      = parseDateTime( $arr['end'] );

            // Parse the timeZone parameter if it is present.
            $tz = null;
            if (isset($arr['timeZone'])) {   $tz = new \DateTimeZone($arr['timeZone']); }
            
            require dirname(__FILE__) . '/../class/momentPHP.php';

            if((trim($arr['category']) == "") || (trim($arr['category']) == "Select category")){
                $q = "SELECT e.* FROM ".self::$tblSettings." s INNER JOIN ".self::$tblEvents." e ON e.calId = s.id WHERE s.uuid = :uuid";
                $s = self::$dbh->prepare($q);
                $s->execute(['uuid' => $arr['uuid']]);
            }else{
                $q = "SELECT e.* FROM ".self::$tblSettings." s INNER JOIN ".self::$tblEvents." e ON e.calId = s.id AND e.category = :category WHERE s.uuid = :uuid";
                $s = self::$dbh->prepare($q);
                $s->execute(['category' => trim($arr['category']), 'uuid' => $arr['uuid']]);
            }
            $rs = $s->fetchAll(\PDO::FETCH_ASSOC);
            
            foreach ($rs as $row) {

                $arr = null;
                isset($row["id"])           ? $arr['id'] = $row["id"] : "";
                isset($row["groupId"])      ? $arr['groupId'] = $row["groupId"] : "";
                isset($row["title"])        ? $arr['title'] = $row["title"] : "";
                isset($row["description"])  ? $arr['description'] = $row["description"] : "";
                isset($row["category"])     ? $arr['category'] = $row["category"] : "";
                isset($row["url"])          ? $arr['url'] = $row["url"] : "";
                isset($row["color"])        ? $arr['color'] = $row["color"] : "";
                isset($row["text_color"])   ? $arr['textColor'] = $row["text_color"] : "";
                isset($row["start_event"])  ? $arr['start'] = $row["start_event"] : "";
                isset($row["end_event"])    ? $arr['end'] = $row["end_event"] : "";
                isset($row["allday"])       ? $arr['allDay'] = $row["allday"] : $row["allday"];


                if($row["recurring"] != ""){
                    ## rrule event
                    $arr['rrule'] = "DTSTART:".$row["dtstart"]."\n" . $row["rrule"];
                    if($row['exdate'] != ""){
                        $arr['rrule'] .= "\n". "EXDATE:".$row['exdate'];
                    }

                    isset($row["duration"])        ? $arr['duration'] = $row["duration"] : "";

                    // Adjust the display of events endless
                    if((strpos($row["rrule"], 'FREQ=DAILY') !== false) && ( strpos($row["rrule"], 'COUNT=') === false ) && ( strpos($row["rrule"], 'UNTIL=') === false )){
                        $m1 = new \MomentPHP\MomentPHP($row["start_event"]); $arr['end'] = $m1->add(100, 'years')->format('Ymd\THis\Z');
                    }
                    if((strpos($row["rrule"], 'FREQ=WEEKLY') !== false) && ( strpos($row["rrule"], 'COUNT=') === false ) && ( strpos($row["rrule"], 'UNTIL=') === false )){
                        $m1 = new \MomentPHP\MomentPHP($row["start_event"]); $arr['end'] = $m1->add(100, 'years')->format('Ymd\THis\Z');
                    }
                    if((strpos($row["rrule"], 'FREQ=MONTHLY') !== false) && ( strpos($row["rrule"], 'COUNT=') === false ) && ( strpos($row["rrule"], 'UNTIL=') === false )){
                        $m1 = new \MomentPHP\MomentPHP($row["start_event"]); $arr['end'] = $m1->add(100, 'years')->format('Ymd\THis\Z');
                    }
                    if((strpos($row["rrule"], 'FREQ=YEARLY') !== false) && ( strpos($row["rrule"], 'COUNT=') === false ) && ( strpos($row["rrule"], 'UNTIL=') === false )){
                        $m1 = new \MomentPHP\MomentPHP($row["start_event"]); $arr['end'] = $m1->add(100, 'years')->format('Ymd\THis\Z');
                    }

                }

                if(trim($row['custom']) != "") { $arr['extendedProps'] = json_decode($row['custom'], true); }
                $data[] = $arr;

            }

            $json = json_encode($data);
            $input_arrays = json_decode($json, true);

            // Read and parse our events JSON file into an array of event data arrays.
            // Accumulate an output array of event data arrays.
            $output_arrays = array();
            foreach ($input_arrays as $array) {

                // Convert the input array into a useful Event object
                $event = new Event($array, $tz);

                // If the event is in-bounds, add it to the output
                if ($event->isWithinDayRange($start, $end)) {
                  $output_arrays[] = $event->toArray();
                }
            }

            self::$dbh = null;
            // Send JSON to the client.
            return $output_arrays;

            
        } catch (\Exception $exc) {

            self::$dbh = null;
            return ['status' => false, 'msg' => $exc->getMessage() ];

        }
            
    }
    

    public function newCalendar($arr) {

        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }
        
        try {

            if(is_array($arr)) {

                $q = "INSERT INTO ".self::$tblSettings." (uuid, name, description, language, categories, customFields, textColor, bgColor, lastModify) VALUES(:uuid, :name, :description, :language, :categories, :custom, :textColor, :bgColor, :lastModify)";
                $s = self::$dbh->prepare($q);
                $s->execute(
                    [
                        ':uuid'         => self::generate_UUID(),
                        ':name'         => $arr['name'],
                        ':description'  => $arr['desc'],
                        ':language'     => $arr['lang'],
                        ':categories'   => $arr['cats'],
                        ':custom'       => $arr['cust'],
                        ':textColor'    => $arr['textColor'],
                        ':bgColor'      => $arr['bgColor'],
                        ':lastModify'   => time()
                    ]
                );
                
                $out = (self::$dbh->lastInsertId() > 0) ? ['status' => true, 'msg' => 'ok'] : ['status' => false, 'msg' => self::$dbh->errorInfo() ];
                self::$dbh = null;
                return $out;
                
            }else{
                
                self::$dbh = null;
                return ['status' => false, 'msg' => 'Input data not valid'];
                
            }


        } catch (\Exception $exc) {

            self::$dbh = null;
            return ['status' => false, 'msg' => $exc->getMessage() ];

        }
        
    }
    
    public function updateCalendar($arr) {

        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }
                
        try {
            
            if(is_array($arr)) {

                /* Update calendar settings */
                $q1 = "UPDATE ".self::$tblSettings." SET name = :name, description = :description, language = :language, categories = :categories, customFields = :custom, textColor = :textColor, bgColor = :bgColor, lastModify = :lastModify WHERE uuid = :uuid";
                $s1 = self::$dbh->prepare($q1);
                $out = ($s1->execute([':name' => $arr['name'], ':description' => $arr['desc'], ':language' => $arr['lang'], ':categories' => $arr['cats'], ':custom' => $arr['cust'], ':textColor' => $arr['textColor'], ':bgColor' => $arr['bgColor'], ':lastModify' => time(), ':uuid' => $arr['uuid']])) ? ['status' => true, 'msg' => 'ok'] : ['status' => false, 'msg' => 'Error updating this calendar : '.$s1->errorInfo()];
                
                if($out['status'] === false){
                    self::$dbh = null;
                    return $out;
                }
                
                /* Update category field */
                $q2 = "UPDATE ".self::$tblEvents." e INNER JOIN ".self::$tblSettings." s ON e.calId = s.id AND s.uuid = :uuid SET e.category = :cats WHERE e.category IN(:oldcats)";
                $s2 = self::$dbh->prepare($q2);
                $out2 = ($s2->execute([':uuid' => $arr['uuid'], 'cats' => null, ':oldcats' => $arr['diff']])) ? ['status' => true, 'msg' => 'ok update'] : ['status' => false, 'msg' => $s2->errorInfo()];
                
                self::$dbh = null;
                return $out2;
                
            }else{
                
                self::$dbh = null;
                return ['status' => false, 'msg' => 'Input data not valid'];
                
            }


        } catch (\Exception $exc) {

            self::$dbh = null;
            return ['status' => false, 'msg' => $exc->getMessage() ];

        }
        
    }    

    public function deleteCalendar($id) {
        
        if($id > 0) {

            try {
                
                $init = self::init();
                if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }                

                $q = "DELETE FROM ".self::$tblSettings." WHERE id = :id";
                $s = self::$dbh->prepare($q);
                $out = ($s->execute(['id' => $id])) ? ['status' => true, 'msg' => 'The calendar was successfully deleted'] : ['status' => false, 'msg' => 'Error: the selected calendar was not deleted'];
                self::$dbh = null;
                return $out;                

            } catch (\Exception $exc) {
                
                self::$dbh = null;
                return ['status' => false, 'msg' => $exc->getMessage() ];

            }

        }else{

            return ['status' => false, 'msg' => 'Input data not valid'];

        }

    }
    
    public function loginUser($cred) {
        
        if ($cred['user'] !== "" && $cred['pass'] !== "") {
            $check = $this::checkUser($cred);
            return ($check['status']) ? $check : ['status' => false, 'msg' => $check['msg']];
        } else {
            return ['status' => false, 'msg' => 'Username and/or password not valid'];
        }
    }
    
    public function changePwd($cred) {
        if ($cred['id'] !== "" && $cred['pass'] !== "" && $cred['action'] !== "") {
            $check = $this::checkUser($cred);
            return ($check['status']) ? $check : ['status' => false, 'msg' => $check['msg']];
        } else {
            return ['status' => false, 'msg' => 'Invalid parameter'];
        }
    }    
    
    
    private static function checkUser($cred) {

        $init = self::init();
        if( $init['status'] === false ) { return ["status" => false, "msg" => $init['msg'] ]; }        

        switch ($cred['action']) {
            case "new": break;
            case "lost": break;
            case "change": 

                /* Update user credential */
                $q1 = "UPDATE ".self::$tblUsers." SET password = :password, lastModify = :change WHERE id = :userId";
                $s1 = self::$dbh->prepare($q1);
                $out = ($s1->execute([':password' => md5($cred['pass']), ':change' => time(), ':userId' => $cred['id']])) ? ['status' => true, 'msg' => 'ok'] : ['status' => false, 'msg' => 'Error updating user\'s password : '.$s1->errorInfo()];
                
                self::$dbh = null;
                return $out;

            case "active": break;
            case "resend": break;
            case "validate": break;
            default:

                $q = "SELECT * FROM ".self::$tblUsers." WHERE username = :user AND password = :pass";
                $s = self::$dbh->prepare($q);
                $s->execute(['user' => $cred['user'], 'pass' => md5($cred['pass'])]);
                $rs = $s->fetchAll(\PDO::FETCH_ASSOC);
                
                if (count($rs) > 0) {
                    
                    $dataLogin = time();
                    $s = self::$dbh->prepare("UPDATE ".self::$tblUsers." SET lastLogin = :lastLogin WHERE id = :id");
                    $s->execute(['lastLogin' => $dataLogin, 'id' => $rs[0]['id']]);
                    
                    unset($_SESSION['user']);
                    $_SESSION['user']['id']                 = $rs[0]['id'];
                    $_SESSION['user']['username']           = $rs[0]['username'];
                    $_SESSION['user']['homepage_be']        = _DIR_BE;
                    self::$dbh = null;
                    return ['status' => true, 'url' => _DIR_BE];

                }else{
                    self::$dbh = null;
                    return ['status' => false, 'msg' => 'Invalid user'];
                }

        }

    }    

    public function accessPage() {
        if(!isset($_SESSION['user'])) {
            header("Location: ".LOGIN_PAGE);
        }
    }

    public function logout() {
        unset($_SESSION['user']);
    }
    
    
}


class Event {

    // Tests whether the given ISO8601 string has a time-of-day or not
    const ALL_DAY_REGEX = '/^\d{4}-\d\d-\d\d$/'; // matches strings like "2013-12-29"

    public $title;
    public $allDay; // a boolean
    public $start; // a DateTime
    public $end; // a DateTime, or null
    public $properties = array(); // an array of other misc properties


    // Constructs an Event object from the given array of key=>values.
    // You can optionally force the timeZone of the parsed dates.
    public function __construct($array, $timeZone = null) {

        $this->title = $array['title'];

        if (isset($array['allDay'])) {
            // allDay has been explicitly specified
            $this->allDay = (bool)$array['allDay'];
        }
        else {
            // Guess allDay based off of ISO8601 date strings
            $this->allDay = preg_match(self::ALL_DAY_REGEX, $array['start']) &&
              (!isset($array['end']) || preg_match(self::ALL_DAY_REGEX, $array['end']));
        }

        if ($this->allDay) {
            // If dates are allDay, we want to parse them in UTC to avoid DST issues.
            $timeZone = null;
        }

        // Parse dates
        $this->start = parseDateTime($array['start'], $timeZone);
        $this->end = isset($array['end']) ? parseDateTime($array['end'], $timeZone) : null;

        // Record misc properties
        foreach ($array as $name => $value) {
            if (!in_array($name, array('title', 'allDay', 'start', 'end'))) {
                $this->properties[$name] = $value;
            }
        }
    }


    // Returns whether the date range of our event intersects with the given all-day range.
    // $rangeStart and $rangeEnd are assumed to be dates in UTC with 00:00:00 time.
    public function isWithinDayRange($rangeStart, $rangeEnd) {

        // Normalize our event's dates for comparison with the all-day range.
        $eventStart = stripTime($this->start);

        if (isset($this->end)) {
            $eventEnd = stripTime($this->end); // normalize
        }
        else {
            $eventEnd = $eventStart; // consider this a zero-duration event
        }

        // Check if the two whole-day ranges intersect.
        return $eventStart < $rangeEnd && $eventEnd >= $rangeStart;
    }


    // Converts this Event object back to a plain data array, to be used for generating JSON
    public function toArray() {

        // Start with the misc properties (don't worry, PHP won't affect the original array)
        $array = $this->properties;

        $array['title'] = $this->title;

        // Figure out the date format. This essentially encodes allDay into the date string.
        if ($this->allDay) {
            $format = 'Y-m-d'; // output like "2013-12-29"
        }
        else {
            $format = 'c'; // full ISO8601 output, like "2013-12-29T09:00:00+08:00"
        }

        // Serialize dates into strings
        $array['start'] = $this->start->format($format);
        if (isset($this->end)) {
            $array['end'] = $this->end->format($format);
        }

        return $array;
    }

}


// Parses a string into a DateTime object, optionally forced into the given timeZone.
function parseDateTime($string, $timeZone = null) {
    $date = new \DateTime(
        $string,
        $timeZone ? $timeZone : new \DateTimeZone('UTC')
        // Used only when the string is ambiguous.
        // Ignored if string has a timeZone offset in it.
    );
    if ($timeZone) {
        // If our timeZone was ignored above, force it.
        $date->setTimezone($timeZone);
    }
    return $date;
}


// Takes the year/month/date values of the given DateTime and converts them to a new DateTime,
// but in UTC.
function stripTime($datetime) {
    return new \DateTime($datetime->format('Y-m-d'));
}