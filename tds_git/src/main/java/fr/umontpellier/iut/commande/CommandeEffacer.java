package fr.umontpellier.iut.commande;

import fr.umontpellier.iut.document.Document;

public class CommandeEffacer extends CommandeDocument {


    public CommandeEffacer(Document document, String[] parametres) {
        super(document, parametres);
    }

    @Override
    public void executer() {
        if(parametres.length < 4) {
            System.err.println("Format attendu :  effacer;debut;fin;chaine");
            return;
        }
        Integer debut = Integer.parseInt(parametres[1]);
        Integer fin = Integer.parseInt(parametres[2]);
        String texte = parametres[3];
        this.document.effacer(debut, fin, texte);
        super.executer();
    }

    @Override
    public void decrireCommande() {
        System.out.println("Efface du texte dans le document, paramètres : " + Arrays.toString(parametres));
    }
}
