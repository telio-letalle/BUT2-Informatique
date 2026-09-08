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
    JOIN Adherents a
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
)


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
)


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
)