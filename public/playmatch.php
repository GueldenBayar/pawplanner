<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';

$controller = new PlaymatchController();
$dogs = $controller->swipe();

// Nur fremde Hunde anzeigen
$myUserId = $_SESSION['user_id'] ?? 0;

// filter out my own dogs
$filtered = array_filter($dogs, function ($dog) use ($myUserId) {
    return $dog['user_id'] != $myUserId;
});

$randomDog = null;
if (!empty($filtered)) {
    $randomDog = $filtered[array_rand($filtered)];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
        content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PlayMatch</title>
    <link rel="stylesheet" href="css/style.css">
    <script src="js/playmatch.js" defer></script>
</head>

<body>

    <?php if (isset($_GET['match']) && $_GET['match'] == 1): ?>
        <div id="matchPopup" class="match-popup">
            🎉 It's a Maaaatch!
        </div>
    <?php endif; ?>

    <div class="card-stack">
        <?php foreach ($filtered as $index => $dog): ?>
            <div class="dog-card" data-dog-id="<?= $dog['id'] ?>" data-user-id="<?= $dog['user_id'] ?>"
                style="z-index: <?= 1000 - $index ?>">

                <img src="uploads/<?= $dog['image'] ?>" alt="<?= $dog['name'] ?>">

                <div class="info">
                    <h2><?= $dog['name'] ?> (<?= $dog['breed'] ?>)</h2>
                    <p><?= $dog['age'] ?>years old</p>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <div id="buttons">
        <button id="nope-btn">❌</button>
        <button id="like-btn">💚</button>
    </div>

</body>

</html>