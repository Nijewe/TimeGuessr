
-- Création de la BD
CREATE DATABASE IF NOT EXISTS time_guessr
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_0900_ai_ci;

USE time_guessr;

-- Création des tables
CREATE TABLE IF NOT EXISTS Images (
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(300) NOT NULL,
    position POINT NOT NULL   SRID 4326,
    correct_year SMALLINT NOT NULL,
    info TEXT,
    hint TEXT,
    SPATIAL INDEX idx_position (position)
) ENGINE = InnoDB;

CREATE TABLE IF NOT EXISTS Scores (
    id INT AUTO_INCREMENT PRIMARY KEY,
    image_id INT NOT NULL,
    session_id VARCHAR(128) NOT NULL,
    guessed_year SMALLINT NOT NULL,
    guessed_lat DECIMAL(10, 6),
    guessed_lng DECIMAL(10, 6),
    year_score INT NOT NULL DEFAULT 0,
    geo_score INT NOT NULL DEFAULT 0,
    total_score INT NOT NULL DEFAULT 0,
    played_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (image_id) REFERENCES Images(id) ON DELETE CASCADE,
    INDEX idx_image (image_id),
    INDEX idx_session (session_id)
) ENGINE = InnoDB;

-- Création de l'utilisateur
CREATE USER IF NOT EXISTS 'dev'@'localhost' IDENTIFIED BY 'Qho_8urhk++';
GRANT ALL ON time_guessr.* TO 'dev'@'localhost';
FLUSH PRIVILEGES;
