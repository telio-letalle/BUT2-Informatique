/*
LIVRES (idLivre, nomLivre, anneeLivre, prixLivre, categorieLivre, idEditeur#)
EDITEURS (idEditeur, nomEditeur, paysEditeur)
ADHERENTS (idAdherent, nomAdherent, prenomAdherent, typeAdherent, idAdherentParrain#)
EMPRUNTS (idEmprunt, dateEmprunt, dateRetour, idLivre#, idAdherent#)
*/

--------------------------------------------------------------------------------

/*
R10 : l’identifiant des livres qui sont actuellement empruntés.
*/

SELECT l.idLivre
FROM Livres l
JOIN Emprunts e ON l.idLivre = e.idLivre
WHERE e.dateRetour IS NULL;


/*
R11 : le nombre de livres qui sont ou ont été empruntés.
*/

SELECT COUNT(DISTINCT idLivre)
FROM Emprunts;


/*
R12 : le nom des livres qui sont ou ont été empruntés par l’adhérent Barbie Chette. 
*/

SELECT nomLivre
FROM Livres
WHERE idLivre IN (
    SELECT e.idLivre
    FROM Emprunts e
    JOIN Adherents a ON a.idAdherent = e.idAdherent
    WHERE a.prenomAdherent = 'Barbie'
    AND a.nomAdherent = 'Chette'
);


/*
R13 : le prix moyen des livres de la catégorie 'Informatique'.
*/

SELECT AVG(prixLivre)
FROM Livres
WHERE categorieLivre = 'Informatique';


/*
R14 : le nom du livre le moins cher parmi ceux publiés par l’éditeur Eyrolles.
*/

SELECT l.nomLivre
FROM Livres l
JOIN Editeurs e ON l.idEditeur = e.idEditeur
WHERE E.nomEditeur = 'Eyrolles'
AND l.prixLivre = (
    SELECT MIN(prixLivre)
    FROM Livres l
    JOIN Editeurs e ON l.idEditeur = e.idEditeur
    WHERE E.nomEditeur = 'Eyrolles'
);


/*
R15 : le nom et le prénom des adhérents qui n’ont pas réalisé d’emprunt.
*/

SELECT a.prenomAdherent, a.nomAdherent
FROM Adherents a
WHERE a.idAdherent IN (
    SELECT idAdherent
    FROM Adherents
    MINUS
    SELECT idAdherent
    FROM Emprunts 
);


/*
R16 : le nom et prénom des adhérents qui ont emprunté le livre 'UML pour les Ninjas' et le livre
'Coder Proprement'.
*/

SELECT a.prenomAdherent, a.nomAdherent
FROM Adherents a
WHERE a.idAdherent IN (
    SELECT a.idAdherent
    FROM Adherents a
    JOIN Emprunts e ON a.idAdherent = e.idAdherent
    JOIN Livres l ON e.idLivre = l.idLivre
    WHERE l.nomLivre  = 'UML pour les Ninjas'

    INTERSECT
    
    SELECT a.idAdherent
    FROM Adherents a
    JOIN Emprunts e ON a.idAdherent = e.idAdherent
    JOIN Livres l ON e.idLivre = l.idLivre
    WHERE l.nomLivre  = 'Coder Proprement'
);


/*
R17 : le nom, le pays et le nombre de livres édités par chaque éditeur.
*/

SELECT e.nomEditeur, e.paysEditeur, COUNT(idLivre)
FROM Editeurs e
LEFT JOIN Livres l ON e.idEditeur = l.idEditeur
GROUP BY e.nomEditeur, e.paysEditeur;


/*
R18 : le nom des livres qui ont plus de 3 emprunts.
*/

SELECT l.nomLivre
FROM Emprunts e
JOIN Livres l ON e.idLIvre = l.idLIvre
GROUP BY l.nomLivre, l.idLivre
HAVING COUNT(*) > 3;


/*
R19 : le nom et le prénom des adhérents qui n’ont emprunté que des livres de la catégorie
'Gestion'.
*/

SELECT a.nomAdherent, a.prenomAdherent
FROM Adherents a
WHERE EXISTS (
    SELECT 1
    FROM Emprunts e
    WHERE e.idAdherent = a.idAdherent
)
AND NOT EXISTS (
    SELECT 1
    FROM Emprunts e
    JOIN Livres l ON e.idLivre = l.idLivre
    WHERE e.idAdherent = a.idAdherent
      AND l.categorieLivre <> 'Gestion'
);


/*
R20 : le nom des adhérents qui ont emprunté tous les livres de la catégorie 'Gestion'.
*/




/*
R21 : le nom et le prénom des étudiants qui n’ont pas de parrain.
*/

SELECT a.nomAdherent, a.prenomAdherent 
FROM Adherents a 
WHERE a.idAdherentParrain IS NULL;
/* me semble correct mais affiche des adhérents en trop */


/*
R22 : le nom et prénom des adhérents qui ont emprunté plusieurs fois un même livre.
*/

