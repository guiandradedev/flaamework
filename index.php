<?php

use App\Http\Controllers\TesteController;
use Framework\Router;

require 'config/autoload.php';

Router::get('route/aa/bb', [TesteController::class, 'index']);
Router::get('route/aa/bbc', [TesteController::class, 'index']);
Router::get('route/aa/bbggg', [TesteController::class, 'index']);

if(isset($_GET['url'])) {
    Router::execute($_GET['url'], 'GET');
}