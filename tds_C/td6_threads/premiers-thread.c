#include <stdio.h>
#include <stdlib.h>
#include <pthread.h>
#define NB_THREADS 8

int n;
int compteurs[NB_THREADS] = {0};

int is_prime(int x) {
    if (x < 2) {
        return 0;
    }
    for (int i = 2; i * i <= x; i++) {
        if (x % i == 0) {
            return 0;
        }
    }
    return 1;
}

void *tache(void *arg) {
    int numero = *(int *)arg;

    int debut = numero * n / NB_THREADS;
    int fin = (numero + 1) * n / NB_THREADS;

    for (int i = debut; i < fin; i++) {
        if (is_prime(i)) {
            compteurs[numero]++;
        }
    }

    return NULL;
}

int main(int argc, char const *argv[]) {
    if (argc < 2) {
        printf("Le programme attend un argument.\n");
        return 1;
    }

    n = atoi(argv[1]);

    pthread_t threads[NB_THREADS];
    int numeros[NB_THREADS];

    for (int i = 0; i < NB_THREADS; i++) {
        numeros[i] = i;
        pthread_create(&threads[i], NULL, tache, &numeros[i]);
    }

    for (int i = 0; i < NB_THREADS; i++) {
        pthread_join(threads[i], NULL);
    }

    int pi = 0;

    for (int i = 0; i < NB_THREADS; i++) {
        pi += compteurs[i];
    }

    printf("pi(%d) = %d\n", n, pi);

    return 0;
}
