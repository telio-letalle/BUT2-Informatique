<?php
require_once 'ControleurUtilisateur.php';
// On récupère l'action passée dans l'URL
$action = $_GET['action'];
// Appel de la méthode statique $action de ControleurUtilisateur
ControleurUtilisateur::$action();
?>