SELECT a.nomAdherent, a.prenomAdherent
FROM Adherents a
JOIN Emprunts e ON a.idAdherent = e.idAdherent
JOIN Livres l ON e.idLivre = l.idLivre
GROUP BY a.nomAdherent, a.prenomAdherent, l.nomLivre
HAVING COUNT(l.nomLivre) > 1;


/*
R23 : le nom et le prénom de l’adhérent qui a le plus d’emprunts.
*/

SELECT * FROM (
    SELECT a.nomAdherent, a.prenomAdherent
    FROM Adherents a
    JOIN Emprunts e ON a.idAdherent = e.idAdherent
    GROUP BY a.nomAdherent, a.prenomAdherent
    ORDER BY COUNT(e.idEmprunt) DESC
)
WHERE ROWNUM = 1;
/* La correction donne 'Chette''Barbie' mais 'Neymar''Jean' a le plus d'emprunts (9). */


/*
R24 : le numéro et la durée (en nombre de jours) de l’emprunt qui a duré le plus de temps
(uniquement dans les emprunts dont le livre a été rendu).
*/

SELECT e.idEmprunt, e.dateRetour - e.dateEmprunt
FROM Emprunts e
WHERE e.dateRetour IS NOT NULL
AND e.dateRetour - e.dateEmprunt = (
    SELECT MAX(e.dateRetour - e.dateEmprunt)
    FROM Emprunts e
);


/*
R25 : le nom et le pays des éditeurs qui éditent moins de 2 livres.
*/

SELECT e.nomEditeur, e.paysEditeur
FROM Editeurs e
LEFT JOIN Livres l ON e.idEditeur = l.idEditeur
GROUP BY e.nomEditeur, e.paysEditeur
HAVING COUNT(l.idLivre) < 2;


/*
R26 : le nom et le prénom des adhérents qui se prénomment 'Jeanne' ou bien qui ont
emprunté un livre de la catégorie 'Gestion'.
*/

SELECT a.nomAdherent, a.prenomAdherent
FROM Adherents a
WHERE a.prenomAdherent = 'Jeanne'
UNION
SELECT a.nomAdherent, a.prenomAdherent
FROM Adherents a
JOIN Emprunts e ON a.idAdherent = e.idAdherent
JOIN Livres l ON e.idLivre = l.idLivre
WHERE l.categorieLivre = 'Gestion';


/*
R27 : le nom, le prénom et le nombre de filleuls de chaque adhérent (les adhérents qui n’ont
pas de filleul doivent apparaitre).
*/

SELECT a.nomAdherent, a.prenomAdherent, COUNT(a1.idAdherent) AS nbFilleuls
FROM Adherents a
LEFT JOIN Adherents a1 ON a.idAdherent = a1.idAdherentParrain
GROUP BY a.idAdherent, a.nomAdherent, a.prenomAdherent;


/*
R28 : le nom et le prénom des adhérents qui ont emprunté des livres de toutes les catégories.
*/

SELECT a.nomAdherent, a.prenomAdherent
FROM Adherents a
JOIN Emprunts e ON a.idAdherent = e.idAdherent
JOIN Livres l ON e.idLivre = l.idLivre
GROUP BY a.nomAdherent, a.prenomAdherent
HAVING COUNT(DISTINCT l.categorieLivre) = (
    SELECT COUNT(DISTINCT l.categorieLivre)
    FROM Livres l
)

-- -- -- Ma réponse donne Neymar Jean en +, 
-- -- -- via la requête suivante on voit qu'il a aussi emprunté les 3 catégories  
-- SELECT l.categorieLivre, a.nomAdherent, a.prenomAdherent, COUNT(DISTINCT l.categorieLivre)
-- FROM Adherents a
-- JOIN Emprunts e ON a.idAdherent = e.idAdherent
-- JOIN Livres l ON e.idLivre = l.idLivre
-- WHERE a.prenomAdherent = 'Omer' OR a.prenomAdherent = 'Jean'
-- GROUP BY l.categorieLivre, a.nomAdherent, a.prenomAdherent


/*
R29 : le nom des éditeurs dont tous les livres coûtent moins de 35€.
*/

SELECT DISTINCT e.nomEditeur
FROM Editeurs e
JOIN Livres l ON e.idEditeur = l.idEditeur
WHERE NOT EXISTS (
    SELECT *
    FROM Livres l
    WHERE e.idEditeur = l.idEditeur
    AND l.prixLivre >= 35
)

/*
LIVRES (idLivre, nomLivre, anneeLivre, prixLivre, categorieLivre, idEditeur#)
EDITEURS (idEditeur, nomEditeur, paysEditeur)
ADHERENTS (idAdherent, nomAdherent, prenomAdherent, typeAdherent, idAdherentParrain#)
EMPRUNTS (idEmprunt, dateEmprunt, dateRetour, idLivre#, idAdherent#)
*/