<?php

namespace Routes;

use App\Http\Controllers\{UserController};
use Framework\Abstract\Http\Routes;
use Framework\Http\Router;

class WebRoutes implements Routes{
    public function execute() {
        Router::get('/', [UserController::class, 'index']);
        Router::get('/signin', [UserController::class, 'signin']);
        Router::get('/signup', [UserController::class, 'signup']);
    }
}