package fr.umontpellier.iut.commande;

import fr.umontpellier.iut.document.Document;

public class CommandeAjouter extends CommandeDocument {


    public CommandeAjouter(Document document, String[] parametres) {
        super(document, parametres);
    }

    @Override
    public void executer() {
        if(parametres.length < 2) {
            System.err.println("Format attendu : ajouter;texte");
            return;
        }
        String texte = parametres[1];
        this.document.ajouter(texte);
        super.executer();
    }

    @Override
    public void decrireCommande() {
        System.out.println("Ajout de texte dans le document, paramètres : " + Arrays.toString(parametres));
    }

}
