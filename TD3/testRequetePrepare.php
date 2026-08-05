<?php

require_once "Utilisateur.php";

$utilisateur = Utilisateur::recupererUtilisateurParLogin("letallet");

var_dump($utilisateur);

echo "<br>";

$utilisateur = Utilisateur::recupererUtilisateurParLogin("loginNonExistant");

var_dump($utilisateur);