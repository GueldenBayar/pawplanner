<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';

$controller = new PlaymatchController();

$myUserId = $_SESSION['user_id'];
$likedUserId = $_GET['user_id'];
$likedUserId = $_GET['dog_id'];

$isMatch = $controller->like($myUserId, $likedUserId, $likedDogId);

if ($isMatch) {
    header("Location: match.php?dog_id=" . $likedDogId);
    exit;
}

header("Location: playmatch.php?match=0");
exit;


