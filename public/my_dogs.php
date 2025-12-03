<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

require_once __DIR__ . '/../app/models/Dog.php';

$dogModel = new Dog();
$dogs = $dogModel->getByUser($_SESSION['user_id']);
?>

<h2>My Dogs</h2>

<a href="add_dog.php">➕ New Dog</a><br><br>

<?php foreach ($dogs as $dog): ?>
<div>
    <strong><?= htmlspecialchars($dog['name']) ?></strong><br>
    Breed: <?= htmlspecialchars($dog['breed']) ?> <br>
    Age: <?= $dog['age'] ?><br>
    Description: <?= htmlspecialchars($dog['description']) ?><br><br>

    <a href="delete_dog.php?id=<?= $dog['id'] ?>">Löschen</a>
</div>

<?php endforeach; ?>

<a href="dashboard.php">Back</a>
