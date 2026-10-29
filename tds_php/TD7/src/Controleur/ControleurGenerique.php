<?php

namespace App\Covoiturage\Controleur;

abstract class ControleurGenerique
{
    protected static function afficherVue(string $cheminVue, array $parametres = []): void {
        extract($parametres);

        require __DIR__ . "/../vue/$cheminVue";
    }
}