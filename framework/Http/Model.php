<?php

namespace Framework\Http;

use Config\App;
use Exception;
use Framework\Utils\ArrayUtils;
use InvalidArgumentException;
use PDO;

abstract class Model
{
    protected string $table;
    protected string $model;
    protected PDO $db;

    public function __construct(string $table, string $model)
    {
        // validate table model
        $this->table = $table;
        $this->model = $model;

        // connect db
        $env = App::env();
        try {
            $this->db = new PDO('mysql:host=' . $env['DB_HOST'] . ';dbname=' . $env['DB_DATABASE'], $env['DB_USERNAME'], $env['DB_PASSWORD']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            print_r($e);
            echo '<h2>Erro ao se conectar com o banco de dados!</h2>';
        }

        $this->verifyTable($this->table);
    }

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
    protected function insert(array $data, array $mandatory_data, string $table = null, string $model = null): Model
    {
        if ($table === null) $table = $this->table;
        if ($model === null) $model = $this->model;
        // falta validar se os valores são válidos
        if (!is_subclass_of($model, Model::class)) {
            throw new InvalidArgumentException("This class is not a model.");
        }
        $mandatory_valid = ArrayUtils::elements_in_array($data, $mandatory_data);
        if (count($mandatory_valid) !== 0) {
            throw new InvalidArgumentException('Invalid Arguments');
        }
        $columns = implode(', ', array_keys($data));
        $query = "INSERT INTO $table (" . $columns . ") VALUES (";
        foreach ($dt = array_keys($data) as $value) {
            if ($value === end($dt)) {
                $query .= ":" . $value . ");";
            } else {
                $query .= ":" . $value . ", ";
            }
        }
        $stmt = $this->db->prepare($query);
        foreach ($data as $key => $value) {
            $stmt->bindParam(":" . $key, $value);
        }

        $stmt->execute();
        $data['id'] = $this->db->lastInsertId();;

        $instance = new $model($data);
        return $instance;
    }

    // /**
    //  * Get Data.
    //  *
    //  * Esta função lista os dados da tabela do banco de dados,
    //  *
    //  * @param mixed $filter Filtragem dos dados a serem listados.
    //  * @param string $table Tabela a ser manipulada.
    //  * @param string $model Nome da classe a ser instanciada.
    //  * @return Model Retorna uma instância do Model manipulado
    //  * @throws InvalidArgumentException Tabela ou valores inválidos.
    //  */
    // protected function get(mixed $filter, string $table, string $model): Model;
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
    // protected function findById(string|int $id, string $table, string $model): Model;
    // protected function find(string $table, string $model, ...$filter): Model;
    // protected function patch($data, string $table, string $model): Model;
    // protected function put($data, string $table, string $model): Model;
    // protected function delete($id, string $table, string $model): void;

    // // protected function query($q): mixed;

    /**
     * Validate Table.
     *
     * Esta função verifica se a tabela inserida é válida no banco de dados,
     *
     * @param string $table Tabela a ser manipulada.
     * @return Boolean Retorna uma instância do Model manipulado
     * @throws InvalidArgumentException Tabela inválidos.
     */
    private function verifyTable($table)
    {
        $query = "SHOW TABLES LIKE '$table'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        if ($stmt->rowCount() === 0) {
            throw new InvalidArgumentException('Table not found');
        }
    }
}
