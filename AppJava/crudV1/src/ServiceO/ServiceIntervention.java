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
import java.util.ArrayList;
import java.util.List;
import java.util.logging.Level;
import java.util.logging.Logger;
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
         System.out.print("insert"+inter.getSpecialite_id());
    String sql="INSERT INTO `intervention`(`description`,`specialite_id`)" + " VALUES (?,?)";
    try{
     pst = con.prepareStatement(sql);
                    pst.setString(1,inter.getDescription());  
                    pst.setInt(2,inter.getSpecialite_id());
                    pst.executeUpdate();
                     System.out.println("added");
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     }

    public Integer GetSpecId(String titre1){
         ArrayList<specialite> l = new ArrayList<>();
         try {
             String requete = "SELECT * FROM specialite where titre = ?";
               
             PreparedStatement pst = MaConnexion.getInstance().getConnexion()
                     .prepareStatement(requete);
             pst.setString(1, titre1);
            ResultSet rs ;
           
             
            rs = pst.executeQuery();
             while (rs.next()) {
                specialite s = new specialite(rs.getInt(1), rs.getString(2));
                l.add(s);
                 System.out.println(l.get(0).getId());
               
                
            }
             
             int titre_id = (l.get(0).getId());
           
             return titre_id;
            
             
         } catch (SQLException ex) {
             Logger.getLogger(ServiceSpecialite.class.getName()).log(Level.SEVERE, null, ex);
             return null;
         }
        
    }
     public void update_inter(intervention inter,int id ){
          System.out.println("UP"+ inter.getSpecialite_id());
        String req = "update intervention set description=? ,specialite_id=? where id=? ";
            System.out.println("DOWN"+ inter.getSpecialite_id());
                System.out.println("UP" +id);
        try {
            pst = con.prepareStatement(req);
            pst.setString(1,inter.getDescription());
            pst.setInt(2,inter.getSpecialite_id());
                 
                    pst.setInt(3, id);
            pst.executeUpdate();

        } catch (SQLException ex) {
            System.out.println("erreur");
        }

    }
     public List<intervention> AfficherIntervention()  {
     String sql ="SELECT i.id , i.description , s.titre from intervention i , specialite s where s.id= i.specialite_id" ;
     List<intervention> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     list.add(new intervention(result.getInt("id"),result.getString("description"),result.getString("titre")));
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return list;
     
    }
      public ObservableList AfficherIntervention2()  {
     String sql ="SELECT i.id , i.description , s.titre from intervention i , specialite s where s.id= i.specialite_id" ;
     List<intervention> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     obList.add(new intervention(result.getInt("id"),result.getString("description"),result.getString("titre")));
       
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
