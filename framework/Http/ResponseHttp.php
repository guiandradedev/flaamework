<?php

namespace Framework\Http;

use Framework\Abstract\Http\Response;

class ResponseHttp extends Response{
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

    /**
     * Return HTTP Message.
     *
     * Esta função retorna uma string parâmetrizada como resposta de uma requisição HTTP,
     *
     * @param string $msg Mensagem a ser renderizada.
     * @param int $status Status HTTP relativo a mensagem a ser enviada.
     * @return array ['msg'=>$msg, 'status'=>$status]
     */
    public function send(string $msg, int $status=200) {
        http_response_code($status);
        echo $msg;
        return ['msg'=>$msg, 'status'=>$status];
    }

    /**
     * Return JSON HTTP Message.
     *
     * Esta função retorna um JSON como resposta de uma requisição HTTP,
     *
     * @param mixed $msg Conteudo a ser renderizado.
     * @param int $status Status HTTP relativo a mensagem a ser enviada.
     * @return array ['msg'=>$msg, 'status'=>$status]
     */
    public function json($msg, int $status=200) {
        http_response_code($status);
        $json = json_encode($msg);
        echo $json;
        return ['msg'=>$json, 'status'=>$status];
    }

    // public function redirect(string $url) {
    //     header('Location: '.$url);
    //     die();
    // }

    
}