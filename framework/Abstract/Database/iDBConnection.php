<?php

namespace Framework\Abstract\Database;

use Framework\Http\Model;
use InvalidArgumentException;

interface iDBConnection {
    /**
     * Insert Data.
     *
     * Esta função insere dados na tabela do banco de dados,
     *
     * @param array $data Dados que serão inseridos. Deve ser um vetor no formato ['campo'=>'valor']!
     * @param array $mandatory_data Dados .
     * @param string $table Tabela a ser manipulada.
     * @param string $model Nome da classe a ser instanciada.
     * @return Model Retorna uma instância do Model manipulado
     * @throws InvalidArgumentException Tabela ou valores inválidos.
     */
    public function insert(array $data, array $mandatory_data, string $table=null, string $model=null): Model;

    /**
     * Get Data.
     *
     * Esta função lista os dados da tabela do banco de dados,
     *
     * @param mixed $filter Filtragem dos dados a serem listados.
     * @param string $table Tabela a ser manipulada.
     * @param string $model Nome da classe a ser instanciada.
     * @return Model Retorna uma instância do Model manipulado
     * @throws InvalidArgumentException Tabela ou valores inválidos.
     */
    // public function get(mixed $filter, string $table, string $model): Model;

    // /**
    //  * Find By Id.
    //  *
    //  * Esta função busca por um dado com id especifico na tabela do banco de dados,
    //  *
    //  * @param string $id Identificador Único da tabela para ser buscado.
    //  * @param string $table Tabela a ser manipulada.
    //  * @param string $model Nome da classe a ser instanciada.
    //  * @return Model[] Retorna uma instância do Model manipulado
    //  * @throws InvalidArgumentException Tabela ou valores inválidos.
    //  */
    // public function findById(string|int $id, string $table, string $model): Model;
    // public function find(string $table, string $model, ...$filter): Model;
    // public function patch($data, string $table, string $model): Model;
    // public function put($data, string $table, string $model): Model;
    // public function delete($id, string $table, string $model): void;

    // public function query($q): mixed;
}
