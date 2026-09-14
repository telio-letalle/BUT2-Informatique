SET SERVEROUTPUT ON;



DECLARE
    v_idClub Joueurs.idClub%TYPE := 'C1';
    nbJoueurs NUMBER;
BEGIN
    SELECT COUNT(*) INTO nbJoueurs
    FROM Joueurs
    WHERE idClub = v_idClub;

    DBMS_OUTPUT.PUT_LINE('Il y a ' || nbJoueurs || ' joueur(s) dans le club ' || v_idClub);
END;
