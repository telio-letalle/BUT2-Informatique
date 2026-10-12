-- Deuxième partie – Gestion des contraintes du schéma relationnel avec le LDD SQL :

-- 5)
ALTER TABLE Travailler DROP CONSTRAINT pk_travailler;
ALTER TABLE Travailler ADD CONSTRAINT pk_travailler PRIMARY KEY (codeSalarie, dateTravail);

-- 6)
ALTER TABLE Equipes DROP CONSTRAINT fk_Equipes_codeSalarieChef;
ALTER TABLE Equipes ADD CONSTRAINT fk_Equipes FOREIGN KEY (codeEquipe, codeSalarieChef) REFERENCES EtreAffecte(codeEquipe, codeSalarie);

-- 7)
