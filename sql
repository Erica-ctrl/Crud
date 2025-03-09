CREATE DATABASE IF NOT EXISTS emploi_du_temps;

USE emploi_du_temps;

CREATE TABLE IF NOT EXISTS horaires (
    id INT AUTO_INCREMENT PRIMARY KEY,
    jour VARCHAR(50) NOT NULL,
    matiere VARCHAR(100) NOT NULL,
    date DATE NOT NULL,
    heure_debut TIME NOT NULL,
    heure_fin TIME NOT NULL
);