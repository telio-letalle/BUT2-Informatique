<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Modele\DataObject\Utilisateur;
use App\Covoiturage\Modele\Repository\UtilisateurRepository;
use App\Covoiturage\Modele\HTTP\Cookie;

class ControleurUtilisateur extends ControleurGenerique
{
    // public static function deposerCookie(): void
    // {
    //     Cookie::enregistrer("TestCookie", "OK", 3600);
    // }

    // public static function lireCookie(): void
    // {
    //     if (Cookie::contient("TestCookie")) {
    //         echo Cookie::lire("TestCookie");
    //     }
    // }

    public static function supprimerCookie(): void
    {
        Cookie::supprimer("TestCookie");
        echo "Cookie supprimé";
    }

    public static function afficherErreur(string $messageErreur = ""): void
    {
        self::afficherVue(
            'vueGenerale.php',
            [
                "messageErreur" => $messageErreur,
                "titre" => "Erreur",
                "cheminCorpsVue" => "utilisateur/erreur.php",
            ]
        );
    }

    public static function afficherListe(): void
    {
        $utilisateurs = (new UtilisateurRepository())->recuperer();

        self::afficherVue(
            'vueGenerale.php',
            [
                "utilisateurs" => $utilisateurs,
                "titre" => "Liste des utilisateurs",
                "cheminCorpsVue" => "utilisateur/liste.php"
            ]
        );
    }

    public static function afficherDetail(): void
    {
        if (!isset($_GET['loginBaseDeDonnees'])) {
            self::afficherErreur("Login obligatoire");
            return;
        }

        $login = $_GET['loginBaseDeDonnees'];

        $utilisateur = (new UtilisateurRepository())
            ->recupererParClePrimaire($login);

        if (!$utilisateur) {
            self::afficherErreur("Utilisateur inexistant pour ce login");
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

    public static function afficherFormulaireCreation(): void
    {
        self::afficherVue(
            'vueGenerale.php',
            [
                "titre" => "Formulaire de création utilisateur",
                "cheminCorpsVue" => "utilisateur/formulaireCreation.php"
            ]
        );
    }

    private static function construireDepuisFormulaire(
        array $tableauDonneesFormulaire
    ): Utilisateur {
        $login = $tableauDonneesFormulaire['login'] ?? '';
        $nom = $tableauDonneesFormulaire['nom'] ?? '';
        $prenom = $tableauDonneesFormulaire['prenom'] ?? '';

        return new Utilisateur($login, $nom, $prenom);
    }

    public static function creerDepuisFormulaire(): void
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            $utilisateur = self::construireDepuisFormulaire($_GET);

            $utilisateurRepository = new UtilisateurRepository();
            $utilisateurRepository->ajouter($utilisateur);

            $utilisateurs = (new UtilisateurRepository())->recuperer();

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

    public static function supprimer(): void
    {
        $login = $_GET['loginBaseDeDonnees'] ?? '';

        $utilisateurRepository = new UtilisateurRepository();
        $utilisateurRepository->supprimer($login);

        $utilisateurs = (new UtilisateurRepository())->recuperer();

        self::afficherVue(
            'vueGenerale.php',
            [
                "utilisateurs" => $utilisateurs,
                "login" => $login,
                "titre" => "Utilisateur supprimé",
                "cheminCorpsVue" => "utilisateur/utilisateurSupprime.php",
            ]
        );
    }

    public static function afficherFormulaireMiseAJour(): void
    {
        if (!isset($_GET['loginBaseDeDonnees'])) {
            self::afficherErreur("Login obligatoire");
            return;
        }

        $login = $_GET['loginBaseDeDonnees'];

        $utilisateur = (new UtilisateurRepository())
            ->recupererParClePrimaire($login);

        if (!$utilisateur) {
            self::afficherErreur("Utilisateur inexistant pour ce login");
            return;
        }

        self::afficherVue(
            'vueGenerale.php',
            [
                "utilisateur" => $utilisateur,
                "titre" => "Formulaire de mise à jour",
                "cheminCorpsVue" => "utilisateur/formulaireMiseAJour.php"
            ]
        );
    }

    public static function mettreAJour(): void
    {
        $utilisateur = self::construireDepuisFormulaire($_GET);

        (new UtilisateurRepository())->mettreAJour($utilisateur);

        $utilisateurs = (new UtilisateurRepository())->recuperer();

        self::afficherVue(
            'vueGenerale.php',
            [
                "utilisateurs" => $utilisateurs,
                "login" => $utilisateur->getLogin(),
                "titre" => "Modification d'un utilisateur",
                "cheminCorpsVue" => "utilisateur/utilisateurMisAJour.php"
            ]
        );
    }
}