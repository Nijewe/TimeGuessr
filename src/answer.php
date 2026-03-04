<?php
require_once '../db/db.php';

if (!isset($_SESSION['images'])) {
    header('Location: index.php?page=home');
    exit;
}

// validation des inputs
$year = filter_input(INPUT_POST, 'year', FILTER_VALIDATE_INT);
$lat  = filter_input(INPUT_POST, 'lat',  FILTER_VALIDATE_FLOAT);
$lng  = filter_input(INPUT_POST, 'lng',  FILTER_VALIDATE_FLOAT);

if (!$year || !$lat || !$lng) {
    // retour au quiz si données manquantes
    header('Location: index.php?page=quiz');
    exit;
}

$round = $_SESSION['round'];
$img   = $_SESSION['images'][$round];

$correct_year = (int) $img['correct_year'];
$correct_lat  = (float) $img['lat'];
$correct_lng  = (float) $img['lng'];

// calcul du score année
$diff_year  = abs($year - $correct_year);
$score_year = (int) round(5000 * max(0, 1 - $diff_year / 50));

// calcul distance avec haversine (trouvé sur stackoverflow)
function distance($lat1, $lng1, $lat2, $lng2) {
    $R = 6371;
    $dLat = deg2rad($lat2 - $lat1);
    $dLng = deg2rad($lng2 - $lng1);
    $a = sin($dLat/2) * sin($dLat/2) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * sin($dLng/2) * sin($dLng/2);
    $c = 2 * atan2(sqrt($a), sqrt(1-$a));
    return $R * $c;
}

$dist_km    = distance($lat, $lng, $correct_lat, $correct_lng);
$score_geo  = (int) round(5000 * max(0, 1 - $dist_km / 5000));
$score_total = $score_year + $score_geo;

// sauvegarde en BDD (bonus historique)
try {
    $db = getDB();
    $stmt = $db->prepare('INSERT INTO Scores (image_id, session_id, guessed_year, guessed_lat, guessed_lng, year_score, geo_score, total_score) VALUES (?, ?, ?, ?, ?, ?, ?, ?)');
    $stmt->execute([$img['id'], session_id(), $year, $lat, $lng, $score_year, $score_geo, $score_total]);
} catch (Exception $e) {
    // pas bloquant si ça marche pas
    error_log($e->getMessage());
}

// on sauvegarde le score en session
$_SESSION['scores'][] = [
    'year'         => $year,
    'lat'          => $lat,
    'lng'          => $lng,
    'correct_year' => $correct_year,
    'correct_lat'  => $correct_lat,
    'correct_lng'  => $correct_lng,
    'diff_year'    => $diff_year,
    'dist_km'      => round($dist_km),
    'score_year'   => $score_year,
    'score_geo'    => $score_geo,
    'total'        => $score_total,
    'image_path'   => $img['path'],
    'info'         => $img['info'],
];
$_SESSION['round']++;

$next = ($_SESSION['round'] >= 5) ? 'end' : 'quiz';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TimeGuessr - Résultat manche <?= $round + 1 ?>/5</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="topbar">
        <span class="logo-small">TimeGuessr</span>
        <span>Résultat manche <?= $round + 1 ?> / 5</span>
    </div>

    <div class="game-container">

        <div class="photo-section">
            <img src="<?= htmlspecialchars($img['path']) ?>" alt="photo de la manche">
            <?php if ($img['info']): ?>
                <p style="font-size:0.85rem; color:grey; margin-top:8px;"><?= htmlspecialchars($img['info']) ?></p>
            <?php endif; ?>
        </div>

        <div class="result-section">
            <h2>Vos résultats</h2>

            <div class="result-cards">
                <div class="result-card">
                    <h3>📅 Année</h3>
                    <p>Votre réponse : <strong><?= $year ?></strong></p>
                    <p>Bonne réponse : <strong><?= $correct_year ?></strong></p>
                    <p><?= $diff_year ?> an(s) d'écart</p>
                    <p class="pts">+<?= number_format($score_year, 0, ',', ' ') ?> pts</p>
                </div>

                <div class="result-card">
                    <h3>📍 Localisation</h3>
                    <p>Distance : <strong><?= number_format(round($dist_km), 0, ',', ' ') ?> km</strong></p>
                    <p class="pts">+<?= number_format($score_geo, 0, ',', ' ') ?> pts</p>
                </div>
            </div>

            <p class="score-manche">Score manche : <strong><?= number_format($score_total, 0, ',', ' ') ?> / 10 000</strong></p>
            <p>Score total : <strong><?= number_format(array_sum(array_column($_SESSION['scores'], 'total')), 0, ',', ' ') ?></strong></p>
        </div>

        <div class="result-map-section">
            <p style="margin-bottom: 8px;">Votre position (rouge) vs la bonne réponse (vert) :</p>
            <div id="result-map"></div>
        </div>

        <div style="text-align:center; margin-top: 1.5rem;">
            <a href="index.php?page=<?= $next ?>">
                <button class="btn-submit">
                    <?= $next === 'end' ? '🏆 Voir le score final' : 'Manche suivante ➡️' ?>
                </button>
            </a>
        </div>

    </div>

    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script>
        var guessLat  = <?= (float)$lat ?>;
        var guessLng  = <?= (float)$lng ?>;
        var correctLat = <?= (float)$correct_lat ?>;
        var correctLng = <?= (float)$correct_lng ?>;

        var midLat = (guessLat + correctLat) / 2;
        var midLng = (guessLng + correctLng) / 2;

        var map = L.map('result-map').setView([midLat, midLng], 3);
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '© OpenStreetMap'
        }).addTo(map);

        // marqueur rouge = joueur
        var redIcon = L.divIcon({ html: '<div style="background:red;width:14px;height:14px;border-radius:50%;border:2px solid white"></div>', iconSize:[14,14], iconAnchor:[7,7] });
        L.marker([guessLat, guessLng], {icon: redIcon}).addTo(map).bindPopup('Votre réponse');

        // marqueur vert = bonne réponse
        var greenIcon = L.divIcon({ html: '<div style="background:green;width:14px;height:14px;border-radius:50%;border:2px solid white"></div>', iconSize:[14,14], iconAnchor:[7,7] });
        L.marker([correctLat, correctLng], {icon: greenIcon}).addTo(map).bindPopup('Bonne localisation').openPopup();

        L.polyline([[guessLat, guessLng], [correctLat, correctLng]], {color: 'red', dashArray: '5,5'}).addTo(map);

        map.fitBounds([[guessLat, guessLng], [correctLat, correctLng]], {padding: [30, 30]});
    </script>
</body>
</html>
