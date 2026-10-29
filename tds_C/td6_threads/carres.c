#include <stdio.h>

#define NB_CASES 10000

void tache(int *tab) { int i; }

int main(void) {
    int i, tab[NB_CASES];

    // préparation du tableau contenant les NB_CASES premiers carrés
    for (i = 0; i < NB_CASES; i++) {
        tab[i] = i * i;
    }

    // affichage du contenu du tableau
    for (i = 0; i < NB_CASES; i++) {
        printf("%d ", tab[i]);
    }
    printf("\n");

    return 0;
}