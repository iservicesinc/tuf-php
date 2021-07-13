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
namespace Homepage;

if (file_exists(BASE_DIR . '/.env.ini')) {
    $ini = parse_ini_file(BASE_DIR . '/.env.ini', true);
} else {
    die(".env Ini file is missing!");
}

$_SERVER['maintenance_mode'] = ($ini['maintenance_mode'] == 'true') ? true : false;

define('CLASS_DIR', 'app/');
set_include_path(get_include_path().PATH_SEPARATOR.CLASS_DIR);
spl_autoload_extensions('.class.php');
spl_autoload_register();

if (file_exists(BASE_DIR.'/vendor/autoload.php')) {
    require_once(BASE_DIR.'/vendor/autoload.php');
}

require_once BASE_DIR.'/app/routes.php';
?>
