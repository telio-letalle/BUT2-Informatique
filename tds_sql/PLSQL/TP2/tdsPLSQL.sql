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
    FROM Tournoisg
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


-- Quatrième partie – Edition des résultats d’une ronde :

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



-----------------------------------------------------------------------
-- Les exercices précédents sont gardés dans le fichier car            \
-- des fonctions/procédures sont utilisés dans les questions suivantes  }
------------------------------------------------------------------------

----------\
--        |
-- BONUS: |
--        |
----------/

-- Factorisation de requête, non demandée et créée par envie
-- car répétition du même bloc de requête dans la suite
CREATE OR REPLACE FUNCTION recupererNbJoueursTournoiRonde(
    p_idJoueur IN Joueurs.idJoueur%TYPE,
    p_idTournoi IN Tournois.idTournoi%TYPE,
    p_numRonde IN Parties.numRonde%TYPE
) RETURN NUMBER IS
    v_nbJoueurs NUMBER;
BEGIN
    SELECT COUNT(*) INTO v_nbJoueurs
    FROM Joueurs j
    JOIN Participer p ON j.idJoueur = p.idJoueur
    JOIN Tournois t ON p.idTournoi = t.idTournoi
    JOIN Parties pr ON t.idTournoi = pr.idTournoi
    WHERE j.idJoueur = p_idJoueur
    AND t.idTournoi = p_idTournoi
    AND pr.numRonde = p_numRonde;

    RETURN v_nbJoueurs;
END;

CREATE OR REPLACE FUNCTION recupererNbRondesJoueur(
    p_idJoueur IN Joueurs.idJoueur%TYPE,
    p_idTournoi IN Tournois.idTournoi%TYPE
) RETURN NUMBER IS
    v_nbRondes NUMBER;
BEGIN
    SELECT COUNT(DISTINCT numRonde) INTO v_nbRondes
    FROM Joueurs j
    JOIN Participer p ON j.idJoueur = p.idJoueur
    JOIN Tournois t ON p.idTournoi = t.idTournoi
    JOIN Parties pr ON t.idTournoi = pr.idTournoi
    WHERE j.idJoueur = p_idJoueur
    AND t.idTournoi = p_idTournoi;

    RETURN v_nbRondes;
END;

CREATE OR REPLACE FUNCTION creerRtyPartieJoueur(
    p_idJoueur IN Joueurs.idJoueur%TYPE,
    p_idTournoi IN Tournois.idTournoi%TYPE,
    p_numRonde IN Parties.numRonde%TYPE
) RETURN Parties%ROWTYPE IS
    rty_partieJoueur Parties%ROWTYPE;
BEGIN
    SELECT * INTO rty_partieJoueur
    FROM Parties
    WHERE idTournoi = p_idTournoi
    AND numRonde = p_numRonde
    AND (idJoueurBlancs = p_idJoueur
    OR idJoueurNoirs = p_idJoueur);

    RETURN rty_partieJoueur;
END;

CREATE OR REPLACE FUNCTION creerRtyJoueur(
    p_idJoueur IN Joueurs.idJoueur%TYPE
) RETURN Joueurs%ROWTYPE IS
    rty_joueur Joueurs%ROWTYPE;
BEGIN
    SELECT * INTO rty_joueur
    FROM Joueurs j
    WHERE j.idJoueur = p_idJoueur;

    RETURN rty_joueur;
END;

CREATE OR REPLACE PROCEDURE affichageNomCategorieElo(
    p_nom IN Joueurs.nomJoueur%TYPE,
    p_prenom IN Joueurs.prenomJoueur%TYPE,
    p_dateNaissance IN Joueurs.dateNaissanceJoueur%TYPE,
    p_sexe IN Joueurs.sexeJoueur%TYPE,
    p_elo IN Joueurs.eloJoueur%TYPE
) IS
BEGIN
    DBMS_OUTPUT.PUT(
        p_nom
        || ' '
        || p_prenom
        || ' '
        || categorieJoueur(p_dateNaissance, p_sexe)
        || ' '
        || p_elo
    );
END;
-- Fin Factorisation

