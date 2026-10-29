<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Covoiturage\Modele\ModeleUtilisateur;
use App\Covoiturage\Lib\Psr4AutoloaderClass;

// initialisation en activant l'affichage de débogage
$chargeurDeClasse = new App\Covoiturage\Lib\Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
// enregistrement d'une association "espace de nom" → "dossier"
$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');

// On récupère l'action passée dans l'URL
$action = $_GET['action'];
// Appel de la méthode statique $action de ControleurUtilisateur
App\Covoiturage\Controleur\ControleurUtilisateur::$action();
?>