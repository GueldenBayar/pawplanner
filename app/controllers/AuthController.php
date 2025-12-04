<?php

//namespace controllers;
//use User;
//
//require_once __DIR__ . '/../models/User.php';

class AuthController
{

    public function register()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username']);
            $email = trim($_POST['email']);
            $password = trim($_POST['password']);

            if (!$username || !$email || !$password) {
                die("Die Felder sind Pflicht!");
            }

            require_once __DIR__ . '/../models/User.php';
            $user = new User();
            $user->create($username, $email, $password);

            header("Location: /pawplanner/public/login.php");
            exit;
        }
    }

    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email']);
            $password = $_POST['password'];

            require_once __DIR__ . '/../models/User.php';
            $userModel = new User();
            $user = $userModel->findByEmail($email);

            if (!$user || !password_verify($password, $user['password'])) {
                die("Login fehlgeschlagen!");
            }

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];

            header("Location: /pawplanner/public/dashboard.php");
            exit;
        }
    }

    public function logout()
    {
        session_destroy();
        header("Location: /pawplanner/public/login.php");
        exit;
    }
}