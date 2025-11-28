<?php
require_once __DIR__ . '/../core/Database.php';

class User {
    private $db;

    public function contruct() {
        $this->db = Database::connect();
    }

    public function create($username, $email, $password) {
        $hashed = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $this->db->prepare("
        INSERT INTO users(username, email, password)
        VALUES (?, ?, ?)
        ");

        return $stmt->execute([$username, $email, $hashed]);
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}