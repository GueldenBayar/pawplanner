<?php

use controllers\AuthController;

session_start();
require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController();
$auth->login();
?>

<h2>Login</h2>

<form method="POST">
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Passwort"><br><br>

    <button type="submit">Login</button>
</form>

<a href="register.php">Noch kein Account? :)</a>