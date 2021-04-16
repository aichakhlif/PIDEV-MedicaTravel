/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import Entities.intervention;

import Service.ServiceIntervention;
import database.MaConnexion;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
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
import javax.swing.JOptionPane;

/**
 * FXML Controller class
 *
 * @author BENJOU
 */
public class InterventionController implements Initializable {

    @FXML
    private TextField txtdesc;
    @FXML
    private TableView<intervention> tableinter;
    @FXML
    private TableColumn<intervention, Integer> idinetr;
    @FXML
    private TableColumn<intervention, String> descinter;
    @FXML
    private Button ajouter;
    @FXML
    private Button edit;
    @FXML
    private Button delete;
       ObservableList<intervention>observableList;
    @FXML
    private Button btn_med;
    @FXML
    private Button btn_inter;
    @FXML
    private Button btn_spec;


    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        ServiceIntervention si = new ServiceIntervention();   
      ObservableList<intervention> list = FXCollections.observableArrayList();
        idinetr.setCellValueFactory(new PropertyValueFactory<>("id"));
        descinter.setCellValueFactory(new PropertyValueFactory<>("description"));
      
        list.addAll(si.AfficherIntervention());
      tableinter.setItems(list);
       edit.setDisable(true);
      delete.setDisable(true);
      ObservableList selectedCells = tableinter.getSelectionModel().getSelectedCells();
        selectedCells.addListener(new ListChangeListener() {
            @Override
            public void onChanged(ListChangeListener.Change c) {
                intervention interselected = (intervention) tableinter.getSelectionModel().getSelectedItem();
                System.out.println("selected value " + interselected);
                if(interselected!=null){
               
               txtdesc.setText(interselected.getDescription());
              
                edit.setDisable(false);
                delete.setDisable(false);
               
                }else{
                    delete.setDisable(true);
                    edit.setDisable(true);
                    txtdesc.clear();
                   
               
                }
            }
     });
    }    

    @FXML
    private void addaction(ActionEvent event) {
        
String description= txtdesc.getText();

intervention inter = new intervention(description);
ServiceIntervention si = new ServiceIntervention();
si.ajouterIntervention(inter);
si.AfficherIntervention();
FXMLLoader loader = new FXMLLoader(getClass().getResource("Intervention.fxml"));
try {
    Parent root=loader.load();
    txtdesc.getScene().setRoot(root);
}catch (IOException ex) {
            Logger.getLogger(InterventionController.class.getName()).log(Level.SEVERE, null, ex);

}

    }


    @FXML
    private void editaction(ActionEvent event) {
       intervention interselected = (intervention) tableinter.getSelectionModel().getSelectedItem();
 ServiceIntervention sinter = new ServiceIntervention();   
 intervention inter1 = new intervention(txtdesc.getText());
 sinter.update_inter(inter1,interselected.getId());
  ServiceIntervention si = new ServiceIntervention();   
      ObservableList<intervention> list = FXCollections.observableArrayList();
        idinetr.setCellValueFactory(new PropertyValueFactory<>("id"));
        descinter.setCellValueFactory(new PropertyValueFactory<>("description"));
      
        list.addAll(si.AfficherIntervention());
      tableinter.setItems(list);
     	
    }

    @FXML
    private void deleteaction(ActionEvent event) {
       
ServiceIntervention si = new ServiceIntervention();
 

   if (tableinter.getSelectionModel().getSelectedItem()!=null){
        si.delete_inter(tableinter.getSelectionModel().getSelectedItem().getId());
        tableinter.refresh();
          Alert alert = new Alert (Alert.AlertType.INFORMATION);
        alert.setTitle("succes");
   alert.setHeaderText("!!! Suppression effectuer avec suucces !!!");
   alert.setContentText("succes");
   
   observableList =si.AfficherIntervention2();
   tableinter.setItems(observableList);
   alert.showAndWait();
   tableinter.refresh();
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
    

