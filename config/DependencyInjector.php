<?php

namespace Config;

use Framework\Abstract\Http\{Request, Response};
use Framework\Http\{RequestHttp, ResponseHttp};

class DependencyInjector {
    public array $dependencies = [];

    public function __construct()
    {
        $this->register();
    }
    
    public function register() {
        $this->bind(Request::class, RequestHttp::class);
        $this->bind(Response::class, ResponseHttp::class);
    }

    private function bind(string $abstract, string $final) {
        array_push($this->dependencies, [
            'abstract'=>$abstract,
            'final'=>$final
        ]);
    }
}