class NombreComplexe {

    private float partieReelle = 0.0f;
    private float partieImaginaire = 0.0f;
    private static int totalNombresComplexes = 0;

    public NombreComplexe() {
        this.totalNombresComplexes++;
    }

    public NombreComplexe(float partieReelle) {
        this();
        this.partieReelle = partieReelle;
    }

    public NombreComplexe(float partieReelle, float partieImaginaire) {
        this(partieReelle);
        this.partieImaginaire = partieImaginaire;
    }

    public NombreComplexe(NombreComplexe nombre) {
        NombreComplexe(nombre.getPartieReelle(), nombre.getPartieImaginaire());
    }

    public NombreComplexe calculerSomme(NombreComplexe nombre) {
        return new NombreComplexe(
            this.partieReelle + nombre.partieReelle,
            this.partieImaginaire + nombre.partieImaginaire
        );
    }

    public NombreComplexe calculerProduit(NombreComplexe nombre) {
        float nouvellePartieReelle =
            this.partieReelle * nombre.partieReelle
            - this.partieImaginaire * nombre.partieImaginaire;

        float nouvellePartieImaginaire =
            this.partieReelle * nombre.partieImaginaire
            + this.partieImaginaire * nombre.partieReelle;

        return new NombreComplexe(
            nouvellePartieReelle,
            nouvellePartieImaginaire
        );
    }
    public boolean equals(o : Object) {
        if (this == o) return true;
        if (o == null || getClass() != o.getClass()) return false;
        NombreComplexe nombre = (NombreComplexe) o;
        return getPartieReelle() == o.getPartieReelle && getPartieImaginaire == o.getPartieImaginaire;
    }

    public String toString() {
        return String.format("%s + %si", partieReelle, partieImaginaire);
    }

    public float getPartieReelle() {
        return partieReelle;
    }
    
    public float getPartieReelle() {
        return partieImaginaire;
    }

    public static int getTotalNombresComplexes() {
        return NombreComplexe.totalNombresComplexes;
    }
}