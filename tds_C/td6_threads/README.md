# TD n°6 - Processus Légers

## Exercice 1 : Premier exemple

Le programme `carres.c` remplit un tableau de 10000 cases contenant les carrés des premiers entiers. Le tableau est rempli séquentiellement par une boucle `for`.

Le programme `carres-thread.c` effectue la même tâche, mais le tableau est rempli en parallèle par 4 _processus légers_ (ou _threads_), chacun remplissant un quart du tableau.

1. Regardez attentivement le programme `carres-thread.c`. Remarquez en particulier la structure suivante :

    - La tâche à réaliser par les _threads_ est définie par la fonction `tache`. Cette fonction doit recevoir un unique argument de type `(void *)` et renvoyer un résultat de type `(void *)`.
    - Dans la fonction `main`, les nouveaux _threads_ sont lancés par un appel à la fonction `pthread_create`. Cet appel système prend quatre arguments :
        - un pointeur vers une variable de type `pthread_t` qui contiendra les données associées au _thread_ créé ;
        - un pointeur vers une structure de type `pthread_attr_t` qui contient les attributs (ou options) du _thread_ à créer (ici on passe `NULL` pour les attributs par défaut) ;
        - un pointeur vers la fonction qui sera exécutée par le _thread_ (le nom de la fonction) ;
        - un pointeur vers les données (paramètres) du _thread_ qui sera passé à la fonction exécutée par le _thread_.
    - Une fois que les _threads_ sont exécutés, on peut attendre qu'ils terminent leur exécution en utilisant la fonction `pthread_join`.

