<?php
require_once __DIR__ . '/../models/Dog.php';
require_once __DIR__ . '/../core/Database.php';

class PlaymatchController {

    public function swipe() {
        $dogModel = new Dog();
        return $dogModel->getAll();
    }
    // Für Likes and Matches
    public function like() {
        if (!isset($_SESSION['user_id'])) {
            die("Nicht eingeloggt!");
        }

        if(!isset($_GET['id'])) {
            die("Kein Ziel-User übergeben!");
        }

        $from = $_SESSION['user_id'];
        $to = $_GET['id'];

        $db = Database::connect();


        // Like speichern
        $stmt = $db->prepare("
            INSERT INTO likes (from_user_id, to_user_id)
            VALUES (?, ?)
        ");
        $stmt->execute([$from, $to]);

        //Prüfen, ob Gegenlike existiert
        $check = $db->prepare("
            SELECT * FROM likes
            WHERE from_user_id = ? AND to_user_id = ?
        ");
        $check->execute([$to, $from]);

        // Wenn ja, Match eintragen
        if ($check->rowCount() > 0) {
            $match = $db->prepare("
                INSERT INTO matches (user1_id, user2_id)
                VALUES (?, ?)
            ");
            $match->execute([$from, $to]);

            header("Location: match.php?id=" . $to);
            exit;
        }
        header("Location: playmatch.php");
        exit;
    }

    public function getDogOwnerInfo($userId) {
        $db = Database::connect();

        // Einen Hund + Besitzer laden
        $stmt = $db->prepare("
            SELECT dogs.*, users.username
            FROM dogs
            JOIN users ON dogs.user_id = users.id
            WHERE users.id = ?
            LIMIT 1
        ");
        $stmt->execute([$userId]);

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}