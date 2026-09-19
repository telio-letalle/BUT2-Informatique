package fr.umontpellier.iut;

import fr.umontpellier.iut.commande.Commande;
import fr.umontpellier.iut.commande.invoker.CommandeInvoker;
import fr.umontpellier.iut.document.Document;
import fr.umontpellier.iut.commande.factory.CommandeFactory;

import java.util.Scanner;

public class Main {
    public static void main(String[] args) {
        Scanner scanner = new Scanner(System.in);
        Document document = new Document();
        CommandeInvoker invoker = CommandeInvoker.getInstance();
        CommandeFactory factory = CommandeFactory.getInstance();
        System.out.println("Bienvenue dans l'éditeur de texte!");
        System.out.println("Commencez par exécuter une commande.");
        while(true) {
            String input = scanner.nextLine();
            String[] parameters = input.split(";");
            String nomCommande = parameters[0];
            Commande commande = factory.createCommand(nomCommande, document, parameters);
            if(commande != null) {
                invoker.executer(commande);
            }
            else {
                System.err.println("Cette commande n'existe pas!");
            }
            // Ajout commentaire inutile pour commit
            // autre ajout
        }
    }
}