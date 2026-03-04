<?php
if (!isset($_SESSION['scores']) || count($_SESSION['scores']) === 0) {
    header('Location: index.php?page=home');
    exit;
}

$scores = $_SESSION['scores'];
$total  = array_sum(array_column($scores, 'total'));

// nettoie la session
session_unset();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TimeGuessr - Fin de partie</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/styles.css">
</head>
<body>
    <div class="topbar">
        <span class="logo-small">TimeGuessr</span>
        <span>Fin de partie</span>
    </div>

    <div class="game-container">
        <h1 style="text-align:center; margin-bottom: 1rem;">Partie terminée !</h1>

        <div class="end-score-box">
            <div class="big-score"><?= number_format($total, 0, ',', ' ') ?></div>
            <div>/ 50 000 points</div>
            <div style="margin-top: 0.5rem;">
                <?php
                $pct = $total / 50000;
                echo 'Good game !';
                ?>
            </div>
        </div>

        <h2 style="margin: 1.5rem 0 1rem;">Récapitulatif</h2>

        <div class="recap-grid">
            <?php foreach ($scores as $i => $s): ?>
            <div class="recap-card">
                <p><strong>Manche <?= $i + 1 ?></strong></p>
                <img src="<?= htmlspecialchars($s['image_path']) ?>" alt="manche <?= $i+1 ?>">
                <p>Année : <?= $s['year'] ?> (réponse : <?= $s['correct_year'] ?>)</p>
                <p>Distance : <?= number_format($s['dist_km'], 0, ',', ' ') ?> km</p>
                <p><strong><?= number_format($s['total'], 0, ',', ' ') ?> pts</strong></p>
            </div>
            <?php endforeach; ?>
        </div>

        <div style="text-align:center; margin-top: 2rem;">
            <a href="index.php?page=home">
                <button class="btn-play">&#9658; Rejouer</button>
            </a>
        </div>
    </div>
</body>
</html>
