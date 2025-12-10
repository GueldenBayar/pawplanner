<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';
$controller = new PlaymatchController();

$dogId = isset($_GET['dog_id']) ? (int) $_GET['dog_id'] : 0;
$matchDog = $controller->getDogById($dogId);
if (!$matchDog) {
    header('Location: playmatch.php');
    exit;
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Match</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <div class="match-popup match-page">
        <h2>🎉It's a Maaaaaatch!!</h2>

        <img src="uploads/<?= $matchDog['image'] ?>" alt="dog image"
            style="width: 100%; border-radius: 20px; margin: 20px 0;">
        <h3><?= $matchDog['name'] ?></h3>
        <p><?= $matchDog['breed'] ?></p>
        <p><?= $matchDog['age'] ?>years old</p>

        <a href="playmatch.php"><button class="btn-primary">Continue swiping</button></a>
    </div>

</body>

</html>