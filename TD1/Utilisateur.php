<?php
class Utilisateur {

    private $login;
    private $nom;
    private $prenom;

    // un getter
    public function getNom() {
        return $this->nom;
    }

    // un setter
    public function setNom($nom) {
        $this->nom = $nom;
    }

    public function getPrenom() {
        return $this->prenom;
    }

    public function setPrenom($prenom) {
        $this->prenom = $prenom;
    }

    public function getLogin() {
        return $this->login;
    }

    public function setLogin($login) {
        $this->login = $login;
    }

    // un constructeur
    public function __construct(
        $login,
        $nom,
        $prenom,
    ) {
        $this->login = $login;
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    // Pour pouvoir convertir un objet en chaîne de caractères
    public function __toString() {
        // À compléter dans le prochain exercice
    }
}