CREATE TABLE utilisateur (
    loginBaseDeDonnees VARCHAR(64) PRIMARY KEY,
    nomBaseDeDonnees VARCHAR(64),
    prenomBaseDeDonnees VARCHAR(64)
) ENGINE=InnoDB
DEFAULT CHARSET=utf8
COLLATE=utf8_general_ci;

INSERT INTO utilisateur
(loginBaseDeDonnees, nomBaseDeDonnees, prenomBaseDeDonnees)
VALUES ('letallet', 'letalle', 'telio');

INSERT INTO utilisateur
(loginBaseDeDonnees, nomBaseDeDonnees, prenomBaseDeDonnees)
VALUES ('letallem', 'letalle', 'martin');