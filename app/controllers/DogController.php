<?php
session_start();

require_once __DIR__ . '/../models/Dog.php';

class DogController {
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $breed = trim($_POST['breed']);
            $age = (int)$_POST['age'];
            $description = trim($_POST['description']);
            $userId = $_SESSION['user_id'];

            // Dateiupload
            $imageName = null;

            if (!empty($_FILES['image']['name'])) {
                $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
                $imageName = uniqid() . "." . $extension; // uniqid verhindert doppelte Dateinamen
                //Bild wird physisch gespeichert -> nur der Name geht in die Datenbank
                move_uploaded_file(
                    $_FILES['image']['tmp_name'],
                    __DIR__ . '/../../public/uploads/' . $imageName
                );
            }

            $dog = new Dog();
            $dog->create($userId, $name, $breed, $age, $description, $imageName);


            if (!$name || !$breed  || !$age) {
                die("Bitte alle Pflichtfelder ausfüllen!");
            }

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