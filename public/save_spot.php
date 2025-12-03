<?php
session_start();
require_once __DIR__ . '/../app/controllers/SpotController.php';

$controller = new SpotController();
$controller->store();

