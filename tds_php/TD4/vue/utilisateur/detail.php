<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Liste des utilisateurs</title>
    </head>
    <body>
        <?php
        require_once (__DIR__ . '/../../Modele/ModeleUtilisateur.php');

        echo "\nModeleUtilisateur " . $utilisateur->getNom() . " " . $utilisateur->getPrenom() . " de login " . $utilisateur->getLogin();
        ?>
    </body>
</html>

