<?php

require_once 'Utilisateur.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST);

    $login = $_POST['login'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];

    $utilisateur = new Utilisateur($login, $nom, $prenom);
    $utilisateur->ajouter();

    echo "<p>Utilisateur $nom $prenom de login $login</p>\n";
}