<?php
require_once __DIR__ . '/../core/Database.php';

class MatchModel {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function createMatch($user1, $user2) {
        $stmt = $this->db->prepare("
            SELECT * FROM matches
            WHERE user1_id = ? OR user2_id = ?
        ");
        $stmt->execute([$userId, $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}