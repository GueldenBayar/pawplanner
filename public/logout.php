<?php

use controllers\AuthController;

session_start();
require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController();
$auth->logout();