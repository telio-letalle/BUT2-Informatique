<form method="get" action="controleurFrontal.php">
    <input type="hidden" name="controleur" value="preference">
    <input type="hidden" name="action" value="enregistrerPreference">

    <fieldset>
        <legend>Choisir le contrôleur par défaut</legend>

        <input
            type="radio"
            id="utilisateurId"
            name="controleur_defaut"
            value="utilisateur"
            <?= ($preference ?? null) === 'utilisateur' ? 'checked' : '' ?>
            required
        >
        <label for="utilisateurId">Utilisateur</label>

        <input
            type="radio"
            id="trajetId"
            name="controleur_defaut"
            value="trajet"
            <?= ($preference ?? null) === 'trajet' ? 'checked' : '' ?>
            required
        >
        <label for="trajetId">Trajet</label>

        <button type="submit">Enregistrer</button>
    </fieldset>
</form>