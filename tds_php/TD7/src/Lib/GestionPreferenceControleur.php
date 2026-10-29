<?php

namespace App\Covoiturage\Lib;

use App\Covoiturage\Modele\HTTP\Cookie;

class GestionPreferenceControleur
{
    private static string $clePreference = "preferenceControleur";

    public static function enregistrer(string $preference): void
    {
        Cookie::enregistrer(
            self::$clePreference,
            $preference
        );
    }

    public static function lire(): string
    {
        return Cookie::lire(self::$clePreference);
    }

    public static function existe(): bool
    {
        return Cookie::contient(self::$clePreference);
    }

    public static function supprimer(): void
    {
        Cookie::supprimer(self::$clePreference);
    }
}