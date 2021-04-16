/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entities.intervention;

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
public class ServiceIntervention {
     Connection con;
    PreparedStatement pst;
    ObservableList<intervention> obList = FXCollections.observableArrayList();
    public ServiceIntervention(){
    con=MaConnexion.getInstance().getConnexion();
    }
     public void ajouterIntervention(intervention inter){
    String sql="INSERT INTO `intervention`(`description`)" + " VALUES (?)";
    try{
     pst = con.prepareStatement(sql);
                    pst.setString(1,inter.getDescription());  
                    pst.executeUpdate();
                     System.out.println("added");
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     }
     public void update_inter(intervention inter,int id ){
        String req = "update intervention set description=? where id=? ";

        try {
            pst = con.prepareStatement(req);
            pst.setString(1,inter.getDescription());
                 
                    pst.setInt(2, id);
            pst.executeUpdate();

        } catch (SQLException ex) {
            System.out.println("erreur");
        }

    }
     public List<intervention> AfficherIntervention()  {
     String sql ="select * from intervention" ;
     List<intervention> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     list.add(new intervention(result.getInt("id"),result.getString("description")));
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return list;
     
    }
      public ObservableList AfficherIntervention2()  {
     String sql ="select * from intervention" ;
     List<intervention> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     obList.add(new intervention(result.getInt("id"),result.getString("description")));
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return obList;
     
    }
     public boolean delete_inter(int id){
        String req = "delete from intervention where id=? ";

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
