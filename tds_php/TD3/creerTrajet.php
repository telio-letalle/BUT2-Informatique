<?php

require_once 'Trajet.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    var_dump($_POST);

    $depart = $_POST['depart'];
    $arrivee = $_POST['arrivee'];
    $date = $_POST['date'];
    $prix = $_POST['prix'];
    $conducteurLogin = $_POST['conducteurLogin'];
    $nonFumeur = isset($_POST['nonFumeur']);

    $date = new DateTime($date);
    $utilisateur = Utilisateur::recupererUtilisateurParLogin($conducteurLogin);

    $trajet = new Trajet(null, $depart, $arrivee, $date, $prix, $utilisateur, $nonFumeur);
    $trajet->ajouter();

    echo "<p>Le trajet$nonFumeur du {$date->format("d/m/Y")} partira de {$depart} pour aller à {$arrivee} (conducteur: {$utilisateur->getPrenom()} {$utilisateur->getNom()}, prix: {$prix}€).</p>";
}