<?php
session_start();
require_once __DIR__ . '/../app/core/Database.php';

$from = $_SESSION['user_id'];
$to = $_GET['id'];

$db = Database::connect();

//Like speichern
$stmt = $db->prepare("INSERT INTO likes (from_user_id, to_user_id) VALUES (?, ?)");
$stmt->execute([$from, $to]);

//prüfen ob Gegenlike existiert
$check = $db->prepare("
    SELECT * FROM likes
    WHERE from_user_id = ? AND to_user_id = ?
");
$check->execute([$to, $from]);

if($check->rowCount() > 0) {
    // MATCH!
    $match = $db->prepare("
    INSERT INTO matches (user1_id, user2_id)
    VALUES (?, ?)
    ");
    $match->execute([$from, $to]);
}

header("Location: playmatch.php");
exit;