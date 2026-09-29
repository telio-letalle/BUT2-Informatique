<?php
require_once ('../Modele/ModeleUtilisateur.php'); // chargement du modèle
class ControleurUtilisateur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = ModeleUtilisateur::recupererUtilisateurs(); //appel au modèle pour gérer la BD

        self::afficherVue('utilisateur/liste.php', ["utilisateurs" => $utilisateurs]);  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        if (!isset($_GET['loginBaseDeDonnees'])) {
            self::afficherVue('utilisateur/erreur.php');
            return;
        }
        $login = $_GET['loginBaseDeDonnees'];
        $utilisateur = ModeleUtilisateur::recupererUtilisateurParLogin($login);
        if (!$utilisateur) {
            self::afficherVue('utilisateur/erreur.php');
            return;
        }
        self::afficherVue('utilisateur/detail.php', ["utilisateur" => $utilisateur]);
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue('utilisateur/formulaireCreation.php');
    }

    private static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require "../vue/$cheminVue"; // Charge la vue
    }
}
?>
