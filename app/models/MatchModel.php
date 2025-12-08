<?php
class MatchModel {
    public function getMatchesForUser($userId) {
        $db = Database::getInstance();

        $sql = "
            SELECT
                m.id,
                d1.name AS myDogName,
                d1.image AS myDogImg,
                d2.name AS otherDogName,
                d2.image AS otherDogImg
            FROM matches m 
            JOIN dogs d1 ON d1.id = m.my_dog_id
            JOIN dogs d2 ON d2.id = m.other_dog_id
            WHERE m.user_id = ?
            ORDER BY m.created_at DESC
        ";

        $stmt = $db->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}