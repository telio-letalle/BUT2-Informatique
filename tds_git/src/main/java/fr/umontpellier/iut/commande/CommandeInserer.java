package fr.umontpellier.iut.commande;

import fr.umontpellier.iut.document.Document;

public class CommandeInserer extends CommandeDocument {


    public CommandeInserer(Document document, String[] parametres) {
        super(document, parametres);
    }

    @Override
    public void executer() {
        if(parametres.length < 2) {
            System.err.println("Format attendu : inserer;position;texte");
            return;
        }
        String texte = parametres[2];
        int index = Integer.parseInt(parametres[1]);

        this.document.inserer(index, texte);
        super.executer();
    }

}
