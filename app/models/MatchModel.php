<?php
class MatchModel {
   private $db;

   public function __construct() {
       $this->db = Database::connect();
   }

   public function getMatchesForUser($currentUserId) {
       // Match holen und zwei Mal dogs Tabelle joinen
       $sql = "
            SELECT 
                m.id as match_id,
                d1.name AS myDogName,
                d1.image AS myDogImg,
                d2.name AS otherDogName,
                d2.image AS otherDogImg
            FROM matches m 
            LEFT JOIN dogs d2 ON (d2.user_id = m.user1_id OR d2.user_id = m.user2_id)

            WHERE m.user1_id = ? OR m.user2_id = ?
            ORDER BY m.created_at DESC
       ";

       $stmt = $this->db->prepare($sql);
        // ID 4x übergeben für die Platzhalter
       $stmt->execute([$currentUserId, $currentUserId, $currentUserId, $currentUserId]);

       return $stmt->fetchAll(PDO::FETCH_ASSOC);
   }
}