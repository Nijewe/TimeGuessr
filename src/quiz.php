<?php
require_once '../db/db.php';

// si pas de partie en cours on en démarre une
if (!isset($_SESSION['images'])) {
    $db = getDB();
    // ST_X = longitude, ST_Y = latitude avec SRID 4326
    $req = $db->query('SELECT id, path, correct_year, ST_Y(position) AS lat, ST_X(position) AS lng, info FROM Images ORDER BY RAND() LIMIT 5');
    $images = $req->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['images'] = $images;
    $_SESSION['round'] = 0;
    $_SESSION['scores'] = [];
}

$round = $_SESSION['round'];

if ($round >= 5) {
    header('Location: index.php?page=end');
    exit;
}

$img = $_SESSION['images'][$round];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TimeGuessr - Manche <?= $round + 1 ?>/5</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="topbar">
        <span class="logo-small">TimeGuessr</span>
        <span>Manche <?= $round + 1 ?> / 5</span>
    </div>

    <div class="game-container">
        <div class="photo-section">
            <img src="<?= htmlspecialchars($img['path']) ?>" alt="photo a deviner">
        </div>

        <div class="answer-section">
            <h2>Où et quand cette photo a-t-elle été prise ?</h2>

            <form action="index.php?page=answer" method="POST">

                <div class="input-group">
                    <label for="year">En quelle année ?</label><br>
                    <input type="number" name="year" id="year" placeholder="ex: 1965" min="1826" max="2025" required>
                </div>

                <div class="map-group">
                    <p>Cliquez sur la carte pour choisir l'emplacement :</p>
                    <div id="map"></div>
                    <input type="hidden" name="lat" id="lat">
                    <input type="hidden" name="lng" id="lng">
                    <p id="pos-display" style="font-size:0.85rem; color:#666;">Aucune position choisie</p>
                </div>

                <button type="submit" class="btn-submit" id="btn-submit" disabled>Valider</button>

            </form>
        </div>
    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var map = L.map('map').setView([20, 0], 2);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        var marker = null;

        map.on('click', function(e) {
            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            document.getElementById('lat').value = e.latlng.lat.toFixed(5);
            document.getElementById('lng').value = e.latlng.lng.toFixed(5);
            document.getElementById('pos-display').textContent = 'Position : ' + e.latlng.lat.toFixed(3) + ', ' + e.latlng.lng.toFixed(3);

            checkForm();
        });

        document.getElementById('year').addEventListener('input', checkForm);

        function checkForm() {
            var year = document.getElementById('year').value;
            var lat = document.getElementById('lat').value;
            if (year && lat) {
                document.getElementById('btn-submit').disabled = false;
            }
        }
    </script>
</body>
</html>
