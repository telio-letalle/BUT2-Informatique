package fr.umontpellier.iut.document;

public class Document {

    private String texte;

    public Document() {
        this.texte = "";
    }
	
    public String getTexte() {
        return texte;
    }

    public void setTexte(String texte) {
        this.texte = texte;
    }

    public void ajouter(String texte) {
        this.texte += texte;
    }

    public void remplacer(int debut, int fin, String remplacement) {
        String partieGauche = texte.substring(0, debut);
        String partieDroite = texte.substring(fin + 1);
        texte = partieGauche + remplacement + partieDroite;
    }

    public void majuscules(int debut, int fin) {
        String txt = texte.substring(debut, fin);
        remplacer(debut, fin, txt.toUpperCase());
    }
    public void minuscules(int debut, int fin) {
        String txt = texte.substring(debut, fin);
        remplacer(debut, fin, txt.toLowerCase());
    }

    public void effacer(int debut, int fin) {
        String txt = texte.substring(debut, fin);
        remplacer(debut, fin, " ");
    }
    public void clear() {
        this.texte="";
    }

    public void inserer(int position, String texte) {
        String partieGauche = texte.substring(0, position);
        String partieDroite = texte.substring(position);
        texte = partieGauche + texte + partieDroite;
    }

    @Override
    public String toString() {
        return this.texte;
    }
}
