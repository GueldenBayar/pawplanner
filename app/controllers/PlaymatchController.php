<?php
require_once __DIR__ . '/../core/Database.php';

class PlaymatchController {


    public function like() {
        if (!isset ($_SESSION['user_id'])) {
            die("Nicht eingeloggt!");
        }

        if(!isset($_GET['id'])) {
            die("Kein Ziel-User");
        }

        $from = $_SESSION['user_id'];
        $to = $_GET['id'];

        $db = Database::connect();
        // LIKE speichern
        $stmt = $db->prepare("
            INSERT INTO likes (from_user_id, to_user_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$from, $to]);
        //Gegenlike prüfen
        $check = $db->prepare("
            SELECT * FROM likes
            WHERE from_user_id = ? AND to_user_id = ?
        ");

        $check->execute([$to, $from]);
        if($check->rowCount() > 0) {
            // MATCH!!
            $match = $db->prepare("
            INSERT INTO matches (user1_id, user2_id)
            VALUES (?, ?)
            ");
            $match->execute([$from, $to]);
        }

        header('Location: playmatch.php');
        exit;
    }
}