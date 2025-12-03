<?php

use controllers\AuthController;

session_start();
require_once __DIR__ . '/../app/controllers/AuthController.php';

$auth = new AuthController();
$auth->register();

?>

<h2>Registrieren</h2>

<form method="POST">
    <label for="Username"><input type="text" name="username" placeholder="Username"></label><br><br>
    <input type="email" name="email" placeholder="Email"><br><br>
    <input type="password" name="password" placeholder="Passwort"><br><br>

    <button type="submit">Registrieren</button>
</form>

<a href="login.php">Zum Login</a>