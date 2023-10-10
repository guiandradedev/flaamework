<?php

namespace Routes;

use Framework\Abstract\Http\Routes as HttpRoutes;
use Framework\Http\Router;

class Routes implements HttpRoutes{
    protected WebRoutes $web;
    public function __construct()
    {
        $this->web = new WebRoutes();
    }
    public function execute() {
        $this->web->execute();
    }
}