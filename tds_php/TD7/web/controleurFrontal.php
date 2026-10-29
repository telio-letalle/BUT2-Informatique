<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Covoiturage\Lib\Psr4AutoloaderClass;
use App\Covoiturage\Lib\GestionPreferenceControleur;
use App\Covoiturage\Controleur\ControleurUtilisateur;

$chargeurDeClasse = new Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');

$action = $_GET['action'] ?? 'afficherListe';

if (isset($_GET['controleur'])) {
    $controleur = $_GET['controleur'];
} elseif (GestionPreferenceControleur::existe()) {
    $controleur = GestionPreferenceControleur::lire();
} else {
    $controleur = 'utilisateur';
}

$nomDeClasseControleur = 'App\Covoiturage\Controleur\Controleur'
    . ucfirst($controleur);

if (class_exists($nomDeClasseControleur)) {
    if (in_array($action, get_class_methods($nomDeClasseControleur))) {
        $nomDeClasseControleur::$action();
    } else {
        ControleurUtilisateur::afficherErreur("Action inconnue");
    }
} else {
    ControleurUtilisateur::afficherErreur("Contrôleur inconnu");
}