-- 14
CREATE OR REPLACE PROCEDURE affichageResultatsRonde(
    p_idTournoi IN Parties.idTournoi%TYPE,
    p_numRonde IN Parties.numRonde%TYPE
) IS
BEGIN
    FOR v_participants IN (
        SELECT resultatPartie,
            j.nomJoueur as nj1, j.prenomJoueur as pj1, j.sexeJoueur as sj1, j.dateNaissanceJoueur as dns1, j.eloJoueur as ej1,
            j2.nomJoueur as nj2, j2.prenomJoueur as pj2, j2.sexeJoueur as sj2, j2.dateNaissanceJoueur as dnj2, j2.eloJoueur as ej2
        FROM Parties pr
        JOIN Joueurs j ON pr.idJoueurBlancs = j.idJoueur
        JOIN Joueurs j2 ON pr.idJoueurNoirs = j2.idJoueur
        WHERE pr.idTournoi = p_idTournoi
        AND pr.numRonde = p_numRonde
        ORDER BY pr.numTable
    )
    LOOP
        affichageNomCategorieElo(
            v_participants.nj1,
            v_participants.pj1,
            v_participants.dns1,
            v_participants.sj1,
            v_participants.ej1
        );

        DBMS_OUTPUT.PUT(' ' || v_participants.resultatPartie || ' ');

        affichageNomCategorieElo(
            v_participants.nj2,
            v_participants.pj2,
            v_participants.dnj2,
            v_participants.sj2,
            v_participants.ej2
        );

        DBMS_OUTPUT.NEW_LINE;
    END LOOP;
END;


-- Cinquième partie – Edition des résultats d’un joueur à un tournoi :

-- 15
CREATE OR REPLACE PROCEDURE affichageInfosJoueur(
    p_idJoueur IN Joueurs.idJoueur%TYPE
) IS
    v_nbJoueurs NUMBER;
    rty_joueur Joueurs%ROWTYPE;
BEGIN
    SELECT COUNT(*) INTO v_nbJoueurs
    FROM Joueurs
    WHERE idJoueur = p_idJoueur;

    IF v_nbJoueurs = 0
    THEN
        RAISE_APPLICATION_ERROR(-20001, 'Le joueur J100 n''existe pas');
    ELSE
        SELECT * INTO rty_joueur
        FROM Joueurs
        WHERE idJoueur = p_idJoueur;
        
        DBMS_OUTPUT.PUT_LINE('Identifiant joueur ' || ' : ' || rty_joueur.idJoueur);
        DBMS_OUTPUT.PUT_LINE('Nom joueur ' || ' : ' || rty_joueur.nomJoueur);
        DBMS_OUTPUT.PUT_LINE('Prénom joueur ' || ' : ' || rty_joueur.prenomJoueur);
        DBMS_OUTPUT.PUT_LINE('Elo joueur ' || ' : ' || rty_joueur.eloJoueur);
        DBMS_OUTPUT.PUT_LINE('Catégorie joueur ' || ' : ' || categorieJoueur(rty_joueur.dateNaissanceJoueur, rty_joueur.sexeJoueur));
        DBMS_OUTPUT.PUT_LINE('Club joueur ' || ' : ' || rty_joueur.idClub);
    END IF;
END;

-- 16 12h10->12h23
CREATE OR REPLACE FUNCTION resultatEnPoint(
    p_couleur VARCHAR,
    p_resultat IN Parties.resultatPartie%TYPE
) RETURN NUMBER IS
    v_resultatenpoint NUMBER;
BEGIN
    IF p_couleur = 'B' AND p_resultat = '1-0' OR p_couleur = 'N' AND p_resultat = '0-1'
    THEN
        v_resultatenpoint := 1;
    ELSIF p_couleur = 'B' AND p_resultat = '0-1' OR p_couleur = 'N' AND p_resultat = '1-0'
    THEN
        v_resultatenpoint := 0;
    ELSE
        v_resultatenpoint := .5;
    END IF;

    RETURN v_resultatenpoint;
END;

-- 17 12h25->12h47
CREATE OR REPLACE FUNCTION couleurJoueurRonde(
    p_idJoueur IN Joueurs.idJoueur%TYPE,
    p_idTournoi IN Tournois.idTournoi%TYPE,
    p_numRonde IN Parties.numRonde%TYPE
) RETURN VARCHAR IS
    v_nbJoueurs NUMBER;
    rty_partieJoueur Parties%ROWTYPE;
