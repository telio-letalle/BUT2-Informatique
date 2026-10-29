#define _POSIX_C_SOURCE 200809L

#include <signal.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>
#include <errno.h>
#include <limits.h>
#include <time.h>

static volatile sig_atomic_t degats[10] = {0};

void handler(int sig)
{
    if (sig >= 1 && sig <= 8) {
        degats[sig]++;
    }
}

int main(int argc, char *argv[])
{
    char *fin;

    errno = 0;
    long vies = strtol(argv[1], &fin, 10);

    for (int sig = 1; sig <= 8; sig++) {
        if (signal(sig, handler) == SIG_ERR) {
            perror("Erreur signal");
            return EXIT_FAILURE;
        }
    }

    printf("Kenny démarre avec %ld points de vie.\n", vies);
    fflush(stdout);

    while (vies > 0) {
        printf("%ld points de vie : Je suis vivant\n", vies);
        fflush(stdout);

        struct timespec attente = {3, 0};

        while (nanosleep(&attente, &attente) == -1 &&
               errno == EINTR) {
            /* Reprendre l'attente après un signal. */
        }

        sigset_t ensemble, ancien;
        sigemptyset(&ensemble);

        for (int sig = 1; sig <= 8; sig++) {
            sigaddset(&ensemble, sig);
        }

        sigprocmask(SIG_BLOCK, &ensemble, &ancien);

        int total = 0;

        for (int sig = 1; sig <= 8; sig++) {
            total += sig * degats[sig];
            degats[sig] = 0;
        }

        sigprocmask(SIG_SETMASK, &ancien, NULL);

        if (total > 0) {
            printf("C'est trop injuste !\n");
            vies -= total;

            if (vies <= 0) {
                printf("Kenny est mort !\n");
                fflush(stdout);
                break;
            }
        }
    }

    return EXIT_SUCCESS;
}