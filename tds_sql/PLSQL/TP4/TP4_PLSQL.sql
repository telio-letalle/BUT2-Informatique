-- Deuxième partie – Gestion des contraintes du schéma relationnel avec le LDD SQL :

-- 5)
ALTER TABLE Travailler DROP CONSTRAINT pk_travailler;
ALTER TABLE Travailler ADD CONSTRAINT pk_travailler PRIMARY KEY (codeSalarie, dateTravail);

-- 6)
ALTER TABLE Equipes DROP CONSTRAINT fk_Equipes_codeSalarieChef;
ALTER TABLE Equipes ADD CONSTRAINT fk_Equipes FOREIGN KEY (codeEquipe, codeSalarieChef) REFERENCES EtreAffecte(codeEquipe, codeSalarie);


--Troisième partie – Gestion des contraintes avec des procédures stockées PL/SQL :

-- 7)
CREATE OR REPLACE PROCEDURE AjouterJourneeTravail (
                        p_codeSalarie Travailler.codeSalarie%TYPE,
                        p_codeProjet Travailler.codeProjet%TYPE,
                        p_dateTravail Travailler.dateTravail%TYPE) IS
BEGIN
    INSERT INTO Travailler(codeSalarie, dateTravail, codeProjet) VALUES (p_codeSalarie, p_dateTravail, p_codeProjet); 

    UPDATE Salaries SET nbTotalJourneesTravail = nbTotalJourneesTravail + 1 WHERE codeSalarie = p_codeSalarie;
END;
--CALL AjouterJourneeTravail('S2','P3', '10/01/2022');

-- 8)
CREATE OR REPLACE PROCEDURE AffecterSalarieEquipe (
                        p_codeSalarie EtreAffecte.codeSalarie%TYPE,
                        p_codeEquipe EtreAffecte.codeEquipe%TYPE) IS
    v_nbEquipes NUMBER;    
BEGIN
    SELECT COUNT(*) INTO v_nbEquipes
    FROM EtreAffecte
    WHERE codeSalarie = p_codeSalarie;

    IF v_nbEquipes >= 3
    THEN
        RAISE_APPLICATION_ERROR(-20001, 'Le salarié est déjà affecté à au moins 3 équipes');
    ELSE
        INSERT INTO EtreAffecte (codeSalarie, codeEquipe) VALUES (p_codeSalarie, p_codeEquipe);
    END IF;
END;

-- 9)
CREATE OR REPLACE PROCEDURE AjouterProjetExterne (
                        p_codeProjet ProjetsExternes.codeProjet%TYPE,
                        p_nomProjet ProjetsExternes.nomProjet%TYPE,
                        p_villeProjet ProjetsExternes.villeProjet%TYPE,
                        p_clientProjet ProjetsExternes.clientProjet%TYPE,
                        p_codeEquipe Equipes.codeEquipe%TYPE
                        ) IS
    v_nbProjets NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_nbProjets
    FROM ProjetsInternes
    WHERE codeProjet = p_codeProjet;

    IF v_nbProjets > 0
    THEN
        RAISE_APPLICATION_ERROR(-20001, 'Le projet existe déjà dans la table ProjetsInternes');
    ELSE
        INSERT INTO ProjetsExternes (codeProjet, nomProjet, villeProjet, clientProjet, codeEquipe) VALUES (p_codeProjet, p_nomProjet, p_villeProjet, p_clientProjet, p_codeEquipe);
    END IF;
END;
--CALL AjouterProjetExterne('P7'); erreur car existe dans ProjetsInternes (comme demandé)

CREATE OR REPLACE PROCEDURE AjouterProjetInterne (
                        p_codeProjet ProjetsInternes.codeProjet%TYPE,
                        p_nomProjet ProjetsInternes.nomProjet%TYPE,
                        p_serviceProjet ProjetsInternes.serviceProjet%TYPE,
                        p_codeSalarieResponsable ProjetsInternes.codeSalarieResponsable%TYPE
                        ) IS
    v_nbProjets NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_nbProjets
    FROM ProjetsExternes
    WHERE codeProjet = p_codeProjet;

    IF v_nbProjets > 0
    THEN
        RAISE_APPLICATION_ERROR(-20001, 'Le projet existe déjà dans la table ProjetsExternes');
    ELSE
        INSERT INTO ProjetsInternes (codeProjet, nomProjet, serviceProjet, codeSalarieResponsable) VALUES (p_codeProjet, p_nomProjet, p_serviceProjet, p_codeSalarieResponsable);
    END IF;
END;
-- CALL AjouterProjetInterne('P1'); erreur car existe dans ProjetsExternes (comme demandé)
-- CALL AjouterProjetInterne('P8', 'Programme de comptabilité', 'Service COMPTA', 'S9')