BEGIN
    v_nbJoueurs := recupererNbJoueursTournoiRonde(p_idJoueur, p_idTournoi, p_numRonde);

    IF v_nbJoueurs = 0
    THEN
        RETURN NULL;
    ELSE
        rty_partieJoueur := creerRtyPartieJoueur(p_idJoueur, p_idTournoi, p_numRonde);

        IF rty_partieJoueur.idJoueurBlancs = p_idJoueur
        THEN
            RETURN 'B';
        ELSE
            RETURN 'N';
        END IF;
    END IF;
END;

-- 18 15h44->15h57
CREATE OR REPLACE FUNCTION adversaireJoueurRonde (
    p_idJoueur IN Joueurs.idJoueur%TYPE,
    p_idTournoi IN Tournois.idTournoi%TYPE,
    p_numRonde IN Parties.numRonde%TYPE
) RETURN Joueurs.idJoueur%TYPE IS
    v_nbJoueurs NUMBER;
    v_couleurJoueur CHAR;
    rty_partieJoueur Parties%ROWTYPE;
    v_idAdversaire Joueurs.idJoueur%TYPE;
BEGIN
    v_nbJoueurs := recupererNbJoueursTournoiRonde(p_idJoueur, p_idTournoi, p_numRonde);

    IF v_nbJoueurs = 0
    THEN
        RETURN NULL;
    ELSE
        v_couleurJoueur := couleurJoueurRonde(p_idJoueur, p_idTournoi, p_numRonde);
        rty_partieJoueur := creerRtyPartieJoueur(p_idJoueur, p_idTournoi, p_numRonde);

        IF v_couleurJoueur = 'B'
        THEN
            v_idAdversaire := rty_partieJoueur.idJoueurNoirs;
        ELSE
            v_idAdversaire := rty_partieJoueur.idJoueurBlancs;
        END IF;

        RETURN v_idAdversaire;
    END IF;
END;

-- 19 15h09->15h18
CREATE OR REPLACE FUNCTIon resultatJoueurRonde(
    p_idJoueur IN Joueurs.idJoueur%TYPE,
    p_idTournoi IN Tournois.idTournoi%TYPE,
    p_numRonde IN Parties.numRonde%TYPE
) RETURN NUMBER IS
    v_nbJoueurs NUMBER;
    v_couleurJoueur CHAR;
    v_resultatJoueur NUMBER;
    rty_partieJoueur Parties%ROWTYPE;
BEGIN
    v_nbJoueurs := recupererNbJoueursTournoiRonde(p_idJoueur, p_idTournoi, p_numRonde);

    IF v_nbJoueurs = 0
    THEN
        RETURN NULL;
    ELSE
        v_couleurJoueur := couleurJoueurRonde(p_idJoueur, p_idTournoi, p_numRonde);
        rty_partieJoueur := creerRtyPartieJoueur(p_idJoueur, p_idTournoi, p_numRonde);

        v_resultatJoueur := resultatEnPoint(v_couleurJoueur, rty_partieJoueur.resultatPartie);
    
        RETURN v_resultatJoueur;
    END IF;
END;

-- 20 15h30->16h39 compliqué
CREATE OR REPLACE PROCEDURE affichagePartiesJoueurTournoi(
    p_idJoueur IN Joueurs.idJoueur%TYPE,
    p_idTournoi IN Tournois.idTournoi%TYPE
) IS
    rty_adversaire Joueurs%ROWTYPE;
    v_idAdversaire Joueurs.idJoueur%TYPE;

    CURSOR c_partiesJoueurTournoi IS
        SELECT numRonde
        FROM Joueurs j
        JOIN Participer p ON j.idJoueur = p.idJoueur
        JOIN Tournois t ON p.idTournoi = t.idTournoi
        JOIN Parties pr ON t.idTournoi = pr.idTournoi
        WHERE t.idTournoi = p_idTournoi
        AND j.idJoueur = p_idJoueur
        AND (idJoueurBlancs = p_idJoueur
        OR idJoueurNoirs = p_idJoueur)
        ORDER BY pr.numRonde;
    -- sûrement possible de factoriser ce cursor
    -- via une fonction qui renvoie le cursor créé
    -- qu'on stocke dans une variable, en une ligne simple
        -- Recherches sasns succès
