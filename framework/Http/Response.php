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

    /**
     * Render Page.
     *
     * Esta função renderiza uma página HTML ou PHP que esteja no diretório /resources/views/,
     *
     * @param string $file Arquivo (deve-se inserir a extensão do arquivo).
     * @param array $data Valores em formatao de VETOR que serão acessados na página.
     * @return void Não retorna nada
     */
    public function render(string $file, $data) {
        $file_exists = $this->validateFile($file);
        if(!$file_exists) {
            die('Page não existe');
        }
        extract($data);
        require $this->views.$file;
        
    }

    public function send(string $msg, int $status=200) {
        http_response_code($status);
        echo $msg;
    }

    
}