<form method="GET" action="controleurFrontal.php">
    <fieldset>
        <legend>Créer un trajet</legend>

        <input type="hidden" name="controleur" value="trajet">
        <input type="hidden" name="action" value="creerDepuisFormulaire">

        <p>
            <label for="depart_id">Départ</label>
            <input type="text" name="depart" id="depart_id" required>
        </p>

        <p>
            <label for="arrivee_id">Arrivée</label>
            <input type="text" name="arrivee" id="arrivee_id" required>
        </p>

        <p>
            <label for="date_id">Date</label>
            <input type="date" name="date" id="date_id" required>
        </p>

        <p>
            <label for="prix_id">Prix</label>
            <input type="number" name="prix" id="prix_id" min="0" required>
        </p>

        <p>
            <label for="conducteurLogin_id">Login du conducteur</label>
            <input type="text" name="conducteurLogin" id="conducteurLogin_id" required>
        </p>

        <p>
            <label for="nonFumeur_id">Non-fumeur</label>
            <input type="checkbox" name="nonFumeur" id="nonFumeur_id" value="1">
        </p>

        <p>
            <input type="submit" value="Créer le trajet">
        </p>
    </fieldset>
</form>
