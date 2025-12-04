<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';

$controller = new PlaymatchController();
$dogs = $controller->swipe();

// Nur fremde Hunde anzeigen
$myUserId = $_SESSION['user_id'];

$filtered = array_filter($dogs, function($dog) use ($myUserId) {
    return $dog['user_id'] != $myUserId;
});

$randomDog = $filtered[array_rand($filtered)];
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PlayMatch</title>
    <style>
        .card {
            width: 320px;
            margin: 100px auto;
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.2);
        }

        img {
            width: 100%;
            border-radius: 10px;
        }

        button {
            padding: 10px 20px;
            margin: 10px;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="card">
        <img src="uploads/<?= $randomDog['image'] ?>" alt="image of a dog">
        <h3><?= $randomDog['name'] ?></h3>
        <p><?= $randomDog['breed'] ?></p>
        <p><?= $randomDog['age'] ?> years old</p>
        <p>Owner: <?= $randomDog['username'] ?></p>

        <form method="POST" action="like.php">
            <input type="hidden" name="to_user_id" value="<?= $randomDog['user_id'] ?>">
            <button type="submit">♥️ Like</button>
        </form>

        <a href="playmatch.php"><button>❌ Nope</button></a>

    </div>
</body>
</html>