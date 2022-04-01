<?php

try {
    
    $out = [];
    $out["status"]          = true;
    $out['checkPHP']        = (version_compare(PHP_VERSION, '5.6.0') >= 0) ? true : false;
    $out['checkSERVER']     = $_SERVER['PHP_SELF'] ? true : false;
    $out['checkPDO']        = extension_loaded('pdo') ? true : false;
    $out['checkPDOmysql']   = (in_array("mysql",PDO::getAvailableDrivers(),TRUE)) ? true : false;
    
} catch (Exception $exc) {
    
    $out = [];
    $out["status"]          = false;
    $out["msg"]             = $exc->getTraceAsString();
    
}

echo json_encode($out);