/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;



import EntitiesO.intervention;
import EntitiesO.medecin;
import EntitiesO.specialite;
import ServiceO.ServiceIntervention;
import ServiceO.ServiceMedecin;
import ServiceO.ServiceSpecialite;
import com.jfoenix.controls.JFXButton;

import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.animation.TranslateTransition;
import javafx.collections.FXCollections;
import javafx.collections.ListChangeListener;
import javafx.collections.ObservableList;
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.Pagination;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.ImageView;
import javafx.scene.image.Image;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;
import javafx.util.Duration;


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
    private VBox slider;
    @FXML
    private JFXButton btn_spec1;
    @FXML
    private JFXButton btn_inter1;
   /* @FXML
    private ImageView imgView;*/
    @FXML
    private JFXButton btn_med1;
    @FXML
    private Label Menu;
    @FXML
    private Label MenuClose;
    @FXML
    private TextField filtrefield;
    @FXML
    private Pagination pagination;
     private final static int rowsPerPage = 5;  


    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        //  slider.setTranslateX(176);
        Menu.setOnMouseClicked(event -> {
            TranslateTransition slide = new TranslateTransition();
            slide.setDuration(Duration.seconds(0.4));
            slide.setNode(slider);

            slide.setToX(0);
            slide.play();

            slider.setTranslateX(-176);

            slide.setOnFinished((ActionEvent e)-> {
                Menu.setVisible(false);
                MenuClose.setVisible(true);
            });
        });

        MenuClose.setOnMouseClicked(event -> {
            TranslateTransition slide = new TranslateTransition();
            slide.setDuration(Duration.seconds(0.4));
            slide.setNode(slider);

            slide.setToX(-176);
            slide.play();

            slider.setTranslateX(0);

            slide.setOnFinished((ActionEvent e)-> {
                Menu.setVisible(true);
                MenuClose.setVisible(false);
            });
        });
    
        
       // Image img= new Image(getClass().getResourceAsStream("hero-bg.jpg"));
      //imgView.setImage(img);
        ServiceSpecialite sp = new ServiceSpecialite();   
      ObservableList<specialite> list = FXCollections.observableArrayList();
        idsp.setCellValueFactory(new PropertyValueFactory<>("id"));
        titresp.setCellValueFactory(new PropertyValueFactory<>("titre"));
      
        list.addAll(sp.AfficherSpecialite());
      tablesp.setItems(list);
       pagination.setPageFactory(this::createPage);  
      search_prom();
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
    private Node createPage(int pageIndex) {
         ServiceSpecialite sp = new ServiceSpecialite();   
      ObservableList<specialite> list = FXCollections.observableArrayList();
        idsp.setCellValueFactory(new PropertyValueFactory<>("id"));
        titresp.setCellValueFactory(new PropertyValueFactory<>("titre"));
      
        list.addAll(sp.AfficherSpecialite());
          int fromIndex = pageIndex * rowsPerPage;
        int toIndex = Math.min(fromIndex + rowsPerPage, list.size());
        tablesp.setItems(FXCollections.observableArrayList(list.subList(fromIndex, toIndex)));
       
        return tablesp;
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
       pagination.setPageFactory(this::createPage);  
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
    pagination.setPageFactory(this::createPage);  
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
        void search_prom() {
                specialite s = new specialite();
      ObservableList<specialite> list = FXCollections.observableArrayList();
        idsp.setCellValueFactory(new PropertyValueFactory<>("id"));
        titresp.setCellValueFactory(new PropertyValueFactory<>("titre"));
      
ObservableList<specialite> dataList;

ServiceSpecialite sp = new ServiceSpecialite();   
        dataList =sp.AfficherSpecialite2();
       
        tablesp.setItems(dataList);
       
        FilteredList<specialite> filteredData = new FilteredList<>(dataList, b -> true);
       
        filtrefield.textProperty().addListener((observable, oldValue, newValue) -> {
            filteredData.setPredicate((specialite promo) -> {
                if (newValue == null || newValue.isEmpty()) {
                    return true;
                }
                String lowerCaseFilter = newValue.toLowerCase();
               
                  int intfiltrevalue=-1;
              try{  
                  intfiltrevalue=Integer.parseInt(lowerCaseFilter);
              }catch(Exception ex){
              intfiltrevalue=-1;
              }
                if (promo.getId()== intfiltrevalue&&intfiltrevalue!=-1) {
                    return true; // Filter matches username
               
                }else  if (promo.getTitre().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true; // Filter matches password
                        }
             
                else {
                    return false; // Does not match.
                }
            });
        });
        SortedList<specialite> sortedData = new SortedList<>(filteredData);
        sortedData.comparatorProperty().bind(tablesp.comparatorProperty());
        tablesp.setItems(sortedData);
    }
    
}
