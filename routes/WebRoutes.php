<?php

namespace Routes;

use App\Http\Controllers\TesteController;
use Framework\Abstract\Http\Routes;
use Framework\Http\Router;

class WebRoutes implements Routes{
    public function execute() {
        Router::get('route/aa/bb', [TesteController::class, 'index']);
        Router::get('route/aa/bbc', [TesteController::class, 'index']);
        Router::get('route/aa/bbggg', [TesteController::class, 'index']);
    }
}