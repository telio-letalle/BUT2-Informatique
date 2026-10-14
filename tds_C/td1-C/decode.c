// Letalle Télio A2 Q5 - TD1

#include <fcntl.h>
#include <stdint.h>
#include <stdio.h>
#include <stdlib.h>
#include <string.h>
#include <sys/stat.h>
#include <sys/types.h>
#include <sys/uio.h>
#include <unistd.h>

/**
 * Decompresse les octets contenus dans buffer_in
 *
 * @param buffer_in buffer contenant les octets à décompresser. Les deux
 * premiers octets représentent la taille totale (en octets) des données
 * décompressées
 * @param buffer_out buffer où écrire les données décompressées
 * 
 * @return le nombre d'octets décompressés (écrits dans buffer_out)
 */
size_t carmack_decode(unsigned char buffer_in, unsigned char buffer_out)
{
  int i = 2; // indice buffer_in
  int j = 0; // indice buffer_out
  int k; // indice déplacé

  char x;
  char y;
  char tmp;
  int sizeBuffer_in = *(uint16_t *)buffer_in;

  while (j < sizeBuffer_in) {
    x = buffer_in[i++];
    y = buffer_in[i++];

    if (x == 0 && (y == 0xA7 || y == 0xA8))
    {
      // échappement, 0x00A7 0x00A8, on passe x et on recopie yz à l'envers
      tmp = buffer_in[i++];
      buffer_out[j++] = tmp;
      buffer_out[j++] = y;
    }

    else if (y == 0x00A7)
    {
      // pointeur proche: z mots en arriere, copier x mots
      uint8_t offset = buffer_in[i++];
      k = j - (offset * 2); 
      for (z = 0; z < x * 2; z++) {
        buffer_out[j++] = buffer_in[k + z];
      }
      i++;
    }

    else if (y == 0x00A8)
    {
      // pointeur lointain: position absolue w en mots, copier x mots
      uint16_t w = *((uint16_t *)(buffer_in+i));
      i += 2;
      k = w + 2;
      for (int b = 0; b < x * 2; b++) {
        buffer_out[j++] = buffer_out[k + b];
      }
    }
    else
    {
      // mot litteral, 0x...., on recopie dans l'ordre
      buffer_out[j++] = x;
      buffer_out[j++] = y;
    }
  }

  return output_size;
}

int main(int argc, char *argv[])
{
  char buffer_in[98304];
  char buffer_out[65536];

  char buffer[4096];
  int size = 4096;
  
  int fd = open(argv[1], O_RDONLY);
  int fo = open(agrv[2], O_WRONLY);

  while (size != 0) size = read(fd, buffer_in, size);

  carmack_decode(buffer_in, buffer_out);

  write(fo, buffer_out, 65536);
}