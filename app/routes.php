<?php
require BASE_DIR . '/app/lib/Router.class.php';

$url = parse_url($_SERVER['REQUEST_URI']);
$path = $url['path'];
$router = new Router();
$router->maintenance();

switch ($path) {

    case '/':
    case '/home':
        $router->route('home.page', array("title" => "Welcome"));
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