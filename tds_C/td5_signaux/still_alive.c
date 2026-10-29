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