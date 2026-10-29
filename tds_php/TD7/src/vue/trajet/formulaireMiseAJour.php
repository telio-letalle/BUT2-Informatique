<?php
/**
 * @var $trajet
 */
$id = htmlspecialchars((string) $trajet->getId(), ENT_QUOTES, 'UTF-8');
$depart = htmlspecialchars($trajet->getDepart(), ENT_QUOTES, 'UTF-8');
$arrivee = htmlspecialchars($trajet->getArrivee(), ENT_QUOTES, 'UTF-8');
$date = $trajet->getDate()->format('Y-m-d');
$prix = htmlspecialchars((string) $trajet->getPrix(), ENT_QUOTES, 'UTF-8');
$conducteurLogin = htmlspecialchars(
    $trajet->getConducteur()->getLogin(),
    ENT_QUOTES,
    'UTF-8'
);
?>

<form method="GET" action="controleurFrontal.php">
    <fieldset>
        <legend>Modifier un trajet</legend>

        <input type="hidden" name="controleur" value="trajet">
        <input type="hidden" name="action" value="mettreAJour">
        <input type="hidden" name="id" value="<?= $id ?>">

        <p>
            <label for="depart_id">Départ</label>
            <input
                type="text"
                name="depart"
                id="depart_id"
                value="<?= $depart ?>"
                required
            >
        </p>

        <p>
            <label for="arrivee_id">Arrivée</label>
            <input
                type="text"
                name="arrivee"
                id="arrivee_id"
                value="<?= $arrivee ?>"
                required
            >
        </p>

        <p>
            <label for="date_id">Date</label>
            <input
                type="date"
                name="date"
                id="date_id"
                value="<?= $date ?>"
                required
            >
        </p>

        <p>
            <label for="prix_id">Prix</label>
            <input
                type="number"
                name="prix"
                id="prix_id"
                value="<?= $prix ?>"
                min="0"
                required
            >
        </p>

        <p>
            <label for="conducteurLogin_id">Login du conducteur</label>
            <input
                type="text"
                name="conducteurLogin"
                id="conducteurLogin_id"
                value="<?= $conducteurLogin ?>"
                required
            >
        </p>

        <p>
            <label for="nonFumeur_id">Non-fumeur</label>
            <input
                type="checkbox"
                name="nonFumeur"
                id="nonFumeur_id"
                value="1"
                <?= $trajet->isNonFumeur() ? 'checked' : '' ?>
            >
        </p>

        <p>
            <input type="submit" value="Modifier le trajet">
        </p>
    </fieldset>
</form>