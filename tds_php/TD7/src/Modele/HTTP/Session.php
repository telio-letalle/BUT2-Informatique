<?php

namespace App\Covoiturage\Modele\HTTP;

use Exception;

class Session
{
    private static ?Session $instance = null;

    /**
     * @throws Exception
     */
    private function __construct()
    {
        if (session_start() === false) {
            throw new Exception("La session n'a pas réussi à démarrer.");
        }
    }

    public static function getInstance(): Session
    {
        if (is_null(Session::$instance))
            Session::$instance = new Session();
        return Session::$instance;
    }

    public function contient(string $nom): bool
    {
        // À compléter
    }

    public function enregistrer(string $nom, mixed $valeur): void
    {
        // À compléter
    }

    public function lire(string $nom): mixed
    {
        // À compléter
    }

    public function supprimer(string $nom): void
    {
        // À compléter
    }

    public function detruire() : void
    {
        Cookie::supprimer(session_name(), "/"); // supprime le cookie de session
        session_unset();     // vide $_SESSION, equivalent à $_SESSION = []
        session_destroy();   // supprime les données de session stockées
        Session::$instance = null;
    }
}