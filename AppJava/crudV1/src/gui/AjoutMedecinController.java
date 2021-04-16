/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import Entities.medecin;
import Service.ServiceMedecin;
import java.io.IOException;
import java.net.URL;
import java.sql.SQLException;

import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Parent;
import javafx.scene.control.Button;
import javafx.scene.control.TextField;

/**
 * FXML Controller class
 *
 * @author BENJOU
 */
public class AjoutMedecinController implements Initializable {
    
    @FXML
    private TextField txtnom;
    @FXML
    private TextField txtprenom;
    @FXML
    private TextField txtemail;
    @FXML
    private TextField txtnum;
    @FXML
    private TextField txtpic;
    @FXML
    private Button ajouter;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    
    @FXML
    private void addAction(ActionEvent event){
    
String num1 = txtnum.getText();
Integer num =Integer.parseInt(num1);
String nom= txtnom.getText();
String prenom = txtprenom.getText();
String email = txtemail.getText();
String pic = txtpic.getText();
medecin m = new medecin(num,nom,prenom,email,pic);
ServiceMedecin sm = new ServiceMedecin();
sm.ajouterMedecin(m);
FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherMedecin.fxml"));
try {
    Parent root=loader.load();
    txtnom.getScene().setRoot(root);
}catch (IOException ex) {
            Logger.getLogger(AjoutMedecinController.class.getName()).log(Level.SEVERE, null, ex);

}

    }
    
}