2. Compilez et exécutez le programme `carres-thread.c`.

    **Attention :** Pour compiler correctement le programme il faut utiliser l'option `-pthread` pour pouvoir utiliser les fonctions définies dans la librairie `pthread.h` ainsi que les variantes des fonctions de la librairie standard compatibles avec l'utilisation de _threads_ (cf. [édition de liens](https://fr.wikipedia.org/wiki/%C3%89dition_de_liens) (ou [_linker_](<https://en.wikipedia.org/wiki/Linker_(computing)>)) et [réentrance](<https://en.wikipedia.org/wiki/Reentrancy_(computing)>)).

## Exercice 2 : Nombres premiers

Le programme `premiers.c` prend en argument un entier _n_ et affiche le nombre de nombres premiers inférieurs ou égaux à _n_ ([fonction _&pi;(n)_](https://fr.wikipedia.org/wiki/Fonction_de_compte_des_nombres_premiers)).

1. Lisez, compilez et exécutez le programme en lui passant en argument différentes valeurs de _n_ (cherchez vers quelle valeur votre ordinateur prend quelques secondes à trouver le résultat).

On veut maintenant écrire le programme `premiers-thread.c` qui effectue la même tâche que le programme `premiers.c`, mais en exécutant 8 _threads_ en parallèle qui se partagent les valeurs à tester de la même manière que ce qui a été fait dans le programme `carres-thread.c` : le premier _thread_ compte le nombre de nombres premiers entre 0 et _n_/8, le deuxième entre _n_/8 et _n_/4, et ainsi de suite.

Il y a plusieurs façons de regrouper les valeurs trouvées par chacun des _threads_ :

-   On peut essayer de faire une variable globale initialisée à 0, et faire en sorte que chacun des _threads_ incrémente cette variable lorsqu'il trouve un nombre premier.

-   On peut préparer un tableau d'entiers et passer à chacun des _threads_ un pointeur vers la case qui lui correspond. Lorsque les _threads_ ont terminé, il suffit de faire la somme des valeurs retournées.

-   Enfin, on peut utiliser la valeur de retour d'un _thread_, qui est un pointeur renvoyé par la fonction exécutée par le _thread_. Ce pointeur peut être récupéré par l'appel à 'pthread_join`.

2. Écrivez le programme `premiers-thread.c` en utilisant la première méthode (qui semble être la plus simple à écrire). Il faut donc définir une variable globale `int pi = 0` (tout au début du programme en dehors de toute fonction) et faire en sorte que chaque _thread_ incrémente cette variable lorsqu'il trouve un nombre premier.

3. Compilez et exécutez le programme `premiers-thread.c` (n'oubliez pas l'option `-pthread`) pour une valeur assez grande de _n_ (celle qui prenait plusieurs secondes en séquentiel). Comparez le temps d'exécution avec le programme séquentiel `premiers.c`.

    **Indication :** Vous pouvez utiliser la commande `time` pour mesurer le temps d'exécution d'un programme (cherchez la signification des différentes valeurs affichées)

4. Exécutez le programme plusieurs fois (toujours sur une valeur assez grande). Comparez les valeurs obtenues (et comparez avec la valeur renvoyée par le programme séquentiel). Vous devriez remarquer que la valeur renvoyée par le programme est souvent légèrement inférieure à celle renvoyée par le programme séquentiel (et que ce n'est pas toujours la même valeur d'une exécution à l'autre). Comment peut-on expliquer ces différences ?

5. Exécutez le programme `premiers-thread.c` sur une très grande valeur de _n_ (pour qu'il mette très longtemps à terminer). Dans un autre terminal, utilisez la commande `top` pour observer le pourcentage d'utilisation CPU du programme en cours d'exécution. Que remarquez-vous ? (interrompez le programme s'il tourne encore avant de passer à la question suivante)

Pour corriger le problème de la question 4, on va modifier le programme pour que les _threads_ n'accèdent plus directement à la même variable globale (2e méthode décrite précédemment)

6. Modifiez le programme `premiers-thread.c` pour qu'il déclare un tableau d'entiers de taille 8 (un entier par _thread_) initialisés à 0 et qu'il passe à chacun des _threads_ un pointeur vers la case du tableau lui correspondant. La fonction exécutée par le _thread_ peut alors incrémenter cette valeur sans risquer des pertes de mises à jour. La fonction `main` peut ensuite afficher la somme des valeurs calculées par chacun des _threads_.

7. Exécutez ce nouveau programme. Vérifiez que la valeur renvoyée est correcte (exécutez-le plusieurs fois). Comparez son temps d'exécution avec les deux précédents.

8. Écrivez la version du programme qui utilise la 3e méthode, c'est-à-dire celle où chaque _thread_ alloue un entier, calcule le nombre de nombres premiers dans son intervalle et renvoie un pointeur vers cet entier. La fonction `main` peut alors récupérer les valeurs calculées en utilisant `pthread_join` pour obtenir le résultat final.

    **Indication :** Il faut faire attention à bien allouer la variable calculée par le _thread_ dans le tas (`malloc`), car il faut que la valeur soit encore disponible lorsque l'exécution de la fonction termine et que la valeur est lue dans la fonction `main`.

## Exercice 2. Messagerie

Comme dans le TD n°4, nous allons ici écrire un programme qui permet à deux processus d'échanger des messages en utilisant des tubes. On veut écrire un unique programme `messagerie.c` qui permet à deux exécutions du programme de communiquer entre elles.

Pour faire communiquer ces deux instances qui seront exécutées séparément (dans des terminaux différents), on utilise des tubes nommés (une meilleure solution serait d'utiliser des _sockets_ mais vous verrez celà plus tard). Il faut utiliser un tube pour chaque sens de communication, donc si on veut que les deux processus puissent librement échanger des messages, il faut créer deux tubes.

1. Créez deux tubes nommés `tube1` et `tube2` dans le répertoire courant en utilisant la commande `mkfifo`. Vérifiez que les tubes ont bien été créés en utilisant la commande `ls`.

Le programme `messagerie.c` est une première tentative de réalisation. Ce programme prend en argument deux noms de tubes nommés : le premier est ouvert en lecture et sert à recevoir les messages de l'autre processus, le second est ouvert en écriture et sert à envoyer des messages à l'autre processus.

La boucle principale du programme (boucle infinie) lit un message dans le tube en entrée et l'affiche dans la sortie standard, puis lit un message entré par l'utilisateur dans l'entrée standard et l'envoie dans le tube en sortie.

2. Lisez le programme `messagerie.c` et compilez-le.

    **Remarque :** Notez l'utilisation de l'option `O_NONBLOCK` pour ouvrir le tube en lecture. Pourquoi utilise-t-on cette option ici ?

3. Exécutez deux instances du programme en leur passant les deux tubes précédemment créés, mais en inversant les noms des tubes pour chaque instance :
    ```bash
    ./a.out tube1 tube2
    ./a.out tube2 tube1
    ```
    Essayez d'envoyer des messages entre les deux processus. Que se passe-t-il ?
    Interrompez les programmes en utilisant (`Ctrl+D` ou `Ctrl+C`).

Pour résoudre le problème précédent, il faut que le programme puisse à la fois surveiller les messages qui arrivent sur le tube pour les afficher dans la sortie standard et surveiller l'entrée standard pour envoyer des messages dans le tube. Pour cela, nous allons utiliser deux _threads_, un pour chacune des tâches.

4. Modifiez le programme `messagerie.c` pour qu'il exécute deux _threads_. Le premier éxécute une tâche `tache_lecture_pipe` qui lit en boucle les messages qui arrivent dans le tube dont le nom est passé en premier argument du programme et les affiche dans la sortie standar. Le second exécute une tâche `tache_lecture_stdin` qui lit en boucle les messages de l'utilisateur sur l'entrée standard et les envoie dans le tube dont le nom est passé en second argument du programme. Le programme `main` se termine lorsque les deux _threads_ ont terminé leur exécution (chacun se termine lorsqu'il n'a plus rien à lire).

5. Compilez et exécutez deux instances du nouveau programme `messagerie.c` dans deux terminaux différents en leur passant les deux tubes créés précédemment (avec des rôles alternés). Vérifiez que vous pouvez envoyer librement des messages d'un terminal à l'autre et qu'ils s'affichent immédiatement.
