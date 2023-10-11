<?php

namespace Framework\Abstract\Http;

abstract class Response {
    /**
     * Render Page.
     *
     * Esta função renderiza uma página HTML ou PHP que esteja no diretório /resources/views/,
     *
     * @param string $file Arquivo (deve-se inserir a extensão do arquivo).
     * @param array $data Valores em formatao de VETOR que serão acessados na página.
     * @return void Não retorna nada
     */
    public function render(string $file, $data) {}

    /**
     * Include HTML Component.
     *
     * Esta função renderiza um componente PHP que esteja no diretório /resources/views/components,
     *
     * @param string $file Arquivo (deve-se inserir a extensão do arquivo).
     * @param array $data Valores em formatao de VETOR que serão acessados na página.
     * @return void Não retorna nada
     */
    public function include(string $file, $data) {}

    /**
     * Return HTTP Message.
     *
     * Esta função retorna uma string parâmetrizada como resposta de uma requisição HTTP,
     *
     * @param string $msg Mensagem a ser renderizada.
     * @param int $status Status HTTP relativo a mensagem a ser enviada.
     * @return array ['msg'=>$msg, 'status'=>$status]
     */
    public function send(string $msg, int $status=200) {}

    /**
     * Return JSON HTTP Message.
     *
     * Esta função retorna um JSON como resposta de uma requisição HTTP,
     *
     * @param mixed $msg Conteudo a ser renderizado.
     * @param int $status Status HTTP relativo a mensagem a ser enviada.
     * @return array ['msg'=>$msg, 'status'=>$status]
     */
    public function json($msg, int $status=200) {}
}