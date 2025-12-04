<?php
require_once __DIR__ . '/../core/Database.php';

class Like {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    //Like speichern
    public function addLike($fromUserId, $toUserId) {
        $stmt = $this->db->prepare("
            INSERT INTO likes (from_user_id, to_user_id) 
            VALUES (?, ?)
        ");
        return $stmt->fetch();
    }
}