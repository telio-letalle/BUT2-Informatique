#include <stdio.h>
#include <stdlib.h>

/**
 * Teste si un nombre est premier
 *
 * @param x le nombre à tester
 * @return 1 si x est premier, 0 sinon
 */
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

int main(int argc, char const *argv[]) {
    if (argc < 2) {
        printf("Le programme attend un argument.\n");
        return 1;
    }

    int n = atoi(argv[1]);
    int pi = 0;

    for (int i = 2; i <= n; i++) {
        if (is_prime(i)) {
            pi++;
        }
    }

    printf("pi(%d) = %d\n", n, pi);
    return 0;
}
