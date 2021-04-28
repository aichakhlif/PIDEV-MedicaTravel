/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package ServiceO;

import EntitiesO.intervention;
import EntitiesO.medecin;
import EntitiesO.specialite;
import database.MaConnexion;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.sql.Statement;
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
public class ServiceMedecin {
     Connection con;
     private Statement ste;
    PreparedStatement pst;
    private ResultSet rs;
    ObservableList<medecin> obList = FXCollections.observableArrayList();

    public ServiceMedecin(){
    con=MaConnexion.getInstance().getConnexion();
    }
     public void ajouterMedecin(medecin m){
         
    String sql="INSERT INTO `medecin`(`nom`, `prenom`, `email`, `num`, `pic`)"  + " VALUES (?,?,?,?,?)";
    
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
 String sql ="select m.id, m.nom, m.prenom ,m.num,m.email,m.pic,s.titre  from medecin m , specialite s , medecin_specialite ms "
         + "where m.id=ms.medecin_id and s.id=ms.specialite_id GROUP BY m.id,s.titre" ;
     List<medecin> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     obList.add(new medecin(result.getInt("id"),result.getInt("num"),result.getString("nom"),result.getString("prenom"),result.getString("email"),result.getString("pic"),result.getString("titre")));
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return obList;
    }
 
 public List<medecin> AfficherMedecin()  {
 String sql ="select m.id, m.nom, m.prenom ,m.num,m.email,m.pic,s.titre  from medecin m , specialite s , medecin_specialite ms "
         + "where m.id=ms.medecin_id and s.id=ms.specialite_id GROUP BY m.id,s.titre" ;
     List<medecin> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
     list.add(new medecin(result.getInt("id"),result.getInt("num"),result.getString("nom"),result.getString("prenom"),result.getString("email"),result.getString("pic"),result.getString("titre")));
            System.out.println(list);

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

     public List<medecin> AfficherMedecinSpec()  {
 //String sql ="select * from medecin m , specialite s , medecin_specialite ms where m.id=ms.medecin_id and s.id=ms.specialite_id GROUP BY m.id" ;
   String sql= "select * from medecin ";
   ServiceSpecialite S_Specialite= new ServiceSpecialite();
       List<medecin> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
       
        
         medecin m =new medecin(result.getInt("id"),result.getInt("num"),result.getString("nom"),result.getString("prenom"),result.getString("email"),result.getString("pic"));
         m.setListspec(S_Specialite.AfficherSpecialiteParIdMedcin(result.getInt("id")));
                 list.add(m);
       //  System.out.println(m);
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return list;
    }
 

   
   public medecin getLastrow()  {
 //String sql ="select * from medecin m , specialite s , medecin_specialite ms where m.id=ms.medecin_id and s.id=ms.specialite_id GROUP BY m.id" ;
   String sql= "select * from medecin ORDER BY id DESC LIMIT 1 ";
      try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
       
        
         medecin m =new medecin(result.getInt("id"),result.getInt("num"),result.getString("nom"),result.getString("prenom"),result.getString("email"),result.getString("pic"));
      return m; 
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return null;
    }
    // 
     public void ajouterMedecinSpecialte(int medecinid,int specid){
         
    String sql="INSERT INTO medecin_specialite values(?,?) ";
    try{
     pst = con.prepareStatement(sql);
                    pst.setInt(1,medecinid);
                    pst.setInt(2,specid);
                      
                    
                    pst.executeUpdate();
                   
                    System.out.println("added");
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     
    }
      public int countmedecin()
        {
            int total=0;
          String req =   "SELECT COUNT(m.id) as nb,s.titre FROM medecin m JOIN medecin_specialite ms JOIN specialite s "
                  + "WHERE ms.medecin_id = m.id and s.id=ms.specialite_id GROUP BY ms.specialite_id";
        try {
            pst=con.prepareStatement(req);
     ResultSet result= pst.executeQuery();
          if (result.next()) {
     total = result.getInt(1);
  
                 }
        } catch (SQLException ex) {
           System.out.println("Probléme");
            System.out.println(ex.getMessage());
        }
     
        return total;
    }
      public List<medecin> AfficherMed()  {
   String sql= "select * from medecin ";
 
       List<medecin> list = new ArrayList<>();
     try{
     pst=con.prepareStatement(sql);
     ResultSet result= pst.executeQuery();
     while(result.next()){
       
        
         medecin m =new medecin(result.getInt("id"),result.getInt("num"),result.getString("nom"),result.getString("prenom"),result.getString("email"),result.getString("pic"));
        
                 list.add(m);
         System.out.println(m);
       
     }
     } catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
     return list;
    }
 

           
         
   
}
