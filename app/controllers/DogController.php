<?php
require_once dirname(__DIR__) . '/models/Dog.php';

class DogController {
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $breed = trim($_POST['breed']);
            $age = (int)$_POST['age'];
            $description = trim($_POST['description']);
            $userId = $_SESSION['user_id'];

            if (!$name || !$breed  || !$age) {
                die("Bitte alle Pflichtfelder ausfüllen!");
            }

            $dog = new Dog();
            $dog->create($userId, $name, $breed, $age, $description);

            header("Location: my_dogs.php");
            exit;
        }
    }

    public function delete($id) {
        $dog = new Dog();
        $dog->delete($id);

        header("Location: my_dogs.php");
        exit;
    }
}