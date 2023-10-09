<?php

namespace Framework\Http;

use Exception;

class Response {
    private string $views;
    public function __construct()
    {
        chdir('.');
        $views = getcwd();
        $this->views = $views."/resources/views/";
    }
    private function validateFile($file) {
        return file_exists($this->views.$file);
    }
    public function render(string $file, ...$data) {
        $file_exists = $this->validateFile($file);
        if(!$file_exists) {
            die('Page não existe');
        }
        extract($data);
        require $this->views.$file;
        
    }
}