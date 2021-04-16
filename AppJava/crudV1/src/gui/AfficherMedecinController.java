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
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.collections.FXCollections;
import javafx.collections.ListChangeListener;
import javafx.collections.ObservableList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.stage.Stage;

/**
 * FXML Controller class
 *
 * @author BENJOU
 */
public class AfficherMedecinController implements Initializable {

    @FXML
    private TableView<medecin> tablemed;
    @FXML
    private TableColumn<medecin, Integer> idmed;
    @FXML
    private TableColumn<medecin, String> nommed;
    @FXML
    private TableColumn<medecin, String> prenommed;
    @FXML
    private TableColumn<medecin, String> emailmed;
     @FXML
    private TableColumn<medecin, Integer> numeromed;
     @FXML
    private TableColumn<medecin, String> imagemed;
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
    @FXML
    private Button modifmed;
    @FXML
    private Button suppmed;
    
     ObservableList<medecin>observableList;
    @FXML
    private Button btn_med;
    @FXML
    private Button btn_inter;
    @FXML
    private Button btn_spec;


    @Override
    public void initialize(URL url, ResourceBundle rb) {
       ServiceMedecin sm= new ServiceMedecin();      
      ObservableList<medecin> list = FXCollections.observableArrayList();
        idmed.setCellValueFactory(new PropertyValueFactory<>("id"));
        nommed.setCellValueFactory(new PropertyValueFactory<>("nom"));
        prenommed.setCellValueFactory(new PropertyValueFactory<>("prenom"));
        emailmed.setCellValueFactory(new PropertyValueFactory<>("email"));
        numeromed.setCellValueFactory(new PropertyValueFactory<>("num"));
        imagemed.setCellValueFactory(new PropertyValueFactory<>("pic"));
        list.addAll(sm.AfficherMedecin());
      tablemed.setItems(list);
      modifmed.setDisable(true);
      suppmed.setDisable(true);
         ObservableList selectedCells = tablemed.getSelectionModel().getSelectedCells();
        selectedCells.addListener(new ListChangeListener() {
            @Override
            public void onChanged(ListChangeListener.Change c) {
                medecin mselected = (medecin) tablemed.getSelectionModel().getSelectedItem();
                System.out.println("selected value " + mselected);
                if(mselected!=null){
                txtnum.setText(String.valueOf(mselected.getNum()));
               txtnom.setText(mselected.getNom());
               txtprenom.setText(mselected.getPrenom());
               txtemail.setText(mselected.getEmail());
               txtpic.setText(mselected.getPic());
                modifmed.setDisable(false);
                suppmed.setDisable(false);
               
                }else{
                    suppmed.setDisable(true);
                    modifmed.setDisable(true);
                    txtnum.clear();
                    txtnom.clear();
                    txtprenom.clear();
                    txtemail.clear();
                    txtpic.clear();
               
                }
            }
     });
    }

    @FXML
    private void addAction(ActionEvent event) {
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

    @FXML
    private void editaction(ActionEvent event) {
    medecin mselected = (medecin) tablemed.getSelectionModel().getSelectedItem();
    ServiceMedecin si = new ServiceMedecin();
    medecin m1 = new medecin(Integer.parseInt(txtnum.getText()),txtnom.getText(),txtprenom.getText(),txtemail.getText(),txtpic.getText());
   
    si.update(m1,mselected.getId());
 
    ServiceMedecin sm= new ServiceMedecin();      
      ObservableList<medecin> list = FXCollections.observableArrayList();
        idmed.setCellValueFactory(new PropertyValueFactory<>("id"));
        nommed.setCellValueFactory(new PropertyValueFactory<>("nom"));
        prenommed.setCellValueFactory(new PropertyValueFactory<>("prenom"));
        emailmed.setCellValueFactory(new PropertyValueFactory<>("email"));
        numeromed.setCellValueFactory(new PropertyValueFactory<>("num"));
        imagemed.setCellValueFactory(new PropertyValueFactory<>("pic"));
        list.addAll(sm.AfficherMedecin());
      tablemed.setItems(list);
    

    }

   @FXML
    private void deleteaction(ActionEvent event) {
         ServiceMedecin sm = new ServiceMedecin();
 

   if (tablemed.getSelectionModel().getSelectedItem()!=null){
        sm.delete(tablemed.getSelectionModel().getSelectedItem().getId());
        tablemed.refresh();
          Alert alert = new Alert (Alert.AlertType.INFORMATION);
        alert.setTitle("succes");
   alert.setHeaderText("!!! Suppression effectuer avec suucces !!!");
   alert.setContentText("succes");
   
   observableList =sm.AfficherMedecin2();
   tablemed.setItems(observableList);
   alert.showAndWait();
   tablemed.refresh();
    }
      
    }

    @FXML
    private void gotomed(ActionEvent event) throws IOException {
         Parent root = FXMLLoader.load(getClass().getResource("AfficherMedecin.fxml"));
              Scene scene = new Scene(root);
              Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
              stage.setScene(scene);
              stage.show();
    }

    @FXML
    private void gotointer(ActionEvent event) throws IOException {
         Parent root = FXMLLoader.load(getClass().getResource("intervention.fxml"));
              Scene scene = new Scene(root);
              Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
              stage.setScene(scene);
              stage.show();
    }

    @FXML
    private void gotospec(ActionEvent event) throws IOException {
          Parent root = FXMLLoader.load(getClass().getResource("specialite.fxml"));
              Scene scene = new Scene(root);
              Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
              stage.setScene(scene);
              stage.show();
    }
        
    }
    

