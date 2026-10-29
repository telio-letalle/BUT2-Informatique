<?php

namespace App\Covoiturage\Modele;

use App\Covoiturage\Modele\ConnexionBaseDeDonnees as ConnexionBaseDeDonnees;
use App\Covoiturage\Modele\ModeleUtilisateur as ModeleUtilisateurr;


class ModeleUtilisateur {

    // un getter
    public function getNom() : string {
        return $this->nom;
    }

    // un setter
    public function setNom(string $nom) {
        $this->nom = $nom;
    }

    public function getPrenom() : string {
        return $this->prenom;
    }

    public function setPrenom(string $prenom) {
        $this->prenom = $prenom;
    }

    public function getLogin() : string {
        return $this->login;
    }

    public function setLogin(string $login) {
        $this->login = substr($login, 0, 64);
    }

    // un constructeur
    public function __construct(
        private string $login,
        private string $nom,
        private string $prenom
    ) {
        $this->setLogin($login);
    }

    // Pour pouvoir convertir un objet en chaîne de caractères
    public function __toString() : string {
        return "ModeleUtilisateur $this->nom $this->prenom de login $this->login";
    }

    public static function construireDepuisTableauSQL(array $utilisateurFormatTableau) : ModeleUtilisateur {
        return new ModeleUtilisateur(
            $utilisateurFormatTableau['loginBaseDeDonnees'],
            $utilisateurFormatTableau['nomBaseDeDonnees'],
            $utilisateurFormatTableau['prenomBaseDeDonnees']
        );
    }

    public static function recupererUtilisateurs() : array {

        $pdo = \App\Covoiturage\Modele\ConnexionBaseDeDonnees::getPdo();

        $pdoStatement = $pdo->query("SELECT * FROM utilisateur");

        $pdoStatement->setFetchMode(\PDO::FETCH_ASSOC);

        $utilisateurs = [];

        foreach ($pdoStatement as $utilisateurFormatTableau) {
            $utilisateur = ModeleUtilisateur::construireDepuisTableauSQL($utilisateurFormatTableau);

            $utilisateurs[] = $utilisateur;
        }

        return $utilisateurs;
    }

    // Cette fonction renvoie un objet ModeleUtilisateur correspondant au login donné, ou null s'il n'existe pas
    public static function recupererUtilisateurParLogin(string $login) : ?ModeleUtilisateur {
        $sql = "SELECT * from utilisateur WHERE loginBaseDeDonnees = :loginTag";
        // Préparation de la requête
        $pdoStatement = \App\Covoiturage\Modele\ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "loginTag" => $login,
            //nomdutag => valeur, ...
        );
        // On donne les valeurs et on exécute la requête
        $pdoStatement->execute($values);

        // On récupère les résultats comme précédemment
        // Note: fetch() renvoie false si pas d'utilisateur correspondant
        $utilisateurFormatTableau = $pdoStatement->fetch();

        if ($utilisateurFormatTableau !== false) {
            return ModeleUtilisateur::construireDepuisTableauSQL($utilisateurFormatTableau);
        }
        return null;
    }

    public function ajouter() : void {
        $sql = 'INSERT INTO utilisateur (loginBaseDeDonnees, nomBaseDeDonnees, prenomBaseDeDonnees) VALUES(:loginTag, :nomTag, :prenomTag)';

        $pdoStatement = \App\Covoiturage\Modele\ConnexionBaseDeDonnees::getPdo()->prepare($sql);

        $values = array(
            "loginTag" => $this->login,
            "nomTag" => $this->nom,
            "prenomTag" => $this->prenom,
        );

        $pdoStatement->execute($values);
    }
}