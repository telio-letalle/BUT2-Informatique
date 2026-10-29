<?php

namespace App\Covoiturage\Modele\HTTP;

class Cookie
{
    public static function enregistrer(string $cle, mixed $valeur, ?int $dureeExpiration = null): void {
        $valeurSerializee = serialize($valeur);

        if ($dureeExpiration === null) {
            setcookie($cle, $valeurSerializee);
        } else {
            setcookie($cle, $valeurSerializee, [
                "expires" => time() + $dureeExpiration
            ]);
        }
    }

    public static function lire(string $cle): mixed {
        return unserialize($_COOKIE[$cle]);
    }

    public static function contient(string $cle): bool {
        return isset($_COOKIE[$cle]);
    }

    public static function supprimer(string $cle, string $path = ""): void {
        unset($_COOKIE[$cle]);

        setcookie($cle, "", [
            "expires" => 1,
            "path" => $path
        ]);
    }
}