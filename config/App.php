<?php

namespace Config;

class App {
    public static function env(string $environment_variable, string $if_not) {
        if(getenv($environment_variable))
            return getenv($environment_variable);
        
        return $if_not;
    }
}