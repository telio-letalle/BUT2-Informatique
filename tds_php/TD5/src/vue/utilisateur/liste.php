<?php
/** @var ModeleUtilisateur[] $utilisateurs */
echo "<h1>Liste des utilisateurs</h1>";
echo "<ol>";
foreach ($utilisateurs as $utilisateur) {
    $loginHTML = $utilisateur->getLogin();
    $loginURL = rawurlencode($loginHTML);
    echo "<li>Utilisateur de login "
            . htmlspecialchars($loginHTML, ENT_QUOTES)
            . " <a href='controleurFrontal.php?action=afficherDetail&loginBaseDeDonnees="
            . $loginURL
            . "'>" . "(+ d'info)" . "</a></li>";
    }
echo "</ol>";
?>
<a href="controleurFrontal.php?action=afficherFormulaireCreation">Créer un utilisateur</a>
