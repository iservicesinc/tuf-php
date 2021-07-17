<?php
/*
 *  ___    ____                  _               
 * |_ _|  / ___|  ___ _ ____   _(_) ___ ___  ___ 
 *  | |   \___ \ / _ \ '__\ \ / / |/ __/ _ \/ __|
 *  | |    ___) |  __/ |   \ V /| | (_|  __/\__ \
 * |___|  |____/ \___|_|    \_/ |_|\___\___||___/
 *             ...when IT matters!				
 *                                                 
 * https://iservicesinc.com https://iservicesinc.net
 * Copyright 2021 I Services, Inc. All rights reserved.
*/
if (file_exists(BASE_DIR.'/vendor/autoload.php')) {
    require_once(BASE_DIR.'/vendor/autoload.php');
}
use \Iservicesinc\TufPhp\Utils;

if (!file_exists(BASE_DIR . '/.env.ini')) { 
    copy(BASE_DIR . '/.env.example.ini', BASE_DIR . '/.env.ini') or die('Failed to auto-generate .env.ini file, please copy the .env.example.ini file to .env.ini manually.');
}

$ini = parse_ini_file(BASE_DIR . '/.env.ini', true);
$_SESSION['TUF'] = array();

foreach ($ini as $k => $v) {
    if (is_array($v)) {
        $a = $k;
        foreach ($v as $k => $v) {
            $_SESSION['TUF'][$a][$k] = $v;
        }
    } else {
        $_SESSION['TUF'][$k] = $v;
    }
}

if (!isset($_SESSION['TUF']['env']['environment'])) $_SESSION['TUF']['env']['environment'] = !isset($ini['env']['environment']) ? 'development' : $ini['env']['environment'];
if (!isset($_SESSION['TUF']['env']['salt'])) $_SESSION['TUF']['env']['salt'] = !isset($ini['env']['salt']) ? Utils::random_str(64, true) : $ini['env']['salt'];
if (!isset($_SESSION['TUF']['env']['maintenance_mode'])) $_SESSION['TUF']['env']['maintenance_mode'] = ($ini['env']['maintenance_mode'] == 'true') ? true : false;

use \Iservicesinc\TufPhp\Router;

$url = parse_url($_SERVER['REQUEST_URI']);
$path = $url['path'];
$router = new Router();
$router->maintenance();
if (!isset($_SESSION['salt'])) {
    $_SESSION['salt'] = hash('sha256', $_SERVER['REMOTE_ADDR'] . time() . $_SESSION['TUF']['env']['salt'], 0);
    setcookie('salt', $_SESSION['salt'], time() + 60*60, '/', $_SERVER['SERVER_NAME'], 0, 1);
}

require_once BASE_DIR.'/app/routes.php';
?>
