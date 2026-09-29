SET SERVEROUTPUT ON;

-- Première partie : Les Blocs PL/SQL

-- 1/2
DECLARE
    v_idClub Clubs.idClub%TYPE := 'C1';
    v_nbJoueurs NUMBER;
BEGIN
    SELECT COUNT(*) INTO nbJoueurs
    FROM Joueurs
    WHERE idClub = v_idClub;

    DBMS_OUTPUT.PUT_LINE('Il y a ' || v_nbJoueurs ||
     ' joueur(s) dans le club ' || v_idClub);
END;

-- 3
DECLARE
    v_idClub Clubs.idClub%TYPE := 'C1';
    v_idClubExiste Clubs.idClub%TYPE;
    v_nbJoueurs NUMBER;
BEGIN
    SELECT idClub INTO v_idClubExiste
    FROM Clubs
    WHERE idClub = v_idClub;

    SELECT COUNT(*) INTO v_nbJoueurs
    FROM Joueurs
    WHERE idClub = v_idClub;
    DBMS_OUTPUT.PUT_LINE('Il y a ' || v_nbJoueurs || 
    ' joueur(s) dans le club ' || v_idClub);
    
    EXCEPTION
    WHEN NO_DATA_FOUND THEN
    DBMS_OUTPUT.PUT_LINE('Il ny a pas de club' || v_idClub);
END;

-- 4
DECLARE
    v_idClub Clubs.idClub%TYPE := 'C1';
    v_nbCLubs NUMBER;
    v_nbJoueurs NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_nbCLubs
    FROM Clubs
    WHERE idClub = v_idClub;

    IF v_nbCLubs = 1
    THEN
        SELECT COUNT(*) INTO v_nbJoueurs
        FROM Joueurs
        WHERE idClub = v_idClub;
        DBMS_OUTPUT.PUT_LINE('Il y a ' || v_nbJoueurs ||
         ' joueur(s) dans le club ' || v_idClub);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Il n y a pas de club ' || v_idClub);
    END IF;
END;

-- 5
DECLARE
    v_idTournoi Tournois.idTournoi%TYPE := 'T1';
    v_nbTournoi NUMBER;
    rty_Tournois Tournois%ROWTYPE;
    
BEGIN
    SELECT COUNT(*) INTO v_nbTournoi
    FROM Tournois
    WHERE idTournoi = v_idTournoi;

    IF v_nbTournoi = 1
    THEN
        SELECT * INTO rty_Tournois
        FROM Tournois
        WHERE idTournoi = v_idTournoi;
        
        DBMS_OUTPUT.PUT_LINE('Identifiant du tournoi ' || ' : ' ||
        rty_Tournois.idTournoi);
        DBMS_OUTPUT.PUT_LINE('Nom du tournoi ' || ' : ' ||
        rty_Tournois.nomTournoi);
        DBMS_OUTPUT.PUT_LINE('Ville du tournoi ' || ' : ' ||
        rty_Tournois.lieuTournoi);
        DBMS_OUTPUT.PUT_LINE('Nombre de rondes du tournoi ' ||
        ' : ' || rty_Tournois.nbRondesTournoi);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Il n y a pas de tournoi ' || v_idTournoi);
    END IF;
END;


-- Deuxième partie : Les procédures et Fonctions stockées

-- 6
CREATE OR REPLACE FUNCTION nbJoueursParClub(p_idClub IN Clubs.idClub%TYPE) RETURN NUMBER IS
    v_nbCLubs NUMBER;
    v_nbJoueurs NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_nbCLubs
    FROM Clubs
    WHERE idClub = p_idClub;

    IF v_nbCLubs = 1
    THEN
        SELECT COUNT(*) INTO v_nbJoueurs
        FROM Joueurs
        WHERE idClub = p_idClub;
        RETURN v_nbJoueurs;
    ELSE
        RETURN NULL;
    END IF;
END;

-- 7
CREATE OR REPLACE FUNCTION nbJoueursParLigue(p_idLigue IN Ligues.idLigue%TYPE) RETURN NUMBER IS
    v_nbLigues NUMBER;
    v_nbJoueurs NUMBER;
BEGIN
    SELECT SUM(nbJoueursParClub(idClub)) INTO v_nbJoueurs
    FROM Clubs c
    WHERE idLigue = p_idLigue;
    RETURN v_nbJoueurs;
END;
UPDATE Ligues SET nbJoueursLigue = nbJoueursParLigue(idLigue);

-- 8
CREATE OR REPLACE PROCEDURE affichageInfosTournoi(p_idTournoi IN Tournois.idTournoi%TYPE) IS
    v_nbTournoi NUMBER;
    rty_Tournois Tournois%ROWTYPE;
    
