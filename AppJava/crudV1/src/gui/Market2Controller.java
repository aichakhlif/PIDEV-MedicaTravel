/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import database.MaConnexion;
import ServiceO.MyListener;
import EntitiesO.medecin;
import ServiceO.ServiceMedecin;
import com.jfoenix.controls.JFXButton;
import javafx.geometry.Insets;
import java.io.IOException;
import java.net.URL;
import java.sql.ResultSet;
import java.sql.Statement;
import java.util.ArrayList;
import java.util.List;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ObservableList;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.control.ScrollPane;
import javafx.scene.image.ImageView;
import javafx.scene.layout.AnchorPane;
import javafx.scene.layout.GridPane;
import javafx.scene.layout.Region;
import javafx.scene.layout.VBox;

import java.io.File;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import javafx.event.ActionEvent;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.image.Image;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author Asus
 */
public class Market2Controller implements Initializable {

    @FXML
    private VBox chosenclinique;
    @FXML
    private Label clqname;
    @FXML
    private ImageView clqimg;
    @FXML
    private ScrollPane scroll;
    @FXML
    private Label clqemail;
    @FXML
    private Label clqadr;
    @FXML
    private Label clqtel;
    @FXML
    private Label clqscep;
    @FXML
    private GridPane grid;
private MyListener mylistener;
  ObservableList<medecin> obList = FXCollections.observableArrayList();
    Connection con;
     private Statement ste;
    PreparedStatement pst;
    private ResultSet rs;
   // 
    @FXML
    private JFXButton contact_med;
    @FXML
    private Label id;
    
   
    /**
     * Initializes the controller class.
     */
   private void setchosenclq(medecin medecin){
       
       clqname.setText(medecin.getNom());
        clqadr.setText(medecin.getPrenom());
       clqemail.setText(medecin.getEmail());
       clqadr.setText(medecin.getPrenom());
      clqscep.setText(medecin.getListspec());
       clqtel.setText(""+medecin.getNum());
       File file = new File(medecin.getPic());
        System.out.println(file);
       
        Image im = null;
        if(file.exists()){
                 im = new Image(file.toURI().toString());
        }else{
            //im = new Image("resources/default-article.jpg"); // this is the defualt photo of the product
        }
         this.clqimg.setImage(im);
       //clqscep.setText(clinique.getSpec());
       chosenclinique.setStyle("-fx-background-color: #171717;\n"+
    "-fx-background-radius: 30;");
   }
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
        clq.addAll(getData());
        if(clq.size()>0){
            setchosenclq(clq.get(0));
            mylistener=new MyListener(){
          @Override
          public void onClickListener(medecin medecin){
            setchosenclq(medecin);
        }
            };
        int column=0;
        int row=1;
        try {
        for(int i=0;i<clq.size();i++){
            FXMLLoader fxmlloader = new FXMLLoader();
            fxmlloader.setLocation(getClass().getResource("MedFront.fxml"));
            
                AnchorPane anchorpane=fxmlloader.load();
           
            MedFrontController medfrontController=fxmlloader.getController();
            medfrontController.setData(clq.get(i),mylistener);
            if(column==3){
                column=0;
                row++;
            }
            
            grid.add(anchorpane, column++, row);
               grid.setMinHeight(Region.USE_COMPUTED_SIZE);
                grid.setPrefHeight(Region.USE_COMPUTED_SIZE);
                grid.setMaxHeight(Region.USE_PREF_SIZE);
                 grid.setMinWidth(Region.USE_COMPUTED_SIZE);
                grid.setPrefWidth(Region.USE_COMPUTED_SIZE);
                grid.setMaxWidth(Region.USE_PREF_SIZE);

            GridPane.setMargin(anchorpane,new Insets(10));
        }
          } catch (IOException ex) {
                Logger.getLogger(Market2Controller.class.getName()).log(Level.SEVERE, null, ex);
            }   
            
        
      
        }} 
       
    /* public ObservableList<medecin> getMedecinList(){
        String sql ="select m.id, m.nom, m.prenom ,m.num,m.email,m.pic,s.titre  from medecin m , specialite s , medecin_specialite ms "
         + "where m.id=ms.medecin_id and s.id=ms.specialite_id GROUP BY m.id,s.titre" ;
    // List<medecin> list = new ArrayList<>();
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
     */
    ServiceMedecin sm =new ServiceMedecin(); 
     private List<medecin> clq =sm.AfficherMedecin2();
     private List<medecin> getData(){
         List<medecin> clq =new ArrayList<>();
         medecin medecin;
       return clq;
     }    

    @FXML
    private void contactermed(ActionEvent event) throws IOException {
                               MailingController.sendtovalue=clqemail.getText();
 
        Parent root = FXMLLoader.load(getClass().getResource("Mailing.fxml"));
        System.out.print(clqemail.getText());
         Scene scene = new Scene(root);
              
              Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
              stage.setScene(scene);

              stage.show();
    }
}
