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
import com.itextpdf.text.Chunk;
import com.itextpdf.text.Document;
import com.itextpdf.text.DocumentException;
import com.itextpdf.text.Paragraph;
import com.itextpdf.text.Phrase;
import com.itextpdf.text.pdf.PdfPCell;
import com.itextpdf.text.pdf.PdfPTable;
import com.itextpdf.text.pdf.PdfWriter;
import com.jfoenix.controls.JFXButton;
import com.sun.corba.se.impl.protocol.giopmsgheaders.Message;
import database.MaConnexion;
import java.awt.Desktop;
import java.awt.image.BufferedImage;
import java.io.File;
import java.io.FileNotFoundException;
import java.io.FileOutputStream;
import java.io.IOException;
import java.net.URL;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import java.sql.SQLException;
import java.util.ResourceBundle;
import java.util.UUID;
import java.util.logging.Level;
import java.util.logging.Logger;
import javafx.animation.TranslateTransition;
import javafx.collections.FXCollections;
import javafx.collections.ListChangeListener;
import javafx.collections.ObservableList;
import javafx.embed.swing.SwingFXUtils;
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
import javafx.scene.control.TableColumn;
import javafx.scene.control.TableView;
import javafx.scene.control.TextField;
import javafx.scene.control.cell.PropertyValueFactory;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.layout.VBox;
import javafx.stage.FileChooser;
import javafx.stage.Stage;
import javafx.util.Duration;
import javax.imageio.ImageIO;
import org.apache.commons.io.FilenameUtils;

