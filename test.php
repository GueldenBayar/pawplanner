<?php
require_once __DIR__ . '/app/models/Dog.php';

$dog = new Dog();
$dogs = $dog->getAll();

echo "<pre>";
print_r($dogs);