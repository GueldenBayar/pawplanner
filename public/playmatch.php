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
        body {
            background: #f7f7f7;
            font-family: Arial;
        }
        .card {
            width: 320px;
            margin: 80px auto;
            background: white;
            padding: 20px;
            text-align: center;
            border-radius: 18px;
            box-shadow: 0 5px 25px rgba(0,0,0,0.2);
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        img {
            width: 100%;
            border-radius: 15px;
        }

        button {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
        }

        .like, .nope {
            font-size: 26px;
            padding: 12px 22px;
            border-radius: 50px;
        }

        .card-stack {
            position: relative;
            width: 320px;
            margin: 80px auto;
        }

        .card {
            position: absolute;
            width: 100%;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .card:nth-child(1) { z-index: 3; }
        .card:nth-child(2) {
            z-index: 2;
            transform: scale(0.95) translateY(10px);
            opacity: 0.7;
        }
        .card:nth-child(3) {
            z-index: 1;
            transform: scale(0.9) translateY(20px);
            opacity: 0.5;
        }

        @media (max-width: 600px) {
            .card {
                width: 92%;
                margin: 40px auto;
                padding: 16px;
            }

            h3 {
                font-size: 22px;
            }

            p {
                font-size: 16px;
            }

            .buttons button {
                font-size: 18px;
                padding: 10px 18px;
            }

            .match-popup {
                position: fixed;
                top: 20px;
                right: 20px;
                background: #ff4d6d;
                color: white;
                padding: 15px 25px;
                font-size: 20px;
                border-radius: 12px;
                box-shadow: 0 5px 15px rgba(0,0,0,0.3);
                animation: fadeout 2.5s forwards;
            }

            @keyframes fadeout {
                0% { opacity: 1; transform: translateY(0); }
                80% {opacity: 1; }
                100% { opacity: 0; transform: translateY(-20px);}
            }
        }
    </style>
</head>
<body>
<?php if (isset($_GET['match']) && $_GET['match'] == 1): ?>
<div id="matchPopup" class="match-popup">
    🎉 It's a Maaaatch!
</div>
<?php endif; ?>
<div class="card-stack">
    <div class="card card-top" id="card">
        <img src="uploads/<?= $randomDog['image'] ?>" alt="image of a dog">
        <h3><?= $randomDog['name'] ?></h3>
        <p><?= $randomDog['breed'] ?></p>
        <p><?= $randomDog['age'] ?> years old</p>
        <p>Owner: <?= $randomDog['username'] ?></p>

        <div class="buttons">
            <form method="GET" action="like.php" style="display:inline;">
                <input type="hidden" name="user_id" value="<?= $randomDog['user_id'] ?>">
                <input type="hidden" name="dog_id" value="<?= $randomDog['id']?>">
                <button type="submit" class="like">💖 Like</button>
            </form>

            <a href="playmatch.php">
                <button class="nope">🥲 Not for me</button>
            </a>
        </div>
    </div>


    <script>
        const card = document.getElementById("card");

        document.querySelector(".like").addEventListener("click", () => {
            card.style.transform = "translateX(300px) rotate(25px)";
            card.style.opacity = "0";
        });

        document.querySelector(".nope").addEventListener("click", () => {
            card.style.transform = "translateX(-300px) rotate(-25deg)";
            card.style.opacity = "0";
        })

        document.querySelector(".like").addEventListener("click", () => {
            card.style.transform = "translateX(300px) rotate(25deg)";
            card.style.opacity = "0";
            setTimeout(() => {
                card.parentElement.querySelector("form").submit();
            }, 400);
        });

        document.querySelector(".nope").addEventListener("click", () => {
            card.style.transform = "translateX(-300px) rotate(-25deg)";
            card.style.opacity = "0";
            setTimeout(() => {
                window.location.href="playmatch.php";
            }, 400);
        })

        function shiftCards() {
            const stack = document.querySelector(".card-stack");
            const cards = stack.querySelectorAll(".card");

            if (cards.length > 1) {
                stack.appendChild(cards[0]); // erste Karte nach hinten setzen
            }
        }

        document.querySelector(".like").addEventListener("click", () => {
            card.style.transform = "translateX(300px) rotate(25deg)";
            card.style.opacity = "0";

            setTimeout(() => {
                shiftCards();
                window.location.href= document.querySelector("form").action;
            }, 400);
        });

        document.querySelector(".nope").addEventListener("click", () => {
            card.style.transform = "translateX(-300px) rotate(-25)";
            card.style.opacity = "0";

            setTimeout(() => {
                shiftCards();
                window.location.href = "playmatch.php";
            }, 400);
        })
    </script>
</div>
</body>
</html>