import java.nio.file.Files;
import static java.nio.file.Files.list;
import java.nio.file.Path;
import java.nio.file.Paths;
import java.nio.file.StandardCopyOption;
import java.util.List;
import java.util.ArrayList;
import java.util.regex.Pattern;
import javafx.collections.transformation.FilteredList;
import javafx.collections.transformation.SortedList;
import javafx.scene.control.Pagination;
import static org.apache.commons.io.output.DeferredFileOutputStreamTest.data;
import org.jfree.chart.ChartFactory;
import org.jfree.chart.ChartFrame;
import org.jfree.chart.JFreeChart;
import org.jfree.chart.plot.PiePlot;
import org.jfree.data.general.DefaultKeyedValuesDataset;
import org.jfree.data.general.DefaultPieDataset;




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
    private Button modifmed;
    @FXML
    private Button suppmed;
    
     ObservableList<medecin>observableList;
    @FXML
    private TableColumn<specialite, String> titre_specialite;
    @FXML
    private ComboBox<String> combotitre;
    @FXML
    private VBox slider;
    @FXML
    private JFXButton btn_spec1;
    @FXML
    private JFXButton btn_inter1;
    @FXML
    private JFXButton btn_med1;
    @FXML
    private TextField filtrefield;
    @FXML
    private ImageView modifierspec;
    @FXML
    private Label Menu;
    @FXML
    private Label MenuClose;
    @FXML
    private Button filepic;

    private String txtpic;
    @FXML
    private JFXButton ajout;
    
    @FXML
    private ImageView checknom;
    @FXML
    private ImageView checkprenom;
    @FXML
    private ImageView checkemail;
    @FXML
    private ImageView checknum;
    @FXML
    private Button contact_med;
    /*@FXML
    private Pagination pagination;
     private final static int rowsPerPage = 5;   */ 
    @FXML
    private JFXButton chart1;
    private List <specialite> spadd = new ArrayList();
    @FXML
    private JFXButton locationMed;
    @FXML
    private ImageView modifierspec1;
    @FXML
    private ImageView photo_view;
    private Image image;
    @FXML
    private TextField photo_p;
 //   private final static int dataSize = 100;
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
    
       ServiceMedecin sm= new ServiceMedecin();      
      ObservableList<medecin> list = FXCollections.observableArrayList();
       list.addAll(sm.AfficherMedecin2());
        idmed.setCellValueFactory(new PropertyValueFactory<>("id"));
        nommed.setCellValueFactory(new PropertyValueFactory<>("nom"));
        prenommed.setCellValueFactory(new PropertyValueFactory<>("prenom"));
        emailmed.setCellValueFactory(new PropertyValueFactory<>("email"));
        numeromed.setCellValueFactory(new PropertyValueFactory<>("num"));
        imagemed.setCellValueFactory(new PropertyValueFactory<>("pic"));
        titre_specialite.setCellValueFactory(new PropertyValueFactory<>("listspec"));

       
        
      tablemed.setItems(list);
             search_prom();
       //pagination.setPageFactory(this::createPage);  
      modifmed.setDisable(true);
      suppmed.setDisable(true);
      contact_med.setDisable(true);
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
               txtpic=(mselected.getPic());
                modifmed.setDisable(false);
                suppmed.setDisable(false);
                      contact_med.setDisable(false);

                
               
                }else{
                    suppmed.setDisable(true);
                    modifmed.setDisable(true);
                    contact_med.setDisable(true);

                    txtnum.clear();
                    txtnom.clear();
                    txtprenom.clear();
                    txtemail.clear();
                    txtpic="";
                    
               
                }
            }
     });
          FillComboBox();
    }
     //method to create page inside pagination view
    /*private Node createPage(int pageIndex) {
          ServiceMedecin sm= new ServiceMedecin();    
         ObservableList<medecin> list = FXCollections.observableArrayList();
        idmed.setCellValueFactory(new PropertyValueFactory<>("id"));
        nommed.setCellValueFactory(new PropertyValueFactory<>("nom"));
        prenommed.setCellValueFactory(new PropertyValueFactory<>("prenom"));
        emailmed.setCellValueFactory(new PropertyValueFactory<>("email"));
        numeromed.setCellValueFactory(new PropertyValueFactory<>("num"));
        imagemed.setCellValueFactory(new PropertyValueFactory<>("pic"));
        titre_specialite.setCellValueFactory(new PropertyValueFactory<>("listspec"));

        list.addAll(sm.AfficherMedecinSpec());
        int fromIndex = pageIndex * rowsPerPage;
        int toIndex = Math.min(fromIndex + rowsPerPage, list.size());
        tablemed.setItems(FXCollections.observableArrayList(list.subList(fromIndex, toIndex)));
       
        return  tablemed;
    }*/
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
    private void selecttitle(ActionEvent event) {
          int selectedIndex = combotitre.getSelectionModel().getSelectedIndex();
    Object selectedItem = combotitre.getSelectionModel().getSelectedItem();
    System.out.println("Selection made: [" + selectedIndex + "] " + selectedItem);
    System.out.println("   ComboBox.getValue(): " + combotitre.getValue());
  ServiceMedecin Sm = new ServiceMedecin();
    spadd.add(new specialite(Sm.GetSpecId(combotitre.getValue()),combotitre.getValue()));
    System.out.println("spadd" + spadd);
    
            }

    @FXML
    private void editaction(ActionEvent event) {
    medecin mselected = (medecin) tablemed.getSelectionModel().getSelectedItem();
    ServiceMedecin si = new ServiceMedecin();
    medecin m1 = new medecin(Integer.parseInt(txtnum.getText()),txtnom.getText(),txtprenom.getText(),txtemail.getText(),photo_p.getText().replace('\\', '/'));
   
    si.update(m1,mselected.getId());
 
    ServiceMedecin sm= new ServiceMedecin();      
      ObservableList<medecin> list = FXCollections.observableArrayList();
        idmed.setCellValueFactory(new PropertyValueFactory<>("id"));
        nommed.setCellValueFactory(new PropertyValueFactory<>("nom"));
        prenommed.setCellValueFactory(new PropertyValueFactory<>("prenom"));
        emailmed.setCellValueFactory(new PropertyValueFactory<>("email"));
        numeromed.setCellValueFactory(new PropertyValueFactory<>("num"));
        imagemed.setCellValueFactory(new PropertyValueFactory<>("pic"));
        list.addAll(sm.AfficherMedecin2());
      tablemed.setItems(list);
      //pagination.setPageFactory(this::createPage);  
    

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
   //pagination.setPageFactory(this::createPage);  
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
 @FXML
    public void uploadimage(ActionEvent event) {
                 FileChooser fileChooser = new FileChooser();
             
            //Set extension filter
            FileChooser.ExtensionFilter extFilterJPG = 
                    new FileChooser.ExtensionFilter("JPG files (*.JPG)", "*.JPG");
            FileChooser.ExtensionFilter extFilterjpg = 
                    new FileChooser.ExtensionFilter("jpg files (*.jpg)", "*.jpg");
            FileChooser.ExtensionFilter extFilterPNG = 
                    new FileChooser.ExtensionFilter("PNG files (*.PNG)", "*.PNG");
            FileChooser.ExtensionFilter extFilterpng = 
                    new FileChooser.ExtensionFilter("png files (*.png)", "*.png");
            fileChooser.getExtensionFilters()
                    .addAll(extFilterJPG, extFilterjpg, extFilterPNG, extFilterpng);

            //Show open file dialog
            File file = fileChooser.showOpenDialog(null);
            
            try {
                BufferedImage bufferedImage = ImageIO.read(file);
                Image image = SwingFXUtils.toFXImage(bufferedImage, null);
                 photo_view.setImage(image);
                photo_p.setText(file.getAbsolutePath());
               
            } catch (IOException ex) {
                
            }
    }
/*
    @FXML
    private void uploadimage(ActionEvent event) {
    FileChooser fileChooser = new FileChooser();
     try {
                
    File selectedFile = fileChooser.showOpenDialog(new Stage());
         // BufferedImage bufferedImage = ImageIO.read(selectedFile);
             //   Image image = SwingFXUtils.toFXImage(bufferedImage, null);
                 String uniqueid = UUID.randomUUID().toString();
                   String extension= FilenameUtils.getExtension(selectedFile.getAbsolutePath());
               Path tmp = Files.move(Paths.get(selectedFile.getPath()),
                       Paths.get("C:\\wamp64\\www\\projetPI\\public\\Uploads\\Image\\"
                               +uniqueid+"."+extension),StandardCopyOption.ATOMIC_MOVE);
               txtpic=uniqueid+"."+extension;
               
              } catch (IOException ex) {
                    System.out.print(ex.getMessage());
                
            } 
    }
    */

    @FXML
    private void ajouter(ActionEvent event) {
    if (testSaisie()) {
String num1 = txtnum.getText();
Integer num =Integer.parseInt(num1);
String nom= txtnom.getText();
String prenom = txtprenom.getText();
String email = txtemail.getText();
String pic = txtpic;
ServiceMedecin sm = new ServiceMedecin();
//Integer titre_id = sm.GetSpecId(combotitre.getValue());
medecin m = new medecin(num,nom,prenom,email,photo_p.getText().replace('\\', '/'));
System.out.println("medecin add = " + m);

sm.ajouterMedecin(m);
  
int lastrowid=sm.getLastrow().getId();
int i;
for(i= 0; i<spadd.size();i++){
    sm.ajouterMedecinSpecialte(lastrowid,spadd.get(i).getId());

}
spadd.clear();
FXMLLoader loader = new FXMLLoader(getClass().getResource("AfficherMedecin.fxml"));
    
try {
    Parent root=loader.load();
    txtnom.getScene().setRoot(root);
}catch (IOException ex) {
            Logger.getLogger(AfficherMedecinController.class.getName()).log(Level.SEVERE, null, ex);

}
}
   
    }
    
    void search_prom() {
      medecin m = new medecin();   
      
        idmed.setCellValueFactory(new PropertyValueFactory<>("id"));
        nommed.setCellValueFactory(new PropertyValueFactory<>("nom"));
        prenommed.setCellValueFactory(new PropertyValueFactory<>("prenom"));
        emailmed.setCellValueFactory(new PropertyValueFactory<>("email"));
        numeromed.setCellValueFactory(new PropertyValueFactory<>("num"));
        imagemed.setCellValueFactory(new PropertyValueFactory<>("pic"));
        titre_specialite.setCellValueFactory(new PropertyValueFactory<>("listspec"));
        
ObservableList<medecin> dataList;

  ServiceMedecin sm= new ServiceMedecin();    
        dataList =sm.AfficherMedecin2();
       
        tablemed.setItems(dataList);
        
       
        FilteredList<medecin> filteredData = new FilteredList<>(dataList, b -> true);
       
        filtrefield.textProperty().addListener((observable, oldValue, newValue) -> {
            filteredData.setPredicate((medecin promo) -> {
                if (newValue == null || newValue.isEmpty()) {
                    return true;
                }
                String lowerCaseFilter = newValue.toLowerCase();
                int casefiltreint=-1;
                try{
                casefiltreint=Integer.parseInt(lowerCaseFilter);
                }catch(Exception e ){
                    casefiltreint=-1;
                }
                if(casefiltreint!=-1&&promo.getId()==casefiltreint){
                return true;
                }else if(String.valueOf(promo.getNum()).indexOf(lowerCaseFilter) != -1){
                return true; }
                
                else if (promo.getNom().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true; // Filter matches username
               
                } else if (promo.getPrenom().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true; // Filter matches password
                        }
                else if (promo.getEmail().toLowerCase().indexOf(lowerCaseFilter) != -1) {
                    return true; // Filter matches password
                        }
                
             
                else {
                    return false; // Does not match.
                }
            });
        });
        SortedList<medecin> sortedData = new SortedList<>(filteredData);
        sortedData.comparatorProperty().bind(tablemed.comparatorProperty());
        tablemed.setItems(sortedData);
       // pagination.setPageFactory(this::createPage);  
    }
    
     private Boolean testTel() {
        if (txtnum.getText().trim().length() == 8) {
            int nbChar = 0;
            for (int i = 1; i < txtnum.getText().trim().length(); i++) {
                char ch = txtnum.getText().charAt(i);
                if (Character.isLetter(ch)) {
                    nbChar++;
                }
            }

            if (nbChar == 0) {
                checknum.setImage(new Image("Images/checkMark.png") {});
               
                return true;
            } else {
                checknum.setImage(new Image("Images/erreurCheckMark.png"));
//                erreur = erreur + ("Pas de caractere permit dans le telephone\n");
                return false;

            }
        } else if (txtnum.getText().trim().length() != 8) {
//            erreur = erreur + ("Il faut saisir 8 chiffres dans le numéro de telephone\n");
                            checknum.setImage(new Image("Images/erreurCheckMark.png"));

            return false;
        }

        return true;

    }
private Boolean testNom() {
        int nbNonChar = 0;
        for (int i = 1; i < txtnom.getText().trim().length(); i++) {
            char ch = txtnom.getText().charAt(i);
            if (!Character.isLetter(ch)) {
                nbNonChar++;
            }
        }

        if (nbNonChar == 0 && txtnom.getText().trim().length() >= 3) {
            checknom.setImage(new Image("Images/checkMark.png"));
           
            return true;
        } else {
            checknom.setImage(new Image("Images/erreurCheckMark.png"));
         
//                erreur = erreur + ("Pas de caractere permit dans le telephone\n");
            return false;

        }

    }
private Boolean testPrenom() {
        int nbNonChar = 0;
        for (int i = 1; i < txtprenom.getText().trim().length(); i++) {
            char ch = txtprenom.getText().charAt(i);
            if (!Character.isLetter(ch)) {
                nbNonChar++;
            }
        }

        if (nbNonChar == 0 && txtprenom.getText().trim().length() >= 3) {
            checkprenom.setImage(new Image("Images/checkMark.png"));
           
           
            return true;
        } else {
           checkprenom.setImage(new Image("Images/erreurCheckMark.png"));
//                erreur = erreur + ("Pas de caractere permit dans le telephone\n");
            return false;

        }

    }
private Boolean testMail() {

        String emailRegex = "^[a-zA-Z0-9_+&*-]+(?:\\."
                + "[a-zA-Z0-9_+&*-]+)*@"
                + "(?:[a-zA-Z0-9-]+\\.)+[a-z"
                + "A-Z]{2,7}$";

        Pattern pat = Pattern.compile(emailRegex);
        if (txtemail.getText() == null) {
            return false;
        }

        if (pat.matcher(txtemail.getText()).matches() == false) {
            checkemail.setImage(new Image("Images/erreurCheckMark.png"));
//                erreur = erreur + ("Veuillez verifier votre adresse email\n");
            return false;
//            

        } else {
            checkemail.setImage(new Image("Images/checkMark.png"));
        }
        return true;

    }
private Boolean testSaisie() {
        String erreur = "";
       
        if (!testTel()) {
            erreur = erreur + ("Telephone doit avoir 8 chiffres et ne doit pas contenir des caracteres \n");
        }
       
        if (!testNom()) {
            erreur = erreur + ("Veuillez verifier votre Nom: seulement des caractères et de nombre >= 3 \n");
        }
        if (!testPrenom()) {
            erreur = erreur + ("Veuillez verifier votre Prenom: seulement des caractères et de nombre >= 3");
        }
         if (!testMail()) {
            erreur = erreur + ("Veuillez verifier votre Prenom: seulement des caractères et de nombre >= 3");
         }
       

        return   testTel()  && testNom() && testPrenom()&& testMail();
    }

    @FXML
    private void contactermed(ActionEvent event) throws IOException {
        MailingController.sendtovalue=tablemed.getSelectionModel().getSelectedItem().getEmail();
        Parent root = FXMLLoader.load(getClass().getResource("Mailing.fxml"));
              Scene scene = new Scene(root);
              Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
              stage.setScene(scene);
              stage.show();
    }

    @FXML
    private void chartaction(ActionEvent event) {
         ServiceMedecin sr = new ServiceMedecin();
        ServiceSpecialite spec = new ServiceSpecialite();
        DefaultPieDataset pieDataset = new DefaultKeyedValuesDataset();
        JFreeChart chart =ChartFactory.createPieChart("Nombre de Specialités par medecin", pieDataset, true, true, true);
        PiePlot P = (PiePlot)chart.getPlot();
       // P.setForegroundAlpha(TOP_ALIGNMENT);
        ChartFrame frame = new ChartFrame("Pie chart",chart);
        frame.setVisible(true);
        frame.setSize(450,500);

       for (int i = 0; i <spec.nb_specialite(); i++)
       { 
           String msg="";
           msg=spec.getValuesSpec().get(i) + " [ " + spec.getnb_specialite_medecin().get(i)+ " ] ";
           pieDataset.setValue(msg,spec.getnb_specialite_medecin().get(i) );
           
        System.out.println(spec.getValuesSpec().get(i));
                System.out.println(spec.getnb_specialite_medecin().get(i));
            //  System.out.println  (spec.nb_specialite());
        
    }
      
    }

    @FXML
    private void GoToMap(ActionEvent event) throws IOException {
          Parent root = FXMLLoader.load(getClass().getResource("MapCord.fxml"));
              Scene scene = new Scene(root);
              Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
              stage.setScene(scene);
              stage.show();
    }
    
   
    



   

}
    

