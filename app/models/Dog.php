<?php
require_once __DIR__ . '/../core/Database.php';

class Dog {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    public function create($userId, $name, $breed, $age, $description, $image) {
        $stmt = $this->db->prepare(
            "INSERT INTO dogs (user_id, name, breed, age, description, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");

        return $stmt->execute([
            $userId,
            $name,
            $breed,
            $age,
            $description,
            $image
        ]);
    }

    public function getAll() {
        $stmt = $this->db->query("
        SELECT dogs.*, users.username
        FROM dogs
        JOIN users ON dogs.user_id = users.id
        ORDER BY dogs.id DESC
        ");

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getByUser($userId) {
        $stmt = $this->db->prepare("
        SELECT * FROM dogs WHERE user_id = ?
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM dogs WHERE id = ?");
        return $stmt->execute([$id]);
    }
}