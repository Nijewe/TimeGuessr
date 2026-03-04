<?php
// connexion a la base de données
function getDB() {
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=time_guessr;charset=utf8', 'dev', 'Qho_8urhk++');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die('Erreur de connexion : ' . $e->getMessage());
    }
}
