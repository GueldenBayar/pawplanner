<?php
require_once __DIR__ . '/../core/Database.php';

class Spot {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function create($userId, $lat, $lng, $type, $comment) {
        $stmt = $this->db->prepare("
            INSERT INTO spots (user_id, lat, lng, type, comment)
            VALUES (?, ?, ?, ?, ?)
        ");
        return $stmt->execute([$userId, $lat, $lng, $type, $comment]);
    }

    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM spots ORDER BY created_at DESC");
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}