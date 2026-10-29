#include <pthread.h>
#include <stdio.h>

#define NB_CASES 10000
#define NB_THREADS 4

// structure décrivant les arguments passés aux threads
struct ThreadArgs {
    int debut;
    int fin;
    int* tab;
};

/**
 * Tâche exécutée par chaque thread
 *
 * Remarque : La fonction doit recevoir un unique argument de type (void*) et
 * retourner un (void*). Mais un (void*) est simplement un pointeur (sans type
 * associé) donc si on sait quel est le type des données placées à cette
 * adresse, on peut caster le pointeur en un type spécifique pour accéder aux
 * différentes valeurs.
 */
void* tache(void* args) {
    struct ThreadArgs* p = args;  // cast en struct ThreadArgs*
    for (int i = p->debut; i < p->fin; i++) {
        // remarque : p->attr est équivalent à (*p).attr et sert à accéder à un
        // champ d'une structure si on a un pointeur sur cette structure
        p->tab[i] = i * i;
    }
    return NULL;
}

int main(void) {
    int i, tab[NB_CASES];
    pthread_t threads[NB_THREADS];       // tableau des threads
    struct ThreadArgs args[NB_THREADS];  // arguments pour chaque thread

    for (i = 0; i < NB_THREADS; i++) {
        // préparation des arguments du thread
        args[i].debut = i * NB_CASES / NB_THREADS;
        args[i].fin = (i + 1) * NB_CASES / NB_THREADS;
        args[i].tab = tab;
        // création (et exécution) du thread
        pthread_create(&threads[i], NULL, tache, &args[i]);
    }

    // attente de la fin des threads
    for (i = 0; i < NB_THREADS; i++) {
        pthread_join(threads[i], NULL);
    }

    // affichage du contenu du tableau
    for (i = 0; i < NB_CASES; i++) {
        printf("%d ", tab[i]);
    }
    printf("\n");

    return 0;
}
