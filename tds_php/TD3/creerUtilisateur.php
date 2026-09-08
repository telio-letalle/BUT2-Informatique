<?php

require_once 'Utilisateur.php';

var_dump($_POST);

$login = $_POST['login'];
$nom = $_POST['nom'];
$prenom = $_POST['prenom'];

echo "<p>Utilisateur $nom $prenom de login $login</p>\n";

$utilisateur = new Utilisateur($login, $nom, $prenom);

$utilisateur->ajouter();