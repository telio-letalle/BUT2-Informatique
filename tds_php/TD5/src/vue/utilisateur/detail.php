 <?php
    // require_once (__DIR__ . '/../../Modele/ModeleUtilisateur.php');

    /**
     * @var ModeleUtilisateur $utilisateur
     */
    $nom = $utilisateur->getNom();
    $prenom = $utilisateur->getPrenom();
    $login = $utilisateur->getLogin();

    echo "\nModeleUtilisateur " . htmlspecialchars($nom) . " " . htmlspecialchars($prenom) . " de login " . htmlspecialchars($login);
?>

