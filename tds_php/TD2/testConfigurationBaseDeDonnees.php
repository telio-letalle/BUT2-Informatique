<?php

// On inclut les fichiers de classe PHP pour pouvoir se servir de la classe ConfigurationBaseDeDonnees.
// require_once évite que ConfigurationBaseDeDonnees.php soit inclus plusieurs fois,
// et donc que la classe ConfigurationBaseDeDonnees soit déclaré plus d'une fois.
require_once 'ConfigurationBaseDeDonnees.ini';

$configurationBaseDeDonnees = parse_ini_file(
    'ConfigurationBaseDeDonnees.ini',
    false,
    INI_SCANNER_RAW
);

$nomHote = $configurationBaseDeDonnees['nomHote'];
$port = $configurationBaseDeDonnees['port'];
$nomBaseDeDonnees = $configurationBaseDeDonnees['nomBaseDeDonnees'];
$login = $configurationBaseDeDonnees['login'];
$motDePasse = $configurationBaseDeDonnees['motDePasse'];

// On affiche les informations de la base de donnees
echo $nomHote;
echo $port;
echo $nomBaseDeDonnees;
echo $login;
echo $motDePasse;

?>