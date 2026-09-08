<?php
class Utilisateur {

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
        return "Utilisateur $this->nom $this->prenom de login $this->login";
    }
}