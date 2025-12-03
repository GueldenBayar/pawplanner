<?php
session_start();
require_once __DIR__ . '/../app/models/Spot.php';

$spotModel = new Spot();
$spots = $spotModel->getAll();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Playmap</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css"/>
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <style>
        #map {
            height: 100vh;
            width: 100%;
        }
        .spot-form {
            position: fixed;
            top: 20px;
            left: 20px;
            background: white;
            padding: 10px;
            z-index: 1000;
        }
    </style>
</head>
<body>
<div class="spot-form">
    <form method="POST" action="save_spot.php">
        <input type="hidden" name="lat" id="lat">
        <input type="hidden" name="lng" id="lng">

        <select name="type" required>
            <option value="Playdate">Playdate</option>
            <option value="Running">Running</option>
            <option value="Pooping">Pooping</option>
            <option value="Walking">Walking</option>
        </select>

        <br><br>
        <textarea name="comment" placeholder="Kommentar"></textarea><br><br>

        <button type="submit">Spot speichern</button>
    </form>
</div>

<div id="map"></div>
<script>
    //Karte starten
    var map = L.map('map').setView([48.1371, 11.5753], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
    }).addTo(map);

    var marker;

    // Klick auf Karte -> Marker setzen
    map.on('click', function(e) {
        if (marker) {
            map.removeLayer(marker);
        }

        marker = L.marker(e.latlng).addTo(map);

        document.getElementById('lat').value = e.latlng.lat;
        document.getElementById('lng').value = e.latlng.lng;
    });

    // Spots aus PHP anzeigen
    var spots = <?= json_encode($spots) ?>;

    spots.forEach(function(spot){
        L.marker([spot.lat, spot.lng])
            .addTo(map)
            .bindPopup("<b>" + spot.type + "</b><br>" + spot.comment);
    });
</script>
</body>
</html>
