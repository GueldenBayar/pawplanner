<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';

$controller = new PlaymatchController();

$myUserId = $_POST['user_id'] ?? $_SESSION['user_id'];
$likedUserId = $_POST['user_id'];
$likedDogId = $_POST['dog_id'];

$isMatch = $controller->like($myUserId, $likedUserId, $likedDogId);

if ($isMatch) {
    header("Location: match.php?dog_id=" . $likedDogId);
    exit;
}

header("Location: playmatch.php?match=0");
exit;


