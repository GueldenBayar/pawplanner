<?php

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        // Innerhalb von Docker heißt der Host 'db', nicht localhost
        // Fallback Logik, falls keine ENV Variable da ist
        $host = getenv('DB_HOST') ?: 'db';
        $db = getenv('DB_NAME') ?: 'pawplanner';
        $user = getenv('DB_USER') ?: 'pawuser';
        $pass = getenv('DB_PASS') ?: 'pawpass';
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";

        try {
            $this->pdo = new PDO($dsn, $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e){
            // zeige nur im Notfall den Fehler, um Passwörter nicht zu leaken
            die("Verbindungsfehler zur Datenbank: " . $e->getMessage());
        }
    }
    public static function connect () {
        if (self::$instance === null) {
            self::$instance = new Database();
        }
        return self::$instance->pdo;
    }

    // Hilfsfunktion für MatchModel
    public static function getInstance() {
        return self::connect();
    }
}
