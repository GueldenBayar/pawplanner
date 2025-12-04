<?php
session_start();

require_once __DIR__ . '/../models/Dog.php';
require_once __DIR__ . '/../models/Like.php';
require_once __DIR__ . '/../models/Match.php';

class PlaymatchController {
    public function swipe() {
        $dogModel = new Dog();
        return $dogModel->getAll();
    }

    public function like() {
        $fromUserId = $_SESSION['user_id'];
        $toUserId = $_POST['to_user_id'];

        $like = new Like();
        $like->addLike($fromUserId, $toUserId);

        //Gegenseitiger Like
        if ($like->checkMutualLike($fromUserId, $toUserId)) {
            $match = new MatchModel();
            $match->createMatch($fromUserId, $toUserId);
        }

        header('Location: playmatch.php');
        exit;
    }
}