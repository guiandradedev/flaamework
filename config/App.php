<?php

namespace Config;

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(dirname(__DIR__));
$dotenv->load();

class App {
    public static function bind(string $environment_variable, string $if_not) {
        if($_SERVER[$environment_variable])
            return $_SERVER[$environment_variable];
        
        return $if_not;
    }

    public static function env() {
        return [
            "APP_NAME"=>self::bind("APP_NAME", "Flaamework"),
            "APP_ENV"=>self::bind("APP_ENV", "local"),
            "APP_FORMAT"=>self::bind("APP_FORMAT", "web"),
            "APP_KEY"=>self::bind("APP_KEY", ""),
            "APP_URL"=>self::bind("APP_URL", "localhost"),
            "DB_CONNECTION"=>self::bind("DB_CONNECTION", "mysql"),
            "DB_HOST"=>self::bind("DB_HOST", "localhost"),
            "DB_PORT"=>self::bind("DB_PORT", "3306"),
            "DB_DATABASE"=>self::bind("DB_DATABASE", "database"),
            "DB_USERNAME"=>self::bind("DB_USERNAME", "root"),
            "DB_PASSWORD"=>self::bind("DB_PASSWORD", ""),
        ];
    }

}