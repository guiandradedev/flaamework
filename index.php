<?php

use Framework\Http\Router;
use Routes\Routes;

require 'config/autoload.php';

$routes = new Routes();
$routes->execute();

if(isset($_SERVER['REQUEST_METHOD'])) {
    Router::execute(isset($_GET['url']) ? $_GET['url'] : '/', $_SERVER['REQUEST_METHOD']);
}