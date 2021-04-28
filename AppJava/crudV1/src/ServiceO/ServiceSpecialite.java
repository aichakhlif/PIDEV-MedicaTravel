/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ServiceO;

import EntitiesO.intervention;
import EntitiesO.specialite;
import database.MaConnexion;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;

/**
 *
 * @author BENJOU
 */
public class ServiceSpecialite {
    Connection con;
     private Statement ste;
    
    PreparedStatement pst;
    ObservableList<specialite> obList = FXCollections.observableArrayList();

    public ServiceSpecialite(){
    con=MaConnexion.getInstance().getConnexion();
    }
    public void ajouterSpecialite(specialite sp){
    String sql="INSERT INTO `specialite`(`titre`)" + " VALUES (?)";
    try{
     pst = con.prepareStatement(sql);
                    pst.setString(1,sp.getTitre()); 
                    pst.executeUpdate();
                     System.out.println("added");
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     }
    public void update_spec(specialite sp,int id ){
        String req = "update specialite set titre=? where id=? ";

        try {
            pst = con.prepareStatement(req);
            pst.setString(1,sp.getTitre());
                 
                    pst.setInt(2, id);
            pst.executeUpdate();

        } catch (SQLException ex) {
            System.out.println("erreur");
        }

    }
     public List<specialite> AfficherSpecialite()  {
     String sql ="select * from specialite" ;
     List<specialite> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     list.add(new specialite(result.getInt("id"),result.getString("titre")));
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return list;
    }
     public ObservableList AfficherSpecialite2(){
         String sql ="select * from specialite" ;
     List<specialite> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     obList.add(new specialite(result.getInt("id"),result.getString("titre")));
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return obList;
         
     } 
      public boolean delete_spec(int id){
        String req = "delete from specialite where id=? ";

        try {
            pst = con.prepareStatement(req);
            pst.setInt(1, id);
            pst.executeUpdate();

        } catch (SQLException ex) {
          System.out.println("erreur");
          
        }
        return false;
      }
public String AfficherSpecialiteParIdMedcin(int idmedecin )  {
     String sql ="   select * from specialite s , medecin_specialite mp where mp.medecin_id=? "
             + "and s.id=mp.specialite_id" ;
    String list = "";
     try{
     pst=con.prepareStatement(sql);
     pst.setInt(1,idmedecin);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     list = list+ " "+ result.getString("titre");
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return list;
    }

  
    public ObservableList<String> getValuesSpec() {
        
          ObservableList<String> specialite = FXCollections.observableArrayList();
        try {
            Statement st = con.createStatement();
            String query = "SELECT titre  FROM specialite";
            ResultSet rs = st.executeQuery(query);
            while (rs.next()) {
                specialite.add(rs.getString("titre"));
            }

        } catch (SQLException ex) {
            System.out.println("erreur get values objectifs (pour comboBox)");
            System.out.println(ex);
        }
        return specialite;
        
    }
    public ObservableList<Integer> getnb_specialite_medecin(){
 
  ObservableList<Integer> specialite = FXCollections.observableArrayList();
        try {
            Statement st = con.createStatement();
            String query = " SELECT  COUNT(*) as i FROM medecin_specialite GROUP BY specialite_id   " ;
        //SELECT COUNT(m.id) as nb,s.titre FROM medecin m JOIN medecin_specialite ms JOIN specialite s WHERE ms.medecin_id = m.id and s.id=ms.specialite_id GROUP BY ms.specialite_id
                
            ResultSet rs = st.executeQuery(query);
            while (rs.next()) {
                specialite.add(rs.getInt("i"));
            }

        } catch (SQLException ex) {
            System.out.println("erreur get values objectifs (pour comboBox)");
            System.out.println(ex);
        }
        return specialite;
 }
    public int nb_specialite(){
     
    int i=0;
        Statement stm = null;

        try {
            stm = con.createStatement();
            String query = "SELECT * FROM specialite ";
            ResultSet rst = stm.executeQuery(query);

            while (rst.next()) {
               i++;              

            }
        } catch (SQLException ex) {
            System.out.println(ex.getMessage());

        }
        return i;
     }
}
