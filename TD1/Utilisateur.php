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
        $this->login = substr($login, 0, 64);
    }

    // un constructeur
    public function __construct(
        $login,
        $nom,
        $prenom,
    ) {
        $this->setLogin($login);
        $this->nom = $nom;
        $this->prenom = $prenom;
    }

    // Pour pouvoir convertir un objet en chaîne de caractères
    public function __toString() {
        return "Utilisateur $this->nom $this->prenom de login $this->login";
    }
}