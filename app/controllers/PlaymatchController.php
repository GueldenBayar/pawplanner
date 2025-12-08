<?php
require_once __DIR__ . '/../models/Dog.php';
require_once __DIR__ . '/../core/Database.php';

class PlaymatchController
{

    public function swipe()
    {
        $dogModel = new Dog();
        return $dogModel->getAll();
    }

    // LIKE & MATCHES HANDLING
    public function like($fromUserId, $toUserId, $dogId)
    {
        $db = Database::connect();

        //Like speichern
        $stmt = $db->prepare("
            INSERT INTO likes (from_user_id, to_user_id, dog_id)
            VALUES (?, ?, ?);
        ");
        $stmt->execute([$fromUserId, $toUserId, $dogId]);

        //Gegen-Like prüfen
        $check = $db->prepare("
            SELECT * FROM likes
            WHERE from_user_id = ? AND to_user_id = ?
        ");
        $check->execute([$toUserId, $fromUserId]);

        if ($check->rowCount() > 0) {

            //Match speichern
            $match = $db->prepare("
                INSERT INTO matches (user1_id, user2_id, dog_id)
                VALUES (?, ?, ?)
            ");
            $match->execute([$fromUserId, $toUserId, $dogId]);
            return true; // Match vorhanden
        }
        return false;
    }
        public function getDogById($id)
        {
            $db = Database::connect();
            $stmt = $db->prepare("SELECT * FROM dogs WHERE id = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(PDO::FETCH_ASSOC);
        }
}

