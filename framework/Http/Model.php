<?php

namespace Framework\Http;

use Config\App;
use Exception;
use Framework\Abstract\Database\iDBConnection;
use Framework\Utils\ArrayUtils;
use InvalidArgumentException;
use PDO;

abstract class Model implements iDBConnection
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
        try {
            $this->db = new PDO('mysql:host=' . App::env()['DB_HOST'] . ';dbname=' . App::env()['DB_DATABASE'], App::env()['DB_USERNAME'], App::env()['DB_PASSWORD']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (Exception $e) {
            print_r($e);
            echo '<h2>Erro ao se conectar com o banco de dados!</h2>';
        }

        $this->verifyTable($this->table);
    }

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
        if($stmt->rowCount() === 0) {
            throw new InvalidArgumentException('Table not found');
        }
    }

    public function insert(array $data, array $mandatory_data, string $table=null, string $model=null): Model
    {
        if($table === null) $table = $this->table;
        if($model === null) $model = $this->model;
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


    // public function get(mixed $filter, string $table, string $model): Model;
    // public function findById(string|int $id, string $table, string $model): Model;
    // public function find(string $table, string $model, ...$filter): Model;
    // public function patch($data, string $table, string $model): Model;
    // public function put($data, string $table, string $model): Model;
    // public function delete($id, string $table, string $model): void;

    // public function query($q): mixed;
}
