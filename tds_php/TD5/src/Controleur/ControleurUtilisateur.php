<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\ModeleUtilisateur;

class ControleurUtilisateur {
    // Déclaration de type de retour void : la fonction ne retourne pas de valeur
    public static function afficherListe() : void {
        $utilisateurs = ModeleUtilisateur::recupererUtilisateurs(); //appel au modèle pour gérer la BD
        self::afficherVue(
            'vueGenerale.php',
            [
                "utilisateurs" => $utilisateurs,
                "titre" => "Liste des utilisateurs",
                "cheminCorpsVue" => "utilisateur/liste.php"
            ]
        );  //"redirige" vers la vue
    }

    public static function afficherDetail() : void {
        if (!isset($_GET['loginBaseDeDonnees'])) {
            self::afficherVue(
                'vueGenerale.php',
                [
                    "titre" => "Afficher l'erreur",
                    "cheminCorpsVue" => "utilisateur/erreur.php"
                ]
            );
        }
        else {
            $login = $_GET['loginBaseDeDonnees'];
            $utilisateur = ModeleUtilisateur::recupererUtilisateurParLogin($login);
            if (!$utilisateur) {
                self::afficherVue(
                    'vueGenerale.php',
                    [
                        "titre" => "Afficher l'erreur",
                        "cheminCorpsVue" => "utilisateur/erreur.php"
                    ]
                );
                return;
            }
            self::afficherVue(
                'vueGenerale.php',
                [
                    "utilisateur" => $utilisateur,
                    "titre" => "Afficher l'utilisateur",
                    "cheminCorpsVue" => "utilisateur/detail.php"
                ]
            );
        }
    }

    public static function afficherFormulaireCreation() : void {
        self::afficherVue(
            'vueGenerale.php',
            [
                "titre" => "Afficher le formulaire",
                "cheminCorpsVue" => "utilisateur/formulaireCreation.php"
            ]
        );
    }

    public static function creerDepuisFormulaire() : void {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {

            $login = $_GET['login'];
            $nom = $_GET['nom'];
            $prenom = $_GET['prenom'];

            $utilisateur = new ModeleUtilisateur($login, $nom, $prenom);

            $utilisateur->ajouter();

            $utilisateurs = ModeleUtilisateur::recupererUtilisateurs();
            self::afficherVue(
                'vueGenerale.php',
                [
                    "utilisateurs" => $utilisateurs,
                    "titre" => "Utilisateur créé",
                    "cheminCorpsVue" => "utilisateur/utilisateurCree.php"
                ]
            );
        }
    }

    private static function afficherVue(string $cheminVue, array $parametres = []) : void {
        extract($parametres); // Crée des variables à partir du tableau $parametres
        require __DIR__ . "/../vue/$cheminVue"; // Charge la vue
    }
}
?>
