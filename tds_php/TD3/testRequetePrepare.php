<?php

require_once 'Utilisateur.php';

$utilisateur = Utilisateur::recupererUtilisateurParLogin('lesimplem');
echo "\n<p>$utilisateur</p>";

$utilisateur2 = new Utilisateur('nadalc', 'nadal', 'cyrille');
$utilisateur2->ajouter();