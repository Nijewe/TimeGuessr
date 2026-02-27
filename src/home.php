<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <title>Time Guesser</title>
        <link rel="stylesheet" href="../public/css/styles.css">
    </head>

    <body class="global-page">
        <div class="game-container">
            <section class="photo-section">
                <h1>Où et quand a été prise cette photo ?</h1>
                <div class="photo-frame">
                    <!--<img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d4/Paris_Eiffel_Tower_1889.jpg/440px-Paris_Eiffel_Tower_1889.jpg" alt="Photo historique">-->
                </div>
            </section>

            <section class="answer-section">
                <form action="check.php" method="POST">
                
                    <div class="input-group">
                        <label for="year">En quelle année ?</label>
                        <input type="number" name="year" id="year" placeholder="Ex: 1920" required>
                    </div>

                    <div class="map-group">
                        <p>Cliquez sur la carte pour valider votre position :</p>
                        <input type="image" src="https://upload.wikimedia.org/wikipedia/commons/8/80/World_map_-_low_resolution.jpg" name="coords" class="map-submit">
                    </div>

                </form>
            </section>
        </div>
    </body>
</html>';

