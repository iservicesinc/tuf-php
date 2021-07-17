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
switch ($path) {

    case '/':
    case '/home':
        $router->route('home.page', array("title" => "Welcome"));
        break;
    
    case '/docs':
        $params['title'] = "Documentation";
        $params['tuf'] = $_SESSION['TUF'];
        $router->route('docs.page', $params);
        break;

    // Maintenance page
    case '/maintenance':
        if ($_SERVER['maintenance_mode'] === true) {
            http_response_code(503);
            $page = 'maintenance';
            $params['title'] = "Maintenance Mode";
            router('maintenance', $params);
        } else {
            header("Location: /");
        }
        break;

    default:
        $router->route('404');
        break;
}
        
?>