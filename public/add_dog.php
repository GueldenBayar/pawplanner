<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../app/controllers/DogController.php';

$controller = new DogController();
$controller->store();
?>

<h2>Add Dog</h2>

<form action="" method="POST">
    <label for="name"><input type="text" name="name" placeholder="Name"></label><br><br>
    <label for="breed"><input type="text" name="breed" placeholder="Breed"></label><br><br>
    <label for="age"><input type="number" name="age" placeholder="Age"></label><br><br>
    <label for="description"><textarea name="description" placeholder="describe your furry friend.."></textarea></label><br><br>

    <button type="submit">Save</button>
</form>

<a href="my_dogs.php">My Dogs</a>