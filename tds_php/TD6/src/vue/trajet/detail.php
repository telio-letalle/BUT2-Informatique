<?php

/**
 * @var Trajet $trajet
 */

$id = $trajet->getId();
$depart = $trajet->getDepart();
$arrivee = $trajet->getArrivee();
$date = $trajet->getDate();
$dateF = $date->format('d/m/Y');
$prix = $trajet->getPrix();

echo "Le trajet " . htmlspecialchars($id) . " du " . htmlspecialchars($dateF) . " partira de " . htmlspecialchars($depart) . " pour aller à " . htmlspecialchars($arrivee) . " et coute " . htmlspecialchars($prix) . " centimes."

?>