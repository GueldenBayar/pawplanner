<?php
require_once __DIR__ . '/../models/Spot.php';

class SpotController {
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            session_start();

            $lat = $_POST['lat'];
            $lng = $_POST['lng'];
            $type = $_POST['type'];
            $comment = $_POST['comment'];
            $userId = $_SESSION['user_id'];

            $spot = new Spot();
            $spot->create($userId, $lat, $lng, $type, $comment);

            header("Location: playmap.php");
            exit;
        }
    }
}