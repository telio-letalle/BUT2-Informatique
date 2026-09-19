package fr.umontpellier.iut.commande;

import fr.umontpellier.iut.document.Document;

public class CommandeMinuscules extends CommandeDocument {


    public CommandeMinuscules(Document document, String[] parametres) {
        super(document, parametres);
    }

    @Override
    public void executer() {
        if(parametres.length < 3) {
            System.err.println("Format attendu :   minuscules;debut;fin");
            return;
        }
        Integer debut = Integer.parseInt(parametres[1]);
        Integer fin = Integer.parseInt(parametres[2]);
        this.document.minuscules(debut, fin);
        super.executer();
    }

}
