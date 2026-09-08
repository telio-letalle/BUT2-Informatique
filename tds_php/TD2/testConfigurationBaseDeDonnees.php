<?php

// On inclut les fichiers de classe PHP pour pouvoir se servir de la classe ConfigurationBaseDeDonnees.
// require_once évite que ConfigurationBaseDeDonnees.php soit inclus plusieurs fois,
// et donc que la classe ConfigurationBaseDeDonnees soit déclaré plus d'une fois.
require_once 'ConfigurationBaseDeDonnees.php';

// On affiche les informations de la base de donnees
echo ConfigurationBaseDeDonnees::getNomHote();
echo ConfigurationBaseDeDonnees::getPort();
echo ConfigurationBaseDeDonnees::getNomBaseDeDonnees();
echo ConfigurationBaseDeDonnees::getLogin();
echo ConfigurationBaseDeDonnees::getMotDePasse();

?>