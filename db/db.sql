-- 1. Création de la Base de Données
CREATE DATABASE IF NOT EXISTS time_guessr CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci;
USE time_guessr;


-- 2. Création de Table
CREATE TABLE Images(
    id INT AUTO_INCREMENT PRIMARY KEY,
    path VARCHAR(300),
    position POINT NOT NULL SRID 4326,
    correct_year SMALLINT,
    info TEXT,
    hint TEXT,
    SPATIAL INDEX (position)
    )ENGINE = InnoDB;


-- 3. Assignation des Droits
CREATE USER IF NOT EXISTS 'dev'@'localhost' IDENTIFIED BY 'Qho_8urhk++';
GRANT ALL ON time_guessr.* TO 'dev'@'localhost';
FLUSH PRIVILEGES;