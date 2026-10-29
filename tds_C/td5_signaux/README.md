# TD n°5 - Les signaux

Dans ce TD nous allons manipuler les signaux pour tuer des processus et faire communiquer des processus entre eux.

## Manipulation des signaux en Shell (rappels)

### Envoi de signal avec la commande `kill`

1. Lancez la commande `sleep` pour 100 secondes.

2. Quel est le PID du processus exécuté par la commande `sleep` ?

3. (⭐) En utilisant les commandes `ps`, `grep` et `cut`, affichez le PID du `sleep`.

	**Indice :** Vous pouvez utiliser l’option `-v` de `grep` pour exclure les lignes qui contiennent une expression.

4. Envoyez le signal `SIGINT` (2) au processus `sleep`. Que se passe-t-il ?

    **Remarque :** Vous connaissez au moins 2 façons d'envoyer le signal `SIGINT`.

5. Relancez la commande `sleep` et envoyez-lui le signal «&nbsp;_terminal stop_&nbsp;» `SIGTSTP` (24). Que se passe-t-il ?

    **Remarque :** Vous connaissez au moins 2 façons d'envoyer le signal `SIGTSTP`.

6. Relancez la commande `sleep` et envoyez-lui le signal `SIGKILL` (9). Que se passe-t-il ?

### Signaux et gestion des droits

1. A l’aide de la commande `ps -Al` trouvez le PID et UID du processus `apached`.

	**Remarque :** S'il n'y a pas de processus `apached` en cours d'exécution, vous pouvez par exemple chercher `sshd` ou `systemd` si vous êtes sur une machine _Linux_, ou éventuellement `/usr/libexec/logd` si vous utilisez _Mac OS_.

2. A l’aide du fichier `/etc/passwd`, retrouver à qui correspond cet UID ?

	**Remarque :** Ce fichier n'existe que sous _Linux_.

3. Envoyez le signal `SIGKILL` (9) à ce processus. Que se passe-t-il ?

### Signaux et hiérarchie de processus

1.  Notez le PID du _shell_ de votre terminal.

2.  Lancez la commande `sleep 200` en arrière plan.

3.  Quel est le PPID du processus `sleep` ?

4.  Ouvrez un second terminal. Depuis ce terminal envoyez le signal `SIGKILL` au PID du _shell_ du premier terminal.

5.  Qu’est il arrivé au processus `sleep` ?

6.  Sauvegardez votre travail puis cherchez le PID du processus `initd` à l’aide de la commande `ps −A` puis envoyez-lui le signal `SIGKILL` (9).

## Programmation C

### Envoyer des signaux

1. À l’aide de l'appel système `int kill(pid_t pid, int sig)` en C, écrivez le programme `myKill.c` qui prend exactement 2 arguments :

    - le PID du processus à qui envoyer le signal
    - le numéro du signal à envoyer

    **Indication :** Vous pouvez obtenir des informations sur l'appel système `kill` à l'aide de la commande `man 2 kill`.

2. Testez le programme `myKill.c` sur un processus `sleep` (comme dans la première partie du TP).

### Capturer les signaux

Jusqu'à présent, nous avons surtout utilisé les signaux pour interrompre des processus, mais les signaux peuvent aussi servir à communiquer des messages entre processus.

Le programme `still_alive.c` illustre comment capturer un signal en C à l'aide de la fonction `signal`. L’appel `signal(n, &f)` permet de déclencher un appel à la fonction `f` lorsque le signal numéro `n` est reçu (la fonction `f` attend un argument de type `int` qui est le numéro du signal effectivement reçu) :

```c
#include <fcntl.h>
#include <signal.h>
#include <stdbool.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

void handler_sigint(int code) {
    fprintf(stderr, ">>> Signal SIGINT reçu (%d)\n", code);
}

void handler_sighup(int code) {
    fprintf(stderr, ">>> Signal SIGHUP reçu (%d)\n", code);
}

int main(int argc, char *argv[]) {
    // On enregistre le gestionnaire de signaux
    signal(SIGINT, &handler_sigint);
    signal(SIGHUP, &handler_sighup);

    char buffer[256];
    FILE *fd = fopen("still_alive.txt", "r");
    while (!feof(fd)) {
        // lecture et affichage d'une ligne du fichier
        fgets(buffer, 256, fd);
        printf("%s", buffer);
        usleep(500000);  // attend une demi-seconde
    }
}
```

## Projet : Kenny

1. Écrivez le programme `kenny.c` qui intercepte les signaux et vérifie les spécifications suivantes :

    - Le programme attend un unique paramètre qui est la représentation d'un entier positif qui correspond au nombre initial de points de vie de Kenny.

    - Toutes les 3 secondes, le programme affiche son nombre de points de vie suivi de la phrase «&nbsp;Je suis vivant&nbsp;».

    - Le programme intercepte tous les signaux de 1 à 9. À chaque fois qu’il reçoit un signal il affiche le message ≪ c’est trop injuste ≫ et décrémente ses points de vie d'une valeur égale au numéro du du signal reçu.

    - S'il n'a plus de points de vie, il meurt.

### Jouons un peu avec Kenny

1.  Lancez un Kenny avec 20 points de vie.

2.  Attaquez-le avec la commande `kill` et votre programme `myKill` jusqu’à ce que mort s’ensuive.

3.  Lancez un Kenny avec 100 points de vie.

4.  Attaquez le une seule fois avec le signal SIGKILL (9). Que se passe-t-il ?
