<?php

require realpath(dirname(__FILE__)) . '/../assets/vendors/calendarmaker/class/calendarMaker.php';
if(!isset($_SESSION)){ session_start(); }

$adminUser      = filter_input(INPUT_POST, "txtAdminUser", FILTER_SANITIZE_STRING);
$adminPass      = filter_input(INPUT_POST, "txtAdminPass", FILTER_SANITIZE_STRING);
$userTable      = $_SESSION['prefix'] . "users";

$out = [];
$out["status"]      = false;
$out["msg"]         = "script error";

try {

    $dsn = 'mysql:host=' . $_SESSION['hostname'] . ';port=' . $_SESSION['port'] .';dbname=' . $_SESSION['database'];
    $dbh = new pdo($dsn, $_SESSION['username'], $_SESSION['password'], array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

    $sql = "INSERT INTO ".$userTable." (username, password, lastLogin, lastModify) VALUES(:username, :password, :lastLogin, :loastModify)";
    $s = $dbh->prepare($sql); 
    $s->execute(
        [
            ':username'     => $adminUser,
            ':password'     => md5($adminPass),
            ':lastLogin'    => NULL,
            ':loastModify'  => NULL
        ]
    );
    
    if($dbh->lastInsertId() > 0) {
        $out['status'] = true;
        $out['msg'] = 'ok';
        
        // create config file
        $configFile = [
            'application_path' => parse_url(APPLICATION_PATH)['path'],
            'db' => [
                'hostname' => $_SESSION['hostname'], 
                'port' => $_SESSION['port'], 
                'dbname' => $_SESSION['database'],
                'table_users' => $_SESSION['prefix']."users",
                'table_settings' => $_SESSION['prefix'].'settings',
                'table_events' => $_SESSION['prefix'].'events',
                'user' => $_SESSION['username'], 
                'pass' => $_SESSION['password']
            ]
        ];
        file_put_contents( __ROOT__ . DIRECTORY_SEPARATOR . 'class' . DIRECTORY_SEPARATOR . 'config.php', '<?php return ' . var_export($configFile, true) . ';');
        
    }else{
        $out['status'] = false;
        $out['msg'] = $dbh->errorInfo();
    }
    
    
} catch (\PDOException $e) {

    $out["status"]      = false;
    $out["msg"]         = 'Database connection error : '.$e->getMessage();

}

echo json_encode($out);