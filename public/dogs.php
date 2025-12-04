<?php
session_start();
require_once __DIR__ . '/../app/models/Dog.php';

$dogModel = new Dog();
$dogs = $dogModel->getAll();

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dogs</title>
    <style>
        body {
            font-family: Arial;
            background: #f4f4f4;
        }

        h2 {
            text-align: center;
        }

        .dog-grid {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            padding: 40px;
        }

        .dog-card {
            background: white;
            width: 220px;
            border-radius: 12px;
            box-shadow: 0 5px 10px rgba(0,0,0,0.1);
            padding: 15px;
            text-align: center;
        }

        .dog-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 10px;
        }

        .dog-card h3 {
            margin: 10px 0 5px;
        }

        .owner {
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>
<h2>All Dogs</h2>
<div class="dog-grid">
    <?php foreach ($dogs as $dog): ?>
    <div class="dog-card">
        <?php if ($dog['image']): ?>
        <img src="uploads/<?= htmlspecialchars($dog['image']) ?>" alt="picture of dog">
        <?php else: ?>
        <img src="https://via.placeholder.com/200x180?text=Kein+Bild" alt="">
        <?php endif; ?>

        <h3><?= htmlspecialchars($dog['name']) ?></h3>
        <p><?= htmlspecialchars($dog['breed']) ?> • <?= $dog['age'] ?>years old</p>
        <p class="owner">Besitzer: <?=  htmlspecialchars($dog['username'])?></p>
        <p><?= htmlspecialchars($dog['description']) ?></p>
    </div>
    <?php endforeach; ?>
</div>


</body>
</html>
