<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';

$controller = new PlaymatchController();
$dogs = $controller->swipe();

// Nur fremde Hunde anzeigen
$myUserId = $_SESSION['user_id'];

$filtered = array_filter($dogs, function ($dog) use ($myUserId) {
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
            box-shadow: 0 5px 25px rgba(0, 0, 0, 0.2);
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

        #card-stack {
            position: relative;
            width: 100%;
            height: 70vh;
            margin-top: 20px;
        }

        .dog-card {
            position: absolute;
            width: 90%;
            left: 5%;
            top: 0;
            height: 100%;
            border-radius: 18px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 8px 20px rgba(0,0,0,0.15);
            transition: transform 0.25s ease-out, opacity 0.25s ease-out;
        }

        .dog-card img {
            width: 100%;
            height: 70%;
            object-fit: cover;
        }

        .info {
            padding: 15px;
        }

        #buttons {
            display: flex;
            justify-content: space-evenly;
            margin-top: 20px;
        }

        #buttons button {
            padding: 15px 20px;
            border: none;
            border-radius: 50%;
            font-size: 18px;
            cursor: pointer;
            background: #eee;
        }

        .card {
            position: absolute;
            width: 100%;
            transition: transform 0.5s ease, opacity 0.5s ease;
        }

        .card:nth-child(1) {
            z-index: 3;
        }

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
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
                animation: fadeout 2.5s forwards;
            }

            @keyframes fadeout {
                0% {
                    opacity: 1;
                    transform: translateY(0);
                }
                80% {
                    opacity: 1;
                }
                100% {
                    opacity: 0;
                    transform: translateY(-20px);
                }
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
    <?php foreach ($dogs as $index => $dog): ?>
        <div class="dog-card" data-dog-id="<?= $dog['id'] ?>" style="z-index: <?= 1000 - $index ?>">
            <img src="/uploads/<?= $dog['image'] ?>" alt="<?= $dog['name'] ?>">
            <div class="info">
                <h2><?= $dog['name'] ?> (<?= $dog['breed'] ?>)</h2>
                <p><?= $dog['age'] ?>years old</p>
            </div>
        </div>
    <?php endforeach; ?>
</div>
<div id="buttons">
    <button id="nope-btn">Not for me</button>
    <button id="like-btn">Like</button>
</div>

<script>
  const stack = document.querySelector("card-stack");
  const cards = Array.from(document.querySelectorAll(".dog-card"));

  const likeBtn = document.getElementById("like-btn");
  const nopeBtn = document.getElementById("nope-btn");

  function swipe(card, direction) {
      card.style.transform = `translateX(${direction === 'right' ? 500 : -500}px) rotate(${direction === 'right' ? 30 : 30}deg)`;
      card.style.opacity = 0;

      const dogId = card.dataset.dogId;

      setTimeout(() => {
          card.remove();
          sendLike(direction === 'right', dogId);
          refreshStack();
      }, 250);
  }

  function refreshStack() {
      const newCards = document.querySelectorAll(".dog-card");

      newCards.forEach((c, i) => {
          c.style.zIndex = 1000 - i;
          c.style.transform = "scale(1";
      });
  }

  function sendLike(like, dogId) {
      fetch(`/like.php` {
          method: "POST",
              headers: {'Content-Type': 'application/x-www-form-urlencoded'},
          body: `like=${like}&dog_id=${dogId}`
      });
  }

  likeBtn.addEventListener("click", () => {
      const card = document.querySelector(".dog-card:last-child");
      swipe(card, 'right');
  });

  nopeBtn.addEventListener("click", () => {
      const card = document.querySelector(".dog-card:last-child");
      swipe(card, 'left');
  });




























</script>
</div>
</body>
</html>