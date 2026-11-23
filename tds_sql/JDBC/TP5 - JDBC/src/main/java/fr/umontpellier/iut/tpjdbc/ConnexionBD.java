package fr.umontpellier.iut.tpjdbc;

import java.sql.*;
import java.util.ArrayList;

public class ConnexionBD {
    private Connection cn;
    private Statement st;
    private ResultSet rs;
    private PreparedStatement pst;
    private CallableStatement cst;

    public ConnexionBD() {
        try {
            this.cn = DriverManager.getConnection("jdbc:oracle:thin:@162.38.222.149:1521:iut", "letallet", "22fVKu4CTc");
            this.st = cn.createStatement(ResultSet.TYPE_SCROLL_INSENSITIVE,ResultSet.CONCUR_READ_ONLY);

            this.rs = recupererTous();

            this.pst = cn.prepareStatement("SELECT * FROM Personnes WHERE agePersonne >= ? ORDER BY agePersonne DESC NULLS LAST", ResultSet.TYPE_SCROLL_SENSITIVE, ResultSet.CONCUR_UPDATABLE);

            this.cst = cn.prepareCall("{? = call ageMoyenParNationalite(?)}");
            cst.registerOutParameter(1, Types.NUMERIC);
        }
        catch(SQLException e) {
            e.printStackTrace();
        }
    }

    public void lancerCall(String nationalite) throws SQLException {
        cst.setString(2, nationalite);
        cst.execute();
    }

    public ResultSet recupererTous() {
        try{
            return st.executeQuery("SELECT * FROM Personnes ORDER BY agePersonne DESC NULLS LAST");
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }
    public ArrayList<String> recupererNationaltes() {
        try{
            ArrayList<String> liste = new ArrayList<String>();

            rs = st.executeQuery("SELECT DISTINCT nationalitePersonne FROM Personnes ORDER BY nationalitePersonne ASC NULLS LAST");

            while (rs.next()) {
                liste.add(rs.getString(1));
            }

            return liste;
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }



    public Personne creerPersonne(){
        try{
            int num = rs.getInt(1);
            String nom= rs.getString(2);
            String prenom= rs.getString(3);
            String nationnalite= rs.getString(4);
            int age = rs.getInt(5);
            if (rs.wasNull()) age = -1;
            return new Personne(num,nom,prenom,nationnalite,age);
        } catch (SQLException e) { e.printStackTrace(); }
        return null;
    };
    public Personne premier(){
        try{
            if (rs.first()){ return creerPersonne(); }
        }
        catch (SQLException e) { e.printStackTrace(); }
        return null;
    }
    public Personne dernier(){
        try{
            if (rs.last()){ return creerPersonne(); }
        }
        catch (SQLException e) { e.printStackTrace(); }
        return null;
    }
    public Personne suivant(){
        try{
            if (!rs.isLast() && !rs.isAfterLast() && rs.next()){ return creerPersonne(); }
        }
        catch (SQLException e) { e.printStackTrace(); }
        return null;
    }
    public Personne precedent(){
        try{
            if (!rs.isFirst() && !rs.isBeforeFirst() && rs.previous()){ return creerPersonne(); }
        }
        catch (SQLException e) { e.printStackTrace(); }
        return null;
    }
    public void deconnexion(){
        try {
            rs.close();
        }
        catch (SQLException e) { e.printStackTrace(); }
    }

    public Personne afficherRecherche(int val){
        try{
            pst.setInt(1, val);
            rs = pst.executeQuery();
            while(rs.next()) {
                creerPersonne();
            }
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    public Personne afficherTous(){
        try{
            rs = recupererTous();
            while(rs.next()) {
                creerPersonne();
            }
        }
        catch (SQLException e) {
            e.printStackTrace();
        }
        return null;
    }

    public int afficherMoyenne() {
        try {
            return cst.getInt(1);
        } catch (SQLException e) {
            e.printStackTrace();
        }
        return -1;
    }
}