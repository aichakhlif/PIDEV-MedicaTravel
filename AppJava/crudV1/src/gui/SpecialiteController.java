/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;



import Entities.medecin;
import Entities.specialite;
import Service.ServiceIntervention;
import Service.ServiceMedecin;

import Service.ServiceSpecialite;

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
import javafx.scene.image.ImageView;
import javafx.scene.image.Image;
import javafx.stage.Stage;


/**
 * FXML Controller class
 *
 * @author BENJOU
 */
public class SpecialiteController implements Initializable {

    @FXML
    private TextField txttitre;
    @FXML
    private Button ajouter;
    @FXML
    private TableView<specialite> tablesp;
    @FXML
    private TableColumn<specialite, Integer> idsp;
    @FXML
    private TableColumn<specialite, String> titresp;
    @FXML
    private Button modifierspec;
    @FXML
    private Button deletespec;
    
           ObservableList<specialite>observableList;
    @FXML
    private Button btn_med;
    @FXML
    private Button btn_inter;
    @FXML
    private Button btn_spec;
   /* @FXML
    private ImageView imgView;*/


    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        
       // Image img= new Image(getClass().getResourceAsStream("hero-bg.jpg"));
      //imgView.setImage(img);
        ServiceSpecialite sp = new ServiceSpecialite();   
      ObservableList<specialite> list = FXCollections.observableArrayList();
        idsp.setCellValueFactory(new PropertyValueFactory<>("id"));
        titresp.setCellValueFactory(new PropertyValueFactory<>("titre"));
      
        list.addAll(sp.AfficherSpecialite());
      tablesp.setItems(list);
       modifierspec.setDisable(true);
      deletespec.setDisable(true);
      ObservableList selectedCells = tablesp.getSelectionModel().getSelectedCells();
        selectedCells.addListener(new ListChangeListener() {
            @Override
            public void onChanged(ListChangeListener.Change c) {
                specialite spselected = (specialite) tablesp.getSelectionModel().getSelectedItem();
                System.out.println("selected value " + spselected);
                if(spselected!=null){
               
               txttitre.setText(spselected.getTitre());
              
                modifierspec.setDisable(false);
                deletespec.setDisable(false);
               
                }else{
                    deletespec.setDisable(true);
                    modifierspec.setDisable(true);
                    txttitre.clear();
                   
               
                }
            }
     });
    }    

    @FXML
    private void addaction(ActionEvent event) {
    String titre= txttitre.getText();

specialite spec = new specialite(titre);
ServiceSpecialite sp = new ServiceSpecialite();
sp.ajouterSpecialite(spec);
sp.AfficherSpecialite();
FXMLLoader loader = new FXMLLoader(getClass().getResource("Specialite.fxml"));
try {
    Parent root=loader.load();
    txttitre.getScene().setRoot(root);
}catch (IOException ex) {
            Logger.getLogger(SpecialiteController.class.getName()).log(Level.SEVERE, null, ex);

}

    }

    @FXML
    private void editaction(ActionEvent event) {
        specialite spselected = (specialite) tablesp.getSelectionModel().getSelectedItem();
    ServiceSpecialite spec = new ServiceSpecialite();
    specialite s1 = new specialite(txttitre.getText());
   
    spec.update_spec(s1,spselected.getId());
     ServiceSpecialite sp = new ServiceSpecialite();   
      ObservableList<specialite> list = FXCollections.observableArrayList();
        idsp.setCellValueFactory(new PropertyValueFactory<>("id"));
        titresp.setCellValueFactory(new PropertyValueFactory<>("titre"));
      
        list.addAll(sp.AfficherSpecialite());
      tablesp.setItems(list);
    }

    @FXML
    private void deleteaction(ActionEvent event) {
        ServiceSpecialite sp = new ServiceSpecialite();
 

   if (tablesp.getSelectionModel().getSelectedItem()!=null){
        sp.delete_spec(tablesp.getSelectionModel().getSelectedItem().getId());
        tablesp.refresh();
          Alert alert = new Alert (Alert.AlertType.INFORMATION);
        alert.setTitle("succes");
   alert.setHeaderText("!!! Suppression effectuer avec suucces !!!");
   alert.setContentText("succes");
   
   observableList =sp.AfficherSpecialite2();
   tablesp.setItems(observableList);
   alert.showAndWait();
   tablesp.refresh();
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
