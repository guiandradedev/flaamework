<?php

namespace App\Model;

use Framework\Http\Model;

class User extends Model{
    protected string $table = "users";
    public function __construct(array $data = [])
    {
        parent::__construct($this->table, User::class);
    }
}