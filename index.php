<?php

use App\Http\Controllers\TesteController;
use Framework\Http\Router;
use Routes\Routes;

require 'config/autoload.php';

$routes = new Routes();
$routes->execute();

if(isset($_GET['url'])) {
    Router::execute($_GET['url'], 'GET');
}