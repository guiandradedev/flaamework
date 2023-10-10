<?php

namespace App\Http\Controllers;

use Config\App;
use Framework\Abstract\Http\{Request, Response};
use Framework\Http\{Controller};

class UserController extends Controller {
    public function index(Request $request, Response $response) {
        $url = App::env('APP_URL', '.');
        $response->render('index.php', ['url'=>$url]);
    }

    public function signin() {
        echo 'logar';
    }

    public function signup() {
        echo 'cadastrar';
    }
}