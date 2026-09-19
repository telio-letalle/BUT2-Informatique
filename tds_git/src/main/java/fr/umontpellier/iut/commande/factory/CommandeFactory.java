package fr.umontpellier.iut.commande.factory;

import fr.umontpellier.iut.commande.Commande;
import fr.umontpellier.iut.commande.CommandeAjouter;
import fr.umontpellier.iut.commande.CommandeMajuscules;
import fr.umontpellier.iut.commande.CommandeRemplacer;
import fr.umontpellier.iut.commande.CommandeEffacer;
import fr.umontpellier.iut.commande.CommandeInserer;
import fr.umontpellier.iut.document.Document;

public class CommandeFactory {

    private static CommandeFactory instance;

    public static CommandeFactory getInstance() {
        if(instance == null) {
            instance = new CommandeFactory();
        }
        return instance;
    }

    private CommandeFactory() {}

    public Commande createCommand(String name, Document document, String[] parameters) {
        return switch (name) {
            case "ajouter" -> new CommandeAjouter(document, parameters);
            case "remplacer" -> new CommandeRemplacer(document, parameters);
            case "majuscules" -> new CommandeMajuscules(document, parameters);
            case "effacer" -> new CommandeEffacer(document, parameters);
            case "minuscules" -> new CommandeMinuscules(document, parameters);
            case "inserer" -> new CommandeInserer(document, parameters);
            default -> null;
        };
    }

}
