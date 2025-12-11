<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host = '127.0.0.1';
        $db = 'pawplanner';
        $user = 'pawuser';
        $pass = 'pawpass';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        $this->pdo = new PDO($dsn, $user, $pass);
        $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function connect () {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }
}
