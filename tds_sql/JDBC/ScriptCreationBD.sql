DROP TABLE Personnes CASCADE CONSTRAINTS;
DROP SEQUENCE SeqAdh;

CREATE TABLE Personnes
(codePersonne NUMBER, nomPersonne VARCHAR(20), prenomPersonne VARCHAR(20), nationalitePersonne VARCHAR(20), agePersonne NUMBER,
 CONSTRAINT pk_Personnes PRIMARY KEY (codePersonne),
 CONSTRAINT ck_agePersonne_Personne CHECK (agePersonne >= 0 AND agePersonne <= 120),
 CONSTRAINT nn_nomPersonne_Personnes CHECK (nomPersonne IS NOT NULL)
);

CREATE OR REPLACE FUNCTION ageMoyenParNationalite (p_nationalite IN Personnes.nationalitePersonne%TYPE) RETURN NUMBER IS
   v_nb NUMBER;
BEGIN
	IF p_nationalite IS NULL THEN
		SELECT ROUND(AVG(agePersonne),2) INTO v_nb
		FROM Personnes
		WHERE nationalitePersonne IS NULL;
	ELSE
	   SELECT ROUND(AVG(agePersonne),2) INTO v_nb
	   FROM Personnes
	   WHERE nationalitePersonne = p_nationalite;
	END IF;
   RETURN v_nb;
END;   
     
/


CREATE SEQUENCE SeqAdh;

INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Zétofrais', 'Mélanie', 'Français', 28);
INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Bricot', 'Juda', 'Français', 46);
INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Némard', 'Jean', 'Belge', 33);
INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Zeblouze', 'Agathe', 'Catalan', NULL);
INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Ouzy', 'Jacques', 'Français', 12);
INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Deuf', 'John', 'Français', NULL);
INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Titouplin', NULL, 'Catalan', 0);
INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Croque', 'Odile', 'Nimois', 99);
INSERT INTO Personnes (codePersonne, nomPersonne, prenomPersonne, nationalitePersonne, agePersonne) VALUES (SeqAdh.NEXTVAL, 'Gator', 'Ali', NULL, 54);

COMMIT;