BEGIN
    SELECT COUNT(*) INTO v_nbTournoi
    FROM Tournois
    WHERE idTournoi = p_idTournoi;

    IF v_nbTournoi = 1
    THEN
        SELECT * INTO rty_Tournois
        FROM Tournois
        WHERE idTournoi = p_idTournoi;
        
        DBMS_OUTPUT.PUT_LINE('Identifiant du tournoi ' || ' : ' ||
        p_idTournoi);
        DBMS_OUTPUT.PUT_LINE('Nom du tournoi ' || ' : ' ||
        rty_Tournois.nomTournoi);
        DBMS_OUTPUT.PUT_LINE('Ville du tournoi ' || ' : ' ||
        rty_Tournois.lieuTournoi);
        DBMS_OUTPUT.PUT_LINE('Nombre de rondes du tournoi ' ||
        ' : ' || rty_Tournois.nbRondesTournoi);
    ELSE
        DBMS_OUTPUT.PUT_LINE('Le tournoi ' || p_idTournoi || ' n''existe pas');
    END IF;
END;

-- 9
CREATE OR REPLACE PROCEDURE miseAJourNbParticipantsTournoi IS
BEGIN
    UPDATE Tournois t SET nbParticipantsTournoi = (
        SELECT COUNT(*) FROM Participer p WHERE t.idTournoi = p.idTournoi
    );
END;


-- Troisième partie : Les curseurs

-- 10
CREATE OR REPLACE PROCEDURE affichageParticipantsTournoi(p_idTournoi IN Tournois.idTournoi%TYPE) IS
BEGIN
    FOR v_participants IN (
        SELECT nomJoueur, prenomJoueur, eloJoueur
        FROM Joueurs j
        JOIN Participer p ON j.idJoueur = p.idJoueur
        WHERE p.idTournoi = p_idTournoi
        ORDER BY eloJoueur DESC
    )
    LOOP
        DBMS_OUTPUT.PUT_LINE(v_participants.nomJoueur || ' ' || v_participants.prenomJoueur || ' ' || v_participants.eloJoueur);
    END LOOP;
END;

-- 11
CREATE OR REPLACE PROCEDURE affichageToutTournoi(p_idTournoi IN Tournois.idTournoi%TYPE) IS
BEGIN
    affichageInfosTournoi(p_idTournoi);
    affichageParticipantsTournoi(p_idTournoi);
END;

-- 12
SET SERVEROUTPUT ON SIZE UNLIMITED FORMAT WRAPPED;
CREATE OR REPLACE PROCEDURE affichageJoueursParLigueEtClub(p_idLigue IN Ligues.idLigue%TYPE) IS
BEGIN
    FOR v_clubs IN (
        SELECT c.idClub, nomClub, COUNT(j.idJoueur) AS nbrJoueurs
        FROM Clubs c
        JOIN Joueurs j ON c.idClub = j.idClub
        WHERE idLigue = p_idLigue
        GROUP BY c.idClub, nomClub
        ORDER BY nomclub
    )
    LOOP
        DBMS_OUTPUT.PUT_LINE('');
        DBMS_OUTPUT.PUT_LINE('Club : ' || v_clubs.idClub || ' ' || v_clubs.nomClub || ' (' || v_clubs.nbrJoueurs || ' joueurs)');

        FOR v_participants IN (
            SELECT j.idJoueur, nomJoueur, prenomJoueur, eloJoueur, COUNT(p.idTournoi) AS nbrTournois
            FROM Joueurs j
            JOIN Clubs c ON j.idClub = c.idClub 
            LEFT JOIN Participer p ON j.idJoueur = p.idJoueur
            WHERE c.idLigue = p_idLigue
            AND c.idClub = v_clubs.idClub
            GROUP BY j.idJoueur, nomJoueur, prenomJoueur, eloJoueur
            ORDER BY nbrTournois DESC, eloJoueur DESC
        )
        LOOP
            DBMS_OUTPUT.PUT_LINE('-----> ' || v_participants.nomJoueur || ' ' || v_participants.prenomJoueur || ' ' || v_participants.eloJoueur || ' a participé à ' || v_participants.nbrTournois || ' tournoi(s)');
        END LOOP;
    END LOOP;
END;

-- 13
CREATE OR REPLACE FUNCTION categorieJoueur(
    p_dateNaissance IN Joueurs.dateNaissanceJoueur%TYPE,
    p_sexe IN Joueurs.sexeJoueur%TYPE
) RETURN VARCHAR IS
BEGIN
    IF p_dateNaissance >= '1/1/1972' AND p_dateNaissance < '1/1/2006'
    THEN 
        RETURN 'Sen' || p_sexe;
    ELSIF p_dateNaissance > '1/1/2006'
    THEN
        RETURN 'Jun' || p_sexe;
    ELSE
        RETURN 'Vet' || p_sexe;
    END IF;
END;