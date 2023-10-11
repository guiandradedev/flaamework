<?php

namespace App\Model;

use Framework\Http\Model;

class User extends Model{
    protected string $table = "users";
    public function __construct(array $data = [])
    {
        parent::__construct($this->table, User::class);
    }

    public function insert(array $data, array $mandatory_data, string $table = null, string $model = null): User {
        $model = parent::insert($data, $mandatory_data, $this->table, User::class);
        return $model;
    }
}