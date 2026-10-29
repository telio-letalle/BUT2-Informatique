 <?php
    // require_once (__DIR__ . '/../../Modele/Utilisateur.php');

    /**
     * @var Utilisateur $utilisateur
     */
    $nom = $utilisateur->getNom();
    $prenom = $utilisateur->getPrenom();
    $login = $utilisateur->getLogin();

    echo "\nUtilisateur " . htmlspecialchars($nom) . " " . htmlspecialchars($prenom) . " de login " . htmlspecialchars($login);
?>