BEGIN
    FOR v_partie IN c_partiesJoueurTournoi
    LOOP
        v_idAdversaire := adversaireJoueurRonde(p_idJoueur, p_idTournoi, v_partie.numRonde);
        rty_adversaire := creerRtyJoueur(v_idAdversaire);

        DBMS_OUTPUT.PUT(
            'R'
            || v_partie.numRonde
            || ' '
            || couleurJoueurRonde(p_idJoueur, p_idTournoi, v_partie.numRonde)
            || ' '
        );

        affichageNomCategorieElo(
            rty_adversaire.nomJoueur,
            rty_adversaire.prenomJoueur,
            rty_adversaire.dateNaissanceJoueur,
            rty_adversaire.sexeJoueur,
            rty_adversaire.eloJoueur
        );

        DBMS_OUTPUT.PUT_LINE(
            ' '
            || resultatJoueurRonde(p_idJoueur, p_idTournoi, v_partie.numRonde)
        );
    END LOOP;
END;
-- recherche internet via ia pour re comprendre l'utilisation du cursor

-- 21 14h00->14h09
CREATE OR REPLACE FUNCTION nbPointsJoueurTournoi(
    p_idJoueur Joueurs.idJoueur%TYPE,
    p_idTournoi Tournois.idTournoi%TYPE
) RETURN NUMBER IS
    v_nbPointsRonde NUMBER;
    v_nbPointsTotal NUMBER;

    CURSOR c_partiesJoueurTournoi IS
        SELECT numRonde
        FROM Joueurs j
        JOIN Participer p ON j.idJoueur = p.idJoueur
        JOIN Tournois t ON p.idTournoi = t.idTournoi
        JOIN Parties pr ON t.idTournoi = pr.idTournoi
        WHERE t.idTournoi = p_idTournoi
        AND j.idJoueur = p_idJoueur
        AND (idJoueurBlancs = p_idJoueur
        OR idJoueurNoirs = p_idJoueur)
        ORDER BY pr.numRonde;
    -- Idem qu'à la question précédente
BEGIN
    v_nbPointsTotal := 0;

    FOR v_partie IN c_partiesJoueurTournoi
    LOOP
        v_nbPointsRonde := resultatJoueurRonde(p_idJoueur, p_idTournoi, v_partie.numRonde);

        v_nbPointsTotal := v_nbPointsTotal + v_nbPointsRonde;
    END LOOP;

    RETURN v_nbPointsTotal;
END;

-- 22 14h15->?(pause)
CREATE OR REPLACE FUNCTION cumulatifJoueurTournoi(
    p_idJoueur Joueurs.idJoueur%TYPE,
    p_idTournoi Tournois.idTournoi%TYPE
) RETURN NUMBER IS
    v_nbPointsRondeActuelle NUMBER;
    v_nbPointsTotalRondeActuelle NUMBER;
    v_cumulatif NUMBER;
    v_nbPointsTotalPrécédent NUMBER;

    CURSOR c_partiesJoueurTournoi IS
        SELECT numRonde
        FROM Joueurs j
        JOIN Participer p ON j.idJoueur = p.idJoueur
        JOIN Tournois t ON p.idTournoi = t.idTournoi
        JOIN Parties pr ON t.idTournoi = pr.idTournoi
        WHERE t.idTournoi = p_idTournoi
        AND j.idJoueur = p_idJoueur
        AND (idJoueurBlancs = p_idJoueur
        OR idJoueurNoirs = p_idJoueur)
        ORDER BY pr.numRonde;
    -- Idem qu'à la question précédente
BEGIN
    v_nbPointsTotalPrécédent := 0;
    v_cumulatif := 0;

    FOR v_partie IN c_partiesJoueurTournoi
    LOOP
        v_nbPointsRondeActuelle := resultatJoueurRonde(p_idJoueur, p_idTournoi, v_partie.numRonde);

        v_nbPointsTotalRondeActuelle := v_nbPointsTotalPrécédent + v_nbPointsRondeActuelle;

        v_cumulatif := v_cumulatif + v_nbPointsTotalRondeActuelle;

        v_nbPointsTotalPrécédent := v_nbPointsTotalRondeActuelle;
    END LOOP;

    RETURN v_cumulatif;
END;