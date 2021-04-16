/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entities.intervention;
import Entities.specialite;
import database.MaConnexion;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
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
    
}
