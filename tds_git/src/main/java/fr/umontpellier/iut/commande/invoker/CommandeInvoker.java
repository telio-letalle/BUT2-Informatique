package fr.umontpellier.iut.commande.invoker;

import fr.umontpellier.iut.commande.Commande;

public class CommandeInvoker {

    private static CommandeInvoker instance;

    public static synchronized CommandeInvoker getInstance() {
        if(instance == null) {
            instance = new CommandeInvoker();
        }
        return instance;
    }

    private CommandeInvoker() {}

    public void executer(Commande commande) {
        commande.executer();
    }
}
