<?php

require_once "ConnexionBaseDeDonnees.php";

// On affiche un attribut de PDO pour vérifier  que la connexion est bien établie.
// Cela renvoie par ex. "webinfo.iutmontp.univ-montp2.fr via TCP/IP"
// mais surtout pas de message d'erreur
// SQLSTATE[HY000] [1045] Access denied for user ... (mauvais mot de passe)
// ou
// SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed (mauvais nom d'hôte)

echo ConnexionBaseDeDonnees::getPdo()
    ->getAttribute(PDO::ATTR_CONNECTION_STATUS);

//$model = new ConnexionBaseDeDonnees();
//echo $model->getPdo()->getAttribute(PDO::ATTR_CONNECTION_STATUS);
// Fatal error: Uncaught Error: Call to private ConnexionBaseDeDonnees::__construct() from global scope in /var/www/html/tds-php/TD2/testConnexionBaseDeDonnees.php:12 Stack trace: #0 {main} thrown in /var/www/html/tds-php/TD2/testConnexionBaseDeDonnees.php on line 12

?>