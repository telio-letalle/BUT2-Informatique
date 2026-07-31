<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title> Mon premier php </title>
    </head>

    <body>
        Voici le résultat du script PHP :
        <?php
            // Ceci est un commentaire PHP sur une ligne
            /* Ceci est le 2ème type de commentaire PHP
            sur plusieurs lignes */

            // On met la chaine de caractères "hello" dans la variable 'texte'
            // Les noms de variable commencent par $ en PHP
            $texte = "hello world !";

            // On écrit le contenu de la variable 'texte' dans la page Web
            echo $texte;
            echo "<br><br>\n";


            $prenom = "Marc";

            echo "Bonjour\n " . $prenom; // 1°, concatène la chaine et la variable
            echo "Bonjour\n $prenom"; // 1° same

            echo 'Bonjour\n $prenom'; // renvoie directement le tout sous la forme d'une chaine

            echo $prenom; // 2°, renvoie le prenom
            echo "$prenom"; // 2° same
            echo "<br><br>\n";


            $utilisateur = array(
                    'prenom' => 'Juste',
                    'nom'    => 'Leblanc'
            );
            // $utilisateur = [
            //        'prenom' => 'Juste',
            //        'nom'    => 'Leblanc'
            // ];
            $utilisateur['passion'] = 'maquettes en allumettes';
            $utilisateur[] = "Nouvelle valeur";


            // Syntaxe avec {$...}
            echo "Je m'appelle {$utilisateur['nom']}";
            // Syntaxe simplifiée
            // Attention, pas de guillemets autour de la clé "nom"
            echo "Je m'appelle  $utilisateur[nom]";
            echo "<br><br>\n";


            foreach ($utilisateur as $cle => $valeur) {
                echo "$cle : $valeur<br>";
            }
            for ($i = 0; $i < count($utilisateur); $i++) {
                // echo $utilisateur[$i]; // fonctionne si le tableau est uniquement indexé par des entiers
            }
            echo "<br><br>\n";


            $nom = "Letalle";
            $prenom = "Télio";
            $login = "letallet";
            echo "<p>Utilisateur $nom $prenom de login $login</p>\n";

            $utilisateur2 = [
                    'nom' => 'Letalle',
                    'prenom' => 'Martin',
                    'login' => 'letallem'
            ];
            var_dump($utilisateur2);
            echo "<p>Utilisateur $utilisateur2[nom] $utilisateur2[prenom] de login $utilisateur2[login]</p>";

            $utilisateurs = [
                    [
                            'prenom' => 'Juste',
                            'nom' => 'Leblanc',
                            'login' => 'jleblanc'
                    ],
                    [
                            'prenom' => 'Jean',
                            'nom' => 'Dupont',
                            'login' => 'jdupont'
                    ]
            ];
            var_dump($utilisateurs);
            if (empty($utilisateurs)) {
                echo "<h4>Il n'y a aucun utilisateur</h4>\n";
            } else {
                echo "<h4>Liste des utilisateurs :</h4>";
                echo "<ul>\n";
                foreach ($utilisateurs as $cle => $valeur) {
                    echo "<li>Utilisateur $valeur[nom] $valeur[prenom] de login $valeur[login]</li>";
                }
                echo "</ul>\n";
            }
        ?>
    </body>
</html>