/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import EntitiesO.JavaMailUtil;
import com.jfoenix.controls.JFXButton;
import java.io.IOException;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.animation.TranslateTransition;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.FXMLLoader;
import javafx.fxml.Initializable;
import javafx.geometry.Pos;
import javafx.scene.Node;
import javafx.scene.Parent;
import javafx.scene.Scene;
import javafx.scene.control.Alert;
import javafx.scene.control.Button;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;
import javafx.scene.layout.VBox;
import javafx.stage.Stage;
import javafx.util.Duration;
import javax.mail.MessagingException;
//import org.controlsfx.control.Notifications;



/**
 * FXML Controller class
 *
 * @author BENJOU
 */
public class MailingController implements Initializable {

    @FXML
    private TextField sendTO;
    @FXML
    private TextField Subject;
    @FXML
    private TextField text;
    @FXML
    private Button envoyer;
    @FXML
    private VBox slider;
    @FXML
    private JFXButton btn_spec1;
    @FXML
    private JFXButton btn_inter1;
    @FXML
    private JFXButton btn_med1;
    @FXML
    private Label Menu;
    @FXML
    private Label MenuClose;
   public static String sendtovalue;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        //System.out.print("sendvalue = "+ sendtovalue);
        sendTO.setText(sendtovalue);
        sendTO.setDisable(true);
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
    
        // TODO
    }    

    @FXML
    private void envoyeraction(ActionEvent event) throws MessagingException {
        
    JavaMailUtil.sendmail(sendTO.getText(),Subject.getText(),text.getText());
    /*Notifications notificationBuilder;
        notificationBuilder = Notifications.create()
                .title("test")
                .text("dmmdmdmd")
                .graphic(null)
                .hideAfter(Duration.seconds(5))
                .position(Pos.TOP_RIGHT);
    
            notificationBuilder.showConfirm();*/
    
  
                           
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
    private void gotomed(ActionEvent event) throws IOException {
         Parent root = FXMLLoader.load(getClass().getResource("AfficherMedecin.fxml"));
              Scene scene = new Scene(root);
              Stage stage = (Stage) ((Node) event.getSource()).getScene().getWindow();
              stage.setScene(scene);
              stage.show();
    }

    public String getSendTO() {
        return sendTO.getText();
    }

    public void setSendTO(String sendTO) {
        this.sendTO.setText(sendTO);
    }
    


    
}
