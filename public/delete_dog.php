<?php
session_start();
require_once __DIR__ . '/../app/controllers/DogController.php';

if (!isset($_GET['id'])) {
    die("Keine ID übergeben.");
}

$controller = new DogController();
$controller->delete($_GET['id']);