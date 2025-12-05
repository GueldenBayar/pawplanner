<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';

$controller = new PlaymatchController();

$myUserId = $_SESSION['user_id'];
$likedUserId = $_GET['id'];

// Like speichern
$controller->like($myUserId, $likedUserId);

// Prüfen, ob Match vorhanden
if ($controller->hasMatch($myUserId, $likedUserId)) {
    header("Location: match.php?id=" . $likedUserId);
    exit;
}

// kein Match = nächste Karte
header("Location: playmatch.php");
exit;
