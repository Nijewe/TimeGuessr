<?php
// on remet la session a zero si on revient a l'accueil
session_unset();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>TimeGuessr</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Abril+Fatface&family=VT323&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/css/home.css">
</head>
<body>
    <div id="hero">
        <h1 id="logo">TimeGuessr</h1>
        <p>Devinez où et quand la photo a été prise !</p>
    </div>

    <div id="btn-container">
        <a href="index.php?page=quiz">
            <button class="btn-play">
                &#9658; JOUER
            </button>
        </a>
        <p style="color: grey; font-size: 0.9rem;">5 manches - Score max : 50 000 pts</p>
    </div>
</body>
</html>
