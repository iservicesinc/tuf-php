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
namespace Iservicesinc\TufPhp;

class Router {

    public static $routes = array();
    public static $latte = '';

    function __construct() {
        self::$latte = new \Latte\Engine;
        self::$latte->setTempDirectory(BASE_DIR . '/.cache');
    }

    public function addRoute($methods, $pattern, $temp, $kargs = array()) {
        foreach (explode('|', $methods) as $method) {
            self::$routes[$method][$pattern] = array(
                'template' => $temp,
                'params' => $kargs,
            );
        }
    }

    public function all($pattern, $fn) {
        self::addRoute('GET|POST|PUT|DELETE|OPTIONS|PATCH|HEAD', $pattern, $fn, $kargs = array());
    }

    public function init() {
        if (!isset($_SESSION['salt'])) {
            $_SESSION['salt'] = hash('sha256', $_SERVER['REMOTE_ADDR'] . time() . $_SERVER['salt'], 0);
            setcookie('salt', $_SESSION['salt'], time() + 60*60, '/', $_SERVER['SERVER_NAME'], 0, 1);
        }
        self::maintenance();
        $url = parse_url($_SERVER['REQUEST_URI']);
        $path = empty($url['path']) ? '/' : $url['path'];
        $route = isset(self::$routes[$_SERVER['REQUEST_METHOD']][$path]) ? self::$routes[$_SERVER['REQUEST_METHOD']][$path] : false;
        
        if ($route !== false) {
            $template_file = BASE_DIR . "/views/" . $route['template'] . ".latte";
            self::$latte->render($template_file, $route['params']);

        } else {
            self::not_found();
        }
    }

    function maintenance() {
        if ($_SESSION['TUF']['env']['maintenance_mode'] == 'true') {
            http_response_code(503);
            $params['title'] = "Maintenance Mode";
            self::$latte->render(BASE_DIR . '/views/maintenance.latte', $params);
            exit(0);
        }
    }
    
    function not_found() {
        http_response_code(404);
        $params['title'] = "Not found";
        self::$latte->render(BASE_DIR . '/views/404.latte', $params);
        exit(0);
    }

}
?>