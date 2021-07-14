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
require_once BASE_DIR.'/app/lib/random_str.php';

if (!file_exists(BASE_DIR . '/.env.ini')) { 
    copy(BASE_DIR . '/.env.example.ini', BASE_DIR . '/.env.ini') or die('Failed to auto-generate .env.ini file, please copy the .env.example.ini file to .env.ini manually.');
}

$ini = parse_ini_file(BASE_DIR . '/.env.ini', true);
if (!isset($_SERVER['environment'])) $_SERVER['environment'] = !isset($ini['env']['environment']) ? 'development' : $ini['env']['environment'];
if (!isset($_SERVER['salt'])) $_SERVER['salt'] = !isset($ini['env']['salt']) ? random_str(64, true) : $ini['env']['salt'];
if (!isset($_SERVER['maintenance_mode'])) $_SERVER['maintenance_mode'] = ($ini['env']['maintenance_mode'] == 'true') ? true : false;

require_once BASE_DIR.'/app/routes.php';
?>
