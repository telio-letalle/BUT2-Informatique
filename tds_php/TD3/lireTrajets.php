<?php

require_once 'Trajet.php';

$pdo = ConnexionBaseDeDonnees::getPdo();



$trajets = Trajet::recupererTrajets();

if (!empty($trajets)) {
    echo "<h4>Liste des trajets :</h4>\n";
} else {
    echo "<h4>Il n'y a aucun trajet</h4>";
}

foreach ($trajets as $trajet) {
    echo "<p>$trajet</p>";
}