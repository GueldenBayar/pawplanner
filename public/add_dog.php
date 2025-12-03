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

<form method="POST" enctype="multipart/form-data">
    <label for="name"><input type="text" name="name" placeholder="Name" required></label><br><br>
    <label for="breed"><input type="text" name="breed" placeholder="Breed" required></label><br><br>
    <label for="age"><input type="number" name="age" placeholder="Age" required></label><br><br>
    <label for="description"><textarea name="description" placeholder="describe your furry friend.."></textarea></label><br><br>

    <input type="file" name="image" required><br><br>

    <button type="submit">Save</button>
</form>

<a href="my_dogs.php">My Dogs</a>