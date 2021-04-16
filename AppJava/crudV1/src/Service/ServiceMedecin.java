/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Service;

import Entities.intervention;
import Entities.medecin;
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
public class ServiceMedecin {
     Connection con;
    PreparedStatement pst;
    ObservableList<medecin> obList = FXCollections.observableArrayList();

    public ServiceMedecin(){
    con=MaConnexion.getInstance().getConnexion();
    }
     public void ajouterMedecin(medecin m){
    String sql="INSERT INTO `medecin`(`nom`, `prenom`, `email`, `num`, `pic`)" + " VALUES (?,?,?,?,?)";
    try{
     pst = con.prepareStatement(sql);
                    pst.setString(1,m.getNom());
                    pst.setString(2,m.getPrenom());
                    pst.setString(3,m.getEmail());
                    pst.setInt(4, m.getNum());
                    pst.setString(5, m.getPic());
                    
                    pst.executeUpdate();
                     System.out.println("added");
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     
    }
     public void update(medecin m,int id ){
        String req = "update medecin set nom=?,prenom=?,email=?,num=?,pic=? where id=? ";

        try {
            pst = con.prepareStatement(req);
            pst.setString(1,m.getNom());
                    pst.setString(2,m.getPrenom());
                    pst.setString(3,m.getEmail());
                    pst.setInt(4, m.getNum());
                    pst.setString(5, m.getPic());
                    pst.setInt(6, id);
            pst.executeUpdate();

        } catch (SQLException ex) {
            System.out.println("erreur");
        }

    }
    
//ste = con.createStatement();
                    
                   
                    
        
    
    /* public boolean medecin_existe(medecin m) throws SQLException {
        ServiceMedecin SM = new ServiceMedecin();
        if (SM.recuperer_id(m) == -1) {
            return false;
        }
        return true;
    }
      public int recuperer_id(medecin m) throws SQLException {

        ArrayList<medecin> m1 = new ArrayList<>();
        ServiceMedecin SM = new ServiceMedecin();
        m1 = (ArrayList<medecin>) SM.AfficherMedecin();
      
        int id = -1;
        
        for (int i = 0; i < m1.size(); i++) 
        {
            if (m1.get(i).equals(m)) 
            {
                id = m1.get(i).getId();
                break;
            }
        }
        return id;
    }*/
      public ObservableList AfficherMedecin2()  {
 String sql ="select * from medecin" ;
     List<medecin> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     obList.add(new medecin(result.getInt("id"),result.getInt("num"),result.getString("nom"),result.getString("prenom"),result.getString("email"),result.getString("pic")));
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return obList;
    }
 
 public List<medecin> AfficherMedecin()  {
 String sql ="select * from medecin" ;
     List<medecin> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     list.add(new medecin(result.getInt("id"),result.getInt("num"),result.getString("nom"),result.getString("prenom"),result.getString("email"),result.getString("pic")));
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return list;
    }
  public boolean delete(int id){
        String req = "delete from medecin where id=? ";

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
