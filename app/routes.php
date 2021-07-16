<?php
use \Iservicesinc\TufPhp\Router;

$url = parse_url($_SERVER['REQUEST_URI']);
$path = $url['path'];
$router = new Router();
$router->maintenance();
if (!isset($_SESSION['salt'])) {
    $_SESSION['salt'] = hash('sha256', $_SERVER['REMOTE_ADDR'] . time() . $_SERVER['salt'], 0);
    setcookie('salt', $_SESSION['salt'], time() + 60*60, '/', $_SERVER['SERVER_NAME'], 0, 1);
}

switch ($path) {

    case '/':
    case '/home':
        $router->route('home.page', array("title" => "Welcome"));
        break;
    
    case '/docs':
        $router->route('docs.page', array("title" => "Documentation"));
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