<?php

require_once 'ConnexionBaseDeDonnees.php';
require_once 'Utilisateur.php';


$pdo = ConnexionBaseDeDonnees::getPdo();

// ---------

$pdoStatement = $pdo->query("SELECT * FROM utilisateur");
$utilisateurFormatTableau = $pdoStatement->fetch();

echo "<p><i>";
var_dump($utilisateurFormatTableau);
echo "</i></p>\n";

if (!empty($utilisateurFormatTableau)) {
    $utilisateur = new Utilisateur(
        $utilisateurFormatTableau['loginBaseDeDonnees'],
        $utilisateurFormatTableau['nomBaseDeDonnees'],
        $utilisateurFormatTableau['prenomBaseDeDonnees']
    );
    echo "<h4>" . "Premier utilisateur fetch : " . $utilisateur . "</h4>\n";
}

// ---------

$pdoStatement = $pdo->query("SELECT * FROM utilisateur");

echo "<h3>Liste des utilisateurs : </h3>";
echo "<ul>\n";
foreach ($pdoStatement as $utilisateurFormatTableau) {
    $utilisateur = new Utilisateur(
        $utilisateurFormatTableau['loginBaseDeDonnees'],
        $utilisateurFormatTableau['nomBaseDeDonnees'],
        $utilisateurFormatTableau['prenomBaseDeDonnees']
    );

    echo "<li>" . $utilisateur . "</li>\n";
}
echo "</ul>\n";

// ---------

$utilisateurs = Utilisateur::recupererUtilisateurs();

if (!empty($utilisateurs)) {
    echo "<h4>Liste des utilisateurs :</h4>\n";
} else {
    echo "<h4>Il n'y a aucun utilisateur</h4>";
}

foreach ($utilisateurs as $utilisateur) {
    echo "<p>$utilisateur</p>";
}