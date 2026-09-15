<?php

require_once 'Utilisateur.php';

$utilisateur = Utilisateur::recupererUtilisateurParLogin('lesimplem');
echo "\n<p>$utilisateur</p>";

$utilisateur = new Utilisateur('nadalc', 'nadal', 'cyrille');
$utilisateur->ajouter();