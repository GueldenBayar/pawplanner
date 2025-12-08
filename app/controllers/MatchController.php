<?php
class MatchController {
    public function index() {
        session_start();
        $userId = $_SESSION['user_id'];
        $matches = (new MatchModel())->getMatchesForUser($userId);

        include '../app/view/matches.php';
    }
}