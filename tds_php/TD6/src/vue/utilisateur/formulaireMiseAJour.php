<?php
/**
 * @var Utilisateur $utilisateur
 */
$loginHTML = $utilisateur->getLogin();
$nomHTML = $utilisateur->getNom();
$prenomHTML = $utilisateur->getPrenom();
?>

<body>
    <form method="GET" action= "controleurFrontal.php">
        <fieldset>
            <legend>Modifier mes informations :</legend>
            <p class="InputAddOn">
                <input class="InputAddOn-field" type='hidden' name='controleur' value='utilisateur'>
            </p>
            <p class="InputAddOn">
                <input class="InputAddOn-field" type='hidden' name='action' value='mettreAJour'>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="login_id">Login</label>
                <input class="InputAddOn-field" type="text" value='<?= htmlspecialchars($loginHTML) ?>' name="login" id="login_id" required readonly/>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="nom_id">Nom</label>
                <input class="InputAddOn-field" type="text" value='<?= htmlspecialchars($nomHTML) ?>' name="nom" id="nom_id" required/>
            </p>
            <p class="InputAddOn">
                <label class="InputAddOn-item" for="prenom_id">Prénom</label>
                <input class="InputAddOn-field" type="text" value='<?= htmlspecialchars($prenomHTML) ?>' name="prenom" id="prenom_id" required/>
            </p>
            <p class="InputAddOn">
                <input class="InputAddOn-field" type="submit" value="Envoyer" />
            </p>
        </fieldset>
    </form>
</body>