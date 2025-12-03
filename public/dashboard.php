<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<h2>Willkommen, <?php echo $_SESSION['username']; ?> 🐾 </h2>

<ul>
    <li><a href="dashboard.php">Dashboard</a></li>
    <li><a href="add_dog.php">Hund hinzufügen</a></li>
    <li><a href="my_dogs.php">My Dogs</a></li>
    <li><a href="logout.php">Logout</a></li>
</ul>