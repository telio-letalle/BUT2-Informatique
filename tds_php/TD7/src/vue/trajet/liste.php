<?php
/** @var Trajet[] $trajets */
echo "<h1>Liste des trajets</h1>";
echo "<ol>";
foreach ($trajets as $trajet) {
    $id = (string) $trajet->getId();
    $idHTML = htmlspecialchars($id, ENT_QUOTES, 'UTF-8');
    $idURL = rawurlencode($id);

    echo "<li>Trajet d'id " . $idHTML;

    echo " <a href='controleurFrontal.php?controleur=trajet&action=afficherDetail&id="
            . $idURL
            . "'>(+ d'info)</a>";

    echo " <a href='controleurFrontal.php?controleur=trajet&action=afficherFormulaireMiseAJour&id="
            . $idURL
            . "'>Modifier</a>";

    echo " <a href='controleurFrontal.php?controleur=trajet&action=supprimer&id="
            . $idURL
            . "'>Supprimer</a>";

    echo "</li>";
}
echo "</ol>";
?>

<a href="controleurFrontal.php?controleur=trajet&action=afficherFormulaireCreation">
    Créer un trajet
</a>
