package fr.umontpellier.iut.tpjdbc;

import javafx.fxml.FXML;
import javafx.scene.control.Alert;
import javafx.scene.control.ButtonType;
import javafx.scene.control.ComboBox;
import javafx.scene.control.TextField;

import java.sql.SQLException;
import java.util.ArrayList;
import java.util.List;
import java.util.Optional;

public class ControleurFenetre {
    //PARTIE 1
    @FXML
    private TextField txtNum, txtNom, txtPrenom, txtNationalite, txtAge;

    private ConnexionBD maConnexionBD;

    //PARTIE 2
    @FXML
    private TextField txtAgeMinimum;

    //PARTIE 3
    @FXML
    private ComboBox<String> cbNationalites;



    //PARTIE 1
    public void initialize() throws SQLException {
        maConnexionBD = new ConnexionBD();
        btPremierClicked();
    }

    public void fermetureFenetre(){
        System.out.println("Fermeture de la fenêtre");
    }

    @FXML
    private void btPremierClicked() throws SQLException {
        System.out.println("Vous avez cliqué sur le bouton Premier");
        Personne p = maConnexionBD.premier();
        btClicked(p);
    }

    @FXML
    private void btPrecedentClicked() throws SQLException {
        System.out.println("Vous avez cliqué sur le bouton Précédent");
        Personne p = maConnexionBD.precedent();
        btClicked(p);
    }

    @FXML
    private void btSuivantClicked() throws SQLException {
        System.out.println("Vous avez cliqué sur le bouton Suivant");
        Personne p = maConnexionBD.suivant();
        btClicked(p);
    }

    @FXML
    private void btDernierClicked() throws SQLException {
        System.out.println("Vous avez cliqué sur le bouton Dernier");
        Personne p = maConnexionBD.dernier();
        btClicked(p);
    }
    private void btClicked(Personne p){
        if (p == null) return;

        txtNum.setText(String.valueOf(p.getNum()));
        txtNom.setText(p.getNom());
        txtPrenom.setText(p.getPrenom());
        txtNationalite.setText(p.getNationalite());
        if (p.getAge()==-1){
            txtAge.setText("inconnu");
        }
        else{
            txtAge.setText(String.valueOf(p.getAge()));
        }
    };
    //PARTIE 2
    @FXML
    private void btRechercherClicked() {
        System.out.println("Vous avez cliqué sur le bouton Rechercher");
        Personne p = maConnexionBD.afficherRecherche(Integer.parseInt((txtAgeMinimum.getText())));
        btClicked(p);
    }

    @FXML
    private void btTousClicked() {
        System.out.println("Vous avez cliqué sur le bouton Tous");
        Personne p = maConnexionBD.afficherTous();
        btClicked(p);
    }

    //PARTIE 3
    @FXML
    private void btMoyenneAgeClicked() throws SQLException {
        String selectedItem = cbNationalites.getValue();
        System.out.println("Bouton moyenne d'âge de nationalité " + selectedItem);
        Alert alert = new Alert(Alert.AlertType.INFORMATION);
        alert.setTitle("Message informatif");
        alert.setHeaderText(null);

        maConnexionBD.lancerCall(selectedItem);
        int moyenne = maConnexionBD.afficherMoyenne();

        String message = "Moyenne d'age des personnes de la nationalité " + moyenne;
        alert.setContentText(message);
        alert.showAndWait();
    }

    @FXML
    private void cbNationalitesShown() {
        System.out.println("Ouverture de la ComboBox");
        List<String> liste = new ArrayList<String>();

        try {
            ArrayList<String> nationalites = maConnexionBD.recupererNationaltes();
            liste.addAll(nationalites);
            remplirCombo(liste);
        } catch (Exception e) {
            throw new RuntimeException(e);
        }
    }

    private void remplirCombo(List<String> liste) {
        cbNationalites.getItems().clear();
        for (String nationalite : liste)
            cbNationalites.getItems().add(nationalite);
    }


    //PARTIE 4
    @FXML
    private void btViderClicked() {
        System.out.println("Vous avez cliqué sur le bouton Vider formulaire");
    }

    @FXML
    private void btEnregistrerClicked() {
        System.out.println("Vous avez cliqué sur le bouton Enregister nouveau");
    }

    @FXML
    private void btModifierClicked() {
        System.out.println("Vous avez cliqué sur le bouton Modifier");
    }

    @FXML
    private void btSupprimerClicked() {
        System.out.println("Vous avez cliqué sur le bouton Supprimer");
    }
}