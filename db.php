<?php

$host = 'localhost';
$db = 'pawplanner';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,   // Zeigt SQL-Fehler an
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         // Gibt Daten als Array zurück
    PDO::ATTR_EMULATE_PREPARES => false,                    // Erhöht Sicherheit gegen SQL-Injections
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);
    //Wenn hier nichts passiert, Verbindung erfolgreich!
} catch (\PDOException $e) {
    // Falls es knallt: Fehler anzeigen und abbrechen!
    die("Verbindungsfehler: " . $e->getMessage());
}
