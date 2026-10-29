<?php

require_once __DIR__ . '/../src/Lib/Psr4AutoloaderClass.php';

use App\Covoiturage\Lib\Psr4AutoloaderClass;
use App\Covoiturage\Controleur\ControleurUtilisateur;

$chargeurDeClasse = new Psr4AutoloaderClass(false);
$chargeurDeClasse->register();
$chargeurDeClasse->addNamespace('App\Covoiturage', __DIR__ . '/../src');

$action = $_GET['action'] ?? 'afficherListe';
$controleur = $_GET['controleur'] ?? 'utilisateur';

$nomDeClasseControleur = 'App\Covoiturage\Controleur\Controleur'
    . ucfirst($controleur);

if (class_exists($nomDeClasseControleur)) {
    if (in_array($action, get_class_methods($nomDeClasseControleur))) {
        $nomDeClasseControleur::$action();
    } else {
        App\Covoiturage\Controleur\ControleurUtilisateur::afficherErreur(
            "Action inconnue"
        );
    }
} else {
    App\Covoiturage\Controleur\ControleurUtilisateur::afficherErreur(
        "Contrôleur inconnu"
    );
}
?>
