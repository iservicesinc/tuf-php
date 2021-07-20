<?php
use \Iservicesinc\TufPhp\Router;

$router = new Router();

$router::addRoute('GET', '/', 'home.page', array('title' => 'TUF-php'));
$router::addRoute('GET', '/docs', 'docs.page', array('title' => 'TUF-php Documentation'));

$router::init();
?>