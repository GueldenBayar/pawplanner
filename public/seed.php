<?php

// public/seed.php
// Einmal ausführen: erzeugt 50 User + je 2 Hunde inkl. Bilder

require_once __DIR__ . '/../app/core/Database.php';

// SETTINGS
$NUM_USERS = 50;
$DOGS_PER_USER = 2;

// Dummy Daten
$names = ["Bella", "Charlie", "Max", "Lucy", "Cooper", "Rocky", "Daisy", "Milo", "Luna", "Buddy", "Oscar", "Lotte", "Nala", "Kaya", "Leo", "Snoopy", "Maya", "Finn", "Rex", "Sam"];
$breeds = ["Labrador", "Golden Retriever", "Beagle", "Border Collie", "Chihuahua", "Pug", "Dachshund", "Bulldog", "Terrier", "Shiba Inu"];

// Upload-Ordner zuverlässig bestimmen
$uploadDir = __DIR__ . '/uploads/dogs/';
if (!is_dir($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}

// Prüfen ob beschreibbar
if (!is_writable($uploadDir)) {
    die("<pre>Upload-Ordner ist NICHT beschreibbar: $uploadDir</pre>");
}

$db = Database::connect();

// Sicherheit: verhindern, dass 1000 User generiert werden
$stmtCount = $db->query("SELECT COUNT(*) AS cnt FROM users");
$count = (int) $stmtCount->fetch(PDO::FETCH_ASSOC)['cnt'];
if ($count > 100) {
    die("<pre>Abbruch: bereits >100 User vorhanden.</pre>");
}

echo "<pre>Starte Seeder...\n------------------------------------------\n</pre>";

// Hilfsfunktion: robuste Bild-Downloader
function downloadImage($url, $destPath)
{
    // 1. Versuch via cURL
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 8);
    $data = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($data !== false && strlen($data) > 100) {
        file_put_contents($destPath, $data);
        return true;
    }

    // 2. Versuch via file_get_contents
    $data = @file_get_contents($url);
    if ($data !== false && strlen($data) > 100) {
        file_put_contents($destPath, $data);
        return true;
    }

    return false;
}

// Platzhalter ohne GD (reines Textbild)
function createPlaceholderImage($destPath)
{
    $text = "No Image";
    $w = 640;
    $h = 480;

    // simples graues Base64-JPEG
    $placeholder = base64_decode(
        "..." // so oder via local fallback, wir generieren unten eine generische Datei
    );

    // Minimalbild erzeugen:
    $img = "Placeholder - no image available";
    file_put_contents($destPath, $img);
}

// Hauptloop
for ($i = 1; $i <= $NUM_USERS; $i++) {

    $username = "user" . str_pad($i, 3, '0', STR_PAD_LEFT);
    $email = $username . "@example.com";
    $passwordHash = password_hash("password", PASSWORD_DEFAULT);

    // Nutzer anlegen
    $stmt = $db->prepare("INSERT IGNORE INTO users (username, email, password, created_at) VALUES (?, ?, ?, NOW())");
    $stmt->execute([$username, $email, $passwordHash]);

    $userId = $db->lastInsertId();

    if ($userId == 0) {
        // Falls existiert
        $stmtGet = $db->prepare("SELECT id FROM users WHERE email = ?");
        $stmtGet->execute([$email]);
        $userId = $stmtGet->fetchColumn();
        echo "<pre>User $username existiert bereits (ID: $userId). Checking dogs...</pre>";
        // continue; // MOVED: Now checking dogs below instead of skipping entirely
    }

    echo "<pre>Erstellt User: $username (ID $userId)</pre>";

    // Check existing dogs
    $stmtCountDogs = $db->prepare("SELECT COUNT(*) FROM dogs WHERE user_id = ?");
    $stmtCountDogs->execute([$userId]);
    $currentDogs = (int) $stmtCountDogs->fetchColumn();

    $dogsNeeded = $DOGS_PER_USER - $currentDogs;

    if ($dogsNeeded <= 0) {
        echo "<pre>   -> Bereits $currentDogs Hunde vorhanden. Skipping.</pre>";
        continue;
    }

    // Hunde anlegen
    for ($d = 1; $d <= $dogsNeeded; $d++) {
        $dogName = $names[array_rand($names)] . "_$d";
        $breed = $breeds[array_rand($breeds)];
        $age = rand(1, 12);
        $description = "Friendly " . strtolower($breed);

        // Bild-URL: Picsum ist stabiler als placedog
        $imageUrl = "https://picsum.photos/640/480?random=" . mt_rand(1, 999999);
        $fileName = uniqid("dog_", true) . ".jpg";
        $filePath = $uploadDir . $fileName;

        $success = downloadImage($imageUrl, $filePath);
        if (!$success) {
            // Platzhalter
            file_put_contents($filePath, "Placeholder image");
        }

        $stmtDog = $db->prepare("
            INSERT INTO dogs (user_id, name, breed, age, description, image)
            VALUES (?, ?, ?, ?, ?, ?)
        ");
        $stmtDog->execute([$userId, $dogName, $breed, $age, $description, $fileName]);

        $dogId = $db->lastInsertId();
        echo "<pre>   → Hund erstellt: $dogName (ID: $dogId) | Bild: $fileName</pre>";
    }
}

echo "<pre>\n------------------------------------------\nFertig! $NUM_USERS User mit je $DOGS_PER_USER Hunden erzeugt.\n</pre>";
