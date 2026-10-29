<?php

namespace App\Covoiturage\Controleur;

use App\Covoiturage\Lib\GestionPreferenceControleur;

class ControleurPreference extends ControleurGenerique
{
    public static function afficherFormulairePreference(): void
    {
        $preference = GestionPreferenceControleur::existe()
            ? GestionPreferenceControleur::lire()
            : null;

        self::afficherVue(
            'vueGenerale.php',
            [
                "titre" => "Préférences",
                "preference" => $preference,
                "cheminCorpsVue" => "preference/formulairePreference.php"
            ]
        );
    }

    public static function enregistrerPreference(): void
    {
        $preference = $_GET['controleur_defaut'] ?? '';

        if (!in_array($preference, ['utilisateur', 'trajet'], true)) {
            self::afficherErreur("Préférence invalide");
            return;
        }

        GestionPreferenceControleur::enregistrer($preference);

        self::afficherVue(
            'vueGenerale.php',
            [
                "titre" => "Préférence enregistrée",
                "cheminCorpsVue" => "preference/preferenceEnregistree.php"
            ]
        );
    }

    public static function afficherErreur(string $messageErreur = ""): void
    {
        self::afficherVue(
            'vueGenerale.php',
            [
                "messageErreur" => $messageErreur,
                "titre" => "Erreur",
                "cheminCorpsVue" => "utilisateur/erreur.php"
            ]
        );
    }
}