-- ============================================================
-- db.sql — Schéma de la base de données TimeGuessr
--
-- Usage :
--   mysql -u root -p < db/db.sql
--
-- Ce script est idempotent (IF NOT EXISTS partout).
-- ============================================================

CREATE DATABASE IF NOT EXISTS time_guessr
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_0900_ai_ci;

USE time_guessr;

-- -------------------------------------------------------
-- Table : Images
-- Stocke les photos du jeu avec leurs métadonnées.
--
-- Colonnes :
--   id           — Identifiant auto-incrémenté
--   path         — URL publique ou chemin relatif de l'image
--   position     — Coordonnées GPS (POINT SRID 4326, lat/lng)
--   correct_year — Année réelle de la prise de vue
--   info         — Description longue (affichée après réponse)
--   hint         — Indice optionnel affiché au joueur
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS Images (
    id           INT AUTO_INCREMENT  PRIMARY KEY,
    path         VARCHAR(300)        NOT NULL   COMMENT 'URL ou chemin de l image',
    position     POINT               NOT NULL   SRID 4326 COMMENT 'Localisation GPS',
    correct_year SMALLINT            NOT NULL   COMMENT 'Année réelle',
    info         TEXT                           COMMENT 'Description affichée après réponse',
    hint         TEXT                           COMMENT 'Indice affiché au joueur',
    SPATIAL INDEX idx_position (position)
) ENGINE = InnoDB
  COMMENT = 'Photos utilisées dans les parties';

-- -------------------------------------------------------
-- Table : Scores  (BONUS — historique des parties)
-- Garde la trace de chaque réponse pour identifier
-- les images trop faciles ou trop difficiles.
--
-- Colonnes :
--   id           — Identifiant auto-incrémenté
--   image_id     — Référence à Images.id
--   session_id   — Identifiant de session PHP
--   guessed_year — Année soumise par le joueur
--   guessed_lat  — Latitude soumise (peut être NULL)
--   guessed_lng  — Longitude soumise (peut être NULL)
--   year_score   — Points obtenus pour l'année (0–5000)
--   geo_score    — Points obtenus pour la localisation (0–5000)
--   total_score  — Somme year_score + geo_score (0–10000)
--   played_at    — Horodatage automatique
-- -------------------------------------------------------
CREATE TABLE IF NOT EXISTS Scores (
    id           INT AUTO_INCREMENT  PRIMARY KEY,
    image_id     INT                 NOT NULL,
    session_id   VARCHAR(128)        NOT NULL   COMMENT 'Session PHP du joueur',
    guessed_year SMALLINT            NOT NULL,
    guessed_lat  DECIMAL(10, 6)                 COMMENT 'Latitude devinée',
    guessed_lng  DECIMAL(10, 6)                 COMMENT 'Longitude devinée',
    year_score   INT                 NOT NULL   DEFAULT 0,
    geo_score    INT                 NOT NULL   DEFAULT 0,
    total_score  INT                 NOT NULL   DEFAULT 0,
    played_at    DATETIME            NOT NULL   DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (image_id) REFERENCES Images(id) ON DELETE CASCADE,
    INDEX idx_image   (image_id),
    INDEX idx_session (session_id)
) ENGINE = InnoDB
  COMMENT = 'Historique des scores par manche et par partie';

-- -------------------------------------------------------
-- Droits d accès
-- -------------------------------------------------------
CREATE USER IF NOT EXISTS 'dev'@'localhost' IDENTIFIED BY 'Qho_8urhk++';
GRANT ALL ON time_guessr.* TO 'dev'@'localhost';
FLUSH PRIVILEGES;
