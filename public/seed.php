<?php
// Datei: public/seed.php
require_once __DIR__ . '/../app/core/Database.php';

echo "<h1>Starte Seeding... 🚀</h1>";

try {
    $db = Database::connect();

    // 1. Tabellen leeren (Reihenfolge wegen Foreign Keys wichtig!)
    // Wir schalten kurz die FK-Checks aus, um alles radikal zu löschen
    $db->exec("SET FOREIGN_KEY_CHECKS = 0");
    $db->exec("TRUNCATE TABLE matches");
    $db->exec("TRUNCATE TABLE likes");
    $db->exec("TRUNCATE TABLE dogs");
    $db->exec("TRUNCATE TABLE users");
    $db->exec("SET FOREIGN_KEY_CHECKS = 1");

    echo "✅ Alte Daten gelöscht.<br>";

    // 2. Dummy User erstellen
    // Passwort für alle ist '123456'
    $password = password_hash('123456', PASSWORD_DEFAULT);

    $users = ['Anna', 'Ben', 'Chris', 'Julia', 'Mike', 'Sarah', 'Tom', 'Lisa'];
    $userIds = [];

    $stmtUser = $db->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");

    foreach ($users as $name) {
        $email = strtolower($name) . "@example.com";
        $stmtUser->execute([$name, $email, $password]);
        $userIds[] = $db->lastInsertId(); // Wir merken uns die ID
        echo "👤 User $name erstellt.<br>";
    }

    // 3. Bilder aus dem Ordner lesen
    $uploadDir = __DIR__ . '/uploads';
    $files = scandir($uploadDir);

    // Nur echte Bilddateien filtern (kein "." oder "..")
    $images = array_filter($files, function($file) {
        return in_array(pathinfo($file, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif', 'webp']);
    });

    if (empty($images)) {
        die("❌ Keine Bilder im Ordner 'public/uploads' gefunden! Bitte leg erst Bilder rein.");
    }

    // 4. Hunde erstellen basierend auf den Bildern
    $dogNames = ['Luna', 'Bella', 'Charlie', 'Milo', 'Buddy', 'Rocky', 'Leo', 'Nala', 'Simba', 'Jack'];
    $breeds = ['Golden Retriever', 'Labrador', 'Beagle', 'Bulldog', 'Poodle', 'Shepherd', 'Husky', 'Mix'];
    $descriptions = [
        'Liebt lange Spaziergänge.', 'Ist sehr verspielt.', 'Mag Leckerlis über alles.',
        'Braucht viel Auslauf.', 'Ist ein bisschen schüchtern.', 'Der beste Freund des Menschen.'
    ];

    $stmtDog = $db->prepare("INSERT INTO dogs (user_id, name, breed, age, description, image) VALUES (?, ?, ?, ?, ?, ?)");

    $count = 0;
    foreach ($images as $imageFile) {
        // Zufällige Daten würfeln
        $randomUser = $userIds[array_rand($userIds)];
        $randomName = $dogNames[array_rand($dogNames)];
        $randomBreed = $breeds[array_rand($breeds)];
        $randomAge = rand(1, 15);
        $randomDesc = $descriptions[array_rand($descriptions)];

        $stmtDog->execute([
            $randomUser,
            $randomName,
            $randomBreed,
            $randomAge,
            $randomDesc,
            $imageFile // Hier nehmen wir den echten Dateinamen aus dem Ordner!
        ]);
        $count++;
    }

    echo "<br>✅ <b>Fertig! $count Hunde wurden erfolgreich in die Datenbank eingetragen.</b><br>";
    echo "<br>👉 <a href='login.php'>Jetzt einloggen</a> (Email: anna@example.com / Passwort: 123456)";

} catch (PDOException $e) {
    die("❌ Fehler beim Seeden: " . $e->getMessage());
}