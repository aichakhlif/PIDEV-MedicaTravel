/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package database;

import java.sql.*;
/**
 *
 * @author ASUS
 */
public class MaConnexion {
    String url="jdbc:mysql://localhost:3306/medicatravel";
    String UserName="root";
    String password="";
    private Connection cnx;
    public static  MaConnexion instance;
    
    private MaConnexion(){
        try{
        cnx=DriverManager.getConnection(url, UserName,password);
    }catch(SQLException ex){
        System.out.print(ex.getMessage());
    }
    }
public static MaConnexion getInstance(){
    if(instance==null){
   instance=new MaConnexion();
}
    return instance;
}
public Connection getConnexion(){
return cnx;
}
}

