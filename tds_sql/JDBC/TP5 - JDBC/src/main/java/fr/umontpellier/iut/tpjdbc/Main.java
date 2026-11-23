package fr.umontpellier.iut.tpjdbc;

import javafx.application.Application;
import javafx.fxml.FXMLLoader;
import javafx.scene.Scene;
import javafx.stage.Stage;

import java.io.IOException;

public class Main extends Application {

    private ControleurFenetre controleurFenetre;

    @Override
    public void start(Stage stage) throws IOException {
        FXMLLoader fxmlLoader = new FXMLLoader(Main.class.getResource("FenetrePartie3.fxml"));
        Scene scene = new Scene(fxmlLoader.load());
        controleurFenetre = fxmlLoader.getController();
        stage.setTitle("TP6 JDBC");
        stage.setScene(scene);
        stage.show();
    }

    @Override
    public void stop(){
        controleurFenetre.fermetureFenetre();
    }

    public static void main(String[] args) {
        launch();
    }
}