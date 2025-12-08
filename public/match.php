<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';

$controller = new PlaymatchController();
$dogId = $_GET['dog_id'];
$matchDog = $controller->getDogById($dogId);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>It's a Maaatch!!!</title>
    <style>
        body {
            background: #ffdde1;
            font-family: Arial;
            text-align: center;
            padding-top: 60px;
        }
        .match-box {
            background: white;
            width: 350px;
            margin: auto;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.3);
        }
        img {
            width: 100%;
            border-radius: 10px;
        }
        h2 {
            color: #e63946;
            font-size: 30px;
        }
        a button {
            margin-top: 20px;
            padding: 12px 20px;
            font-size: 18px;
        }
    </style>
</head>
<body>
<div class="match-box">
    <h2>🎉It's a Maaaaaatch!!</h2>

    <img src="uploads/<?= $matchDog['image'] ?>" alt="dog image">
    <h3><?= $matchDog['name'] ?></h3>
    <p><?= $matchDog['breed'] ?></p>
    <p><?= $matchDog['age'] ?>years old</p>

    <a href="playmatch.php"><button>Continue swiping</button></a>
</div>

</body>
</html>
