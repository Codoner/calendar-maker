<?php
if(!isset($_SESSION)){ session_start(); }


$_SESSION['hostname']   = filter_input(INPUT_POST, "txtHostname", FILTER_SANITIZE_STRING);
$_SESSION['port']       = filter_input(INPUT_POST, "txtPort", FILTER_SANITIZE_NUMBER_INT);
$_SESSION['database']   = filter_input(INPUT_POST, "txtDatabase", FILTER_SANITIZE_STRING);
$_SESSION['prefix']     = "tm_" . filter_input(INPUT_POST, "txtPrefix", FILTER_SANITIZE_STRING);
$_SESSION['username']   = filter_input(INPUT_POST, "txtUsername", FILTER_SANITIZE_STRING);
$_SESSION['password']   = filter_input(INPUT_POST, "txtPassword", FILTER_SANITIZE_STRING);


$out = [];
$out["status"]      = false;
$out["msg"]         = "script error";

try {
    
    $dsn = 'mysql:host=' . $_SESSION['hostname'] . ';port=' . $_SESSION['port'];
    $dbh = new pdo($dsn, $_SESSION['username'], $_SESSION['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    try{

        $sqlTemp = file_get_contents('calendarDB.sql');
        $sql = str_replace(['[DB]', '[PREFIX]'], [trim($_SESSION['database']), $_SESSION['prefix']], $sqlTemp);
        $qr = $dbh->exec($sql);

        $out["status"]      = true;
        $out["msg"]         = "ok";

    } catch (\PDOException $e) {

        $out["status"]      = false;
        $out["msg"]         = $e->getMessage();

    }    
    
} catch (\PDOException $e) {

    $out["status"]      = false;
    $out["msg"]         = 'Database connection error : '.$e->getMessage();

}

echo json_encode($out);