<?php

require_once __DIR__ . '/../credentials.php';

class ConfigurationBaseDeDonnees {

    static private array $configurationBaseDeDonnees = array(
        'nomHote' => 'localhost', // webinfo.iutmontp.univ-montp2.fr (serveur à l'iut)
        'nomBaseDeDonnees' => 'letallet',
        'port' => '3306', // 3316 (port à l'iut)
        'login' => LOGIN_BDD,
        'motDePasse' => MDP_BDD
    );

    static public function getLogin() : string {
        // L'attribut statique $configurationBaseDeDonnees
        // s'obtient avec la syntaxe ConfigurationBaseDeDonnees::$configurationBaseDeDonnees
        // au lieu de $this->configurationBaseDeDonnees pour un attribut non statique
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['login'];
    }

    static public function getNomHote() : string {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['nomHote'];
    }

    static public function getPort() : string {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['port'];
    }

    static public function getNomBaseDeDonnees() : string {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['nomBaseDeDonnees'];
    }

    static public function getMotDePasse() : string {
        return ConfigurationBaseDeDonnees::$configurationBaseDeDonnees['motDePasse'];
    }

}