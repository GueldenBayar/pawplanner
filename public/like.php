<?php
session_start();
require_once __DIR__ . '/../app/controllers/PlaymatchController.php';

// wir antworten immer mit JSON damit JS es versteht
header('Content-Type: application/json');

//Prüfen, ob User eingeloggt ist
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Nicht eingeloggt']);
    exit;
}

// Prüfen, ob Daten da sind
if (isset($_POST['dog_id']) && isset($_POST['user_id'])) {

    $controller = new PlaymatchController();

    $myUserId= $_SESSION['user_id'];

    $likedUserId = (int)$_POST['user_id'];
    $likedDogId = (int)$_POST['dog_id'];

    // Like speichern / prüfen
    $isMatch = $controller->like($myUserId, $likedUserId, $likedDogId);

    if ($isMatch) {
        // Wir senden JSON zurück: Es ist ein Match!
        echo json_encode([
            'status' => 'match',
            'dog_id' => $likedDogId
        ]);
    } else {
        // wir senden JSON zurück: "Erfolg, aber kein Match!"
        echo json_encode(['status' => 'success']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'Fehlende Daten']);
}


