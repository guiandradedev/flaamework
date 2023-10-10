<?php

namespace App\Http\Controllers;

use Framework\Abstract\Http\Response;
use Framework\Abstract\Http\Request;
use Framework\Http\{Controller};

class TesteController extends Controller {
    public function index(Request $request, Response $response) {
        $response->render('index.php', []);
    }
}