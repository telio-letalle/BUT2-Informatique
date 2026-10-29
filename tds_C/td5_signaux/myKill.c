#define _POSIX_C_SOURCE 200809L

#include <stdio.h>
#include <stdlib.h>
#include <signal.h>
#include <sys/types.h>
#include <errno.h>
#include <limits.h>

int main(int argc, char *argv[])
{
    char *fin;

    errno = 0;
    long pid = strtol(argv[1], &fin, 10);

    errno = 0;
    long sig = strtol(argv[2], &fin, 10);

    if (kill((pid_t)pid, (int)sig) == -1) {
        perror("Erreur lors de l'envoi du signal");
        return EXIT_FAILURE;
    }

    printf("Signal %ld envoyé au processus %ld.\n", sig, pid);
    return EXIT_SUCCESS;
}