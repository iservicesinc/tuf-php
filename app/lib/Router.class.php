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
class Router {

    function maintenance() {
        if ($_SERVER['maintenance_mode'] == true) {
            $latte = new Latte\Engine;
            $latte->setTempDirectory(BASE_DIR . '/.cache');
            $latte->render(BASE_DIR . '/views/maintenance.latte', $args = array());
            exit(0);
        }
    }

    function route(string $page, array $args = array()) {
        $latte = new Latte\Engine;
        $latte->setTempDirectory(BASE_DIR . '/.cache');
        $file = glob(BASE_DIR . "/views/$page*");
    
        if(!empty($file)) {
            $latte->render($file[0], $args);
            exit(0);
        } else {
            return http_response_code(404);
            exit(0);
        }
    }

}
?>