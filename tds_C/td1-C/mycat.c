#include <unistd.h>
#include <stdio.h>
#include <fcntl.h>
#include <sys/stat.h>

#define BUF_SIZE 1024

// ssize_t read(int fildes, void *buf, size_t nbyte);

int main (int argc, char** argv) {
    printf("hello\n");

    ssize_t n;
    char buffer[BUF_SIZE];

    if (argc < 2)
    {
        while ((n = read(0, buffer, BUF_SIZE)) != 0) {
            write(1, buffer, n);
        }
    }
    else if (argc == 2)
    {
        int fd_in = open(argv[1], O_RDONLY);
        if (fd_in == -1) return 1;

        while ((n = read(fd_in, buffer, BUF_SIZE)) != 0) {
            write(1, buffer, n);
        }
        close(fd_in);
    }
    else if (argc == 3)
    {
        int fd_in = open(argv[1], O_RDONLY);
        if (fd_in == -1)
        {
            perror("Erreur ouverture");
            return 1;
        }

        int fd_out = open(argv[2], O_WRONLY | O_CREAT | O_TRUNC, 0644);
        if (fd_out == -1)
        {
            perror("Erreur écriture");
            return 1;
        }

        while ((n = read(fd_in, buffer, BUF_SIZE)) != 0) {
            write(fd_out, buffer, n);
        }
        close(fd_in);
        close(fd_out);
    }
    else
    {
        return 1;
    }
}