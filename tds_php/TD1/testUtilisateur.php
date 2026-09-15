<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title> testUtilisateur </title>
</head>

<body>
<?php
    require_once "Utilisateur.php";

    $utilisateur1 = new Utilisateur("orila", "Oril", "Anger");
    echo $utilisateur1;

    // $utilisateur2 = new Utilisateur("orila", [], "Anger");
    // echo $utilisateur2;
    // test de type
?>
</body>
</html>