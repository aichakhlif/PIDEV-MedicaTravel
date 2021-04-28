/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import EntitiesO.intervention;
import EntitiesO.specialite;

import ServiceO.ServiceIntervention;
import ServiceO.ServiceMedecin;
import ServiceO.ServiceSpecialite;
import com.itextpdf.text.Chunk;
import com.itextpdf.text.Document;
import com.itextpdf.text.DocumentException;
import com.itextpdf.text.Paragraph;
import com.itextpdf.text.Phrase;
import com.itextpdf.text.pdf.PdfPCell;
import com.itextpdf.text.pdf.PdfPTable;
import com.itextpdf.text.pdf.PdfWriter;
import com.jfoenix.controls.JFXButton;
import com.sun.xml.internal.ws.api.message.Message;
import database.MaConnexion;
import static java.awt.Component.TOP_ALIGNMENT;
import java.awt.Desktop;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.net.URL;
import java.sql.Connection;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.Locale;
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
import javafx.scene.control.ComboBox;
import javafx.scene.control.Label;
import javafx.scene.control.Pagination;
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;

import javafx.scene.layout.VBox;
import javafx.stage.Stage;
import javafx.util.Duration;






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
       
    @FXML
    private Button btn_med;
    @FXML
    private Button btn_inter;
    @FXML
    private Button btn_spec;
    @FXML
    private ComboBox<String> combotitre;
    @FXML
    private TableColumn<specialite, String> spectitre;
    @FXML
    private TextField filtrefield;
    @FXML
    private VBox slider;
    @FXML
    private Label Menu;
    @FXML
    private Label MenuClose;
   
    
   ObservableList<intervention>observableList;
  /*  @FXML
    private Pagination pagination;
     private final static int rowsPerPage = 5;  */


    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        //Menu.setVisible(true);
         // MenuClose.setVisible(false);
        
         
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
    
        ServiceIntervention si = new ServiceIntervention();   
      ObservableList<intervention> list = FXCollections.observableArrayList();
        idinetr.setCellValueFactory(new PropertyValueFactory<>("id"));
        descinter.setCellValueFactory(new PropertyValueFactory<>("description"));
        spectitre.setCellValueFactory(new PropertyValueFactory<>("titre"));
        list.addAll(si.AfficherIntervention());
      tableinter.setItems(list);
     //  pagination.setPageFactory(this::createPage);  
      search_prom();
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
               combotitre.setValue(interselected.getTitre());
                edit.setDisable(false);
                delete.setDisable(false);
               
                }else{
                    delete.setDisable(true);
                    edit.setDisable(true);
                    txtdesc.clear();
                   
               
                }
            }
     });
        FillComboBox();
    }    
    
     /* private Node createPage(int pageIndex) {
            ServiceIntervention si = new ServiceIntervention();   
      ObservableList<intervention> list = FXCollections.observableArrayList();
        idinetr.setCellValueFactory(new PropertyValueFactory<>("id"));
        descinter.setCellValueFactory(new PropertyValueFactory<>("description"));
        spectitre.setCellValueFactory(new PropertyValueFactory<>("titre"));
       list.addAll(si.AfficherIntervention());
           int fromIndex = pageIndex * rowsPerPage;
        int toIndex = Math.min(fromIndex + rowsPerPage, list.size());
        tableinter.setItems(FXCollections.observableArrayList(list.subList(fromIndex, toIndex)));
       
        return tableinter;
      }*/

    @FXML
    private void addaction(ActionEvent event) {
        
String description= txtdesc.getText();
ServiceIntervention si = new ServiceIntervention();
Integer titre_id = si.GetSpecId(combotitre.getValue());
intervention inter = new intervention(description,titre_id);

si.ajouterIntervention(inter);
si.AfficherIntervention();
 //pagination.setPageFactory(this::createPage);  
FXMLLoader loader = new FXMLLoader(getClass().getResource("Intervention.fxml"));
try {
    Parent root=loader.load();
    txtdesc.getScene().setRoot(root);
}catch (IOException ex) {
            Logger.getLogger(InterventionController.class.getName()).log(Level.SEVERE, null, ex);

}

    }
    public void FillComboBox() {

        try {
            String query = " SELECT * FROM specialite";
            PreparedStatement pst = MaConnexion.getInstance().getConnexion()
                    .prepareStatement(query);
            ResultSet rs;
            rs = pst.executeQuery();
            while (rs.next()) {
                specialite s = new specialite(rs.getInt(1), rs.getString(2));
                
                combotitre.getItems().add(rs.getString("titre"));
                

               

            }
        } catch (SQLException ex) {
            Logger.getLogger(ServiceSpecialite.class.getName()).log(Level.SEVERE, null, ex);
        }
        

    }


    @FXML
    private void editaction(ActionEvent event) {
       intervention interselected = (intervention) tableinter.getSelectionModel().getSelectedItem();
 ServiceIntervention sinter = new ServiceIntervention();
 Integer titre_id = sinter.GetSpecId(combotitre.getValue());
 intervention inter1 = new intervention(txtdesc.getText(),titre_id);
 sinter.update_inter(inter1,interselected.getId());
  ServiceIntervention si = new ServiceIntervention();   
      ObservableList<intervention> list = FXCollections.observableArrayList();
        idinetr.setCellValueFactory(new PropertyValueFactory<>("id"));
        descinter.setCellValueFactory(new PropertyValueFactory<>("description"));
       spectitre.setCellValueFactory(new PropertyValueFactory<>("titre"));
        list.addAll(si.AfficherIntervention());
      tableinter.setItems(list);
      // pagination.setPageFactory(this::createPage);  
     	
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
    //pagination.setPageFactory(this::createPage);  
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

    @FXML
    private void selecttitle(ActionEvent event) {
          int selectedIndex = combotitre.getSelectionModel().getSelectedIndex();
    Object selectedItem = combotitre.getSelectionModel().getSelectedItem();
    System.out.println("Selection made: [" + selectedIndex + "] " + selectedItem);
    System.out.println("   ComboBox.getValue(): " + combotitre.getValue());
    }
    
    void search_prom() {
        intervention i = new intervention();   
      
        idinetr.setCellValueFactory(new PropertyValueFactory<>("id"));
        descinter.setCellValueFactory(new PropertyValueFactory<>("description"));
        spectitre.setCellValueFactory(new PropertyValueFactory<>("titre"));
ObservableList<intervention> dataList;

ServiceIntervention sinter = new ServiceIntervention();
        dataList =sinter.AfficherIntervention2();
       
        tableinter.setItems(dataList);
       
        FilteredList<intervention> filteredData = new FilteredList<>(dataList, b -> true);
       
        filtrefield.textProperty().addListener((observable, oldValue, newValue) -> {
            filteredData.setPredicate((intervention promo) -> {
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
                }
               else if (promo.getDescription().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true; // Filter matches username
               
                } else if (promo.getTitre().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true; // Filter matches password
                        }
             
                else {
                    return false; // Does not match.
                }
            });
        });
        SortedList<intervention> sortedData = new SortedList<>(filteredData);
        sortedData.comparatorProperty().bind(tableinter.comparatorProperty());
        tableinter.setItems(sortedData);
    }

    @FXML
   private void pdfreport(ActionEvent event) throws DocumentException, FileNotFoundException, IOException {
        
          Document pdfReport = new Document();
           PdfWriter.getInstance(pdfReport, new FileOutputStream("interventionINTER.pdf"));
            pdfReport.open();
            pdfReport.add(new Paragraph("INTERVENTION"));
            pdfReport.add(Chunk.NEWLINE);
            pdfReport.add(Chunk.NEWLINE);
            pdfReport.add(Chunk.NEWLINE);
          
            
          
          PdfPTable my_report_table = new PdfPTable(3);
          
       
          
           PdfPCell  tableCellColumn = new PdfPCell(new Phrase("id"));
           my_report_table.addCell(tableCellColumn);
           tableCellColumn = new PdfPCell(new Phrase("specilaite"));
          my_report_table.addCell(tableCellColumn);
          tableCellColumn = new PdfPCell(new Phrase("description"));
            my_report_table.addCell(tableCellColumn);
          
           
            
            double h= 0;
            tableinter.getItems().forEach((intervention inter) -> {
                
              
                String idc = "" + inter.getId();
                PdfPCell  tableCell = new PdfPCell(new Phrase(idc));
                my_report_table.addCell(tableCell);
                
                   tableCell = new PdfPCell(new Phrase(inter.getTitre()));
                my_report_table.addCell(tableCell);
                
                
                  tableCell = new PdfPCell(new Phrase(inter.getDescription()));
                my_report_table.addCell(tableCell);
                
                
            
                
             
                
            
                 
            });
            /* Attach report table to PDF */
            pdfReport.add(my_report_table);
            pdfReport.add(Chunk.NEWLINE);
            pdfReport.add(Chunk.NEWLINE);
            pdfReport.add(Chunk.NEWLINE);
          
           
            
            
            
            pdfReport.close();
            
            Alert alertReservation = new Alert(Alert.AlertType.INFORMATION);
            alertReservation.setTitle("Extraction en PDF");
            alertReservation.setHeaderText(null);
            alertReservation.setContentText("PDF report has been created.\nYou'll find "
                    + "the file under: C:\\Users\\Public\\crudV1");
            Desktop.getDesktop().open(new File("./interventionINTER.pdf"));
            alertReservation.showAndWait();
    }

  
    
       

}
    

