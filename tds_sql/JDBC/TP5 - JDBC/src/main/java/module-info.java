module fr.umontpellier.iut.tpjdbc {
    requires javafx.controls;
    requires javafx.fxml;
    requires java.sql;

    opens fr.umontpellier.iut.tpjdbc to javafx.fxml;
    exports fr.umontpellier.iut.tpjdbc;
}