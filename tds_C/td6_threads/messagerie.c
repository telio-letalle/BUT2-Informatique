#include <fcntl.h>
#include <pthread.h>
#include <stdio.h>
#include <stdlib.h>
#include <unistd.h>

#define BUFFER_SIZE 1024

void *tache_lecture_pipe(void *arg) {
    const char *nom = (const char *)arg;
    int pipe_in = open(nom, O_RDONLY);
    if (pipe_in == -1) {
        perror(nom);
        return NULL;
    }

    char buffer[BUFFER_SIZE];
    ssize_t nb_read;
    while ((nb_read = read(pipe_in, buffer, BUFFER_SIZE)) > 0) {
        write(1, buffer, nb_read);
    }

    close(pipe_in);
    return NULL;
}

void *tache_lecture_stdin(void *arg) {
    const char *nom = (const char *)arg;
    int pipe_out = open(nom, O_WRONLY);
    if (pipe_out == -1) {
        perror(nom);
        return NULL;
    }

    char buffer[BUFFER_SIZE];
    ssize_t nb_read;
    while ((nb_read = read(0, buffer, BUFFER_SIZE)) > 0) {
        write(pipe_out, buffer, nb_read);
    }

    close(pipe_out);
    return NULL;
}

int main(int argc, char const *argv[]) {
    if (argc != 3) {
        printf("Utilisation : %s tube_entree tube_sortie\n", argv[0]);
        return 1;
    }

    pthread_t thread1, thread2;

    pthread_create(&thread1, NULL, tache_lecture_pipe, (void *)argv[1]);
    pthread_create(&thread2, NULL, tache_lecture_stdin, (void *)argv[2]);

    pthread_join(thread1, NULL);
    pthread_join(thread2, NULL);

    return 0;
}