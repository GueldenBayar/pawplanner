<?php
session_start();

require_once __DIR__ . '/../app/models/Dog.php';

$dogModel = new Dog();
$dogs = $dogModel->getAll();
?>

<h2>Playmatch</h2>

<?php foreach ($dogs as $dog): ?>
    <?php if ($dog['user_id'] == $_SESSION['user_id']) continue; ?>

<div>
    <h3><?= $dog['name'] ?></h3>
    <p><?= $dog['breed'] ?> | <?= $dog['age'] ?>Years</p>

    <?php if ($dog['image']): ?>
    <img src="uploads/dogs/<?= $dog['image'] ?>" width="200"><br>
    <?php endif; ?>
</div>
<?php endforeach; ?>