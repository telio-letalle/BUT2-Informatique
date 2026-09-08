<?php

require_once "Utilisateur.php";

$utilisateur = Utilisateur::recupererUtilisateurParLogin("letallet");

var_dump($utilisateur);

echo "<br>";

$utilisateur2 = Utilisateur::recupererUtilisateurParLogin("loginNonExistant");

var_dump($utilisateur2);

$utilisateur3 = new Utilisateur("bazina", "bazin", "alexandre");

$utilisateur3->ajouter();