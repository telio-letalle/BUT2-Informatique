<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des utilisateurs</title>
    </head>
    <body>
        <?php
        /** @var ModeleUtilisateur[] $utilisateurs */
        foreach ($utilisateurs as $utilisateur)
            echo "<p> Utilisateur de login <a href='detail.php?action=afficherDetail&loginBaseDeDonnees={$utilisateur->getLogin()}'>{$utilisateur->getLogin()}</a></p>";
        ?>
        <a href="../Controleur/routeur.php?action=afficherFormulaireCreation">Créer un utilisateur</a>
    </body>
</html>