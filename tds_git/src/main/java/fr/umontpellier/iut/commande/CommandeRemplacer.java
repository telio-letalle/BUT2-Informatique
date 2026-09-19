package fr.umontpellier.iut.commande;

import fr.umontpellier.iut.document.Document;

public class CommandeRemplacer extends CommandeDocument {


    public CommandeRemplacer(Document document, String[] parametres) {
        super(document, parametres);
    }

    @Override
    public void executer() {
        if(parametres.length < 4) {
            System.err.println("Format attendu :  remplacer;debut;fin;chaine");
            return;
        }
        Integer debut = Integer.parseInt(parametres[1]);
        Integer fin = Integer.parseInt(parametres[2]);
        String texte = parametres[3];
        this.document.remplacer(debut, fin, texte);
        super.executer();
    }

    @Override
    public void decrireCommande() {
        System.out.println("Remplace du texte dans le document, paramètres : " + Arrays.toString(parametres));
    }
}
