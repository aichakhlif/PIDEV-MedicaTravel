/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import EntitiesO.Mapa;
import com.teamdev.jxmaps.LatLng;
import com.teamdev.jxmaps.Marker;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.CheckBox;
import javafx.scene.control.Label;
import javafx.scene.control.TextField;

/**
 * FXML Controller class
 *
 * @author BENJOU
 */
public class MapCordController implements Initializable {

    @FXML
    private TextField longitude1;
    @FXML
    private TextField latitude1;
    @FXML
    private TextField longitude;
    @FXML
    private TextField latitude;
    @FXML
    private CheckBox cercle_check;
    boolean  test = false;

    /**
     * Initializes the controller class.
     */
    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    }    

    @FXML
    private void AfficherMap(ActionEvent event) {
         Mapa example = new Mapa("MAP");
           LatLng pos= new LatLng(Double.valueOf(longitude.getText()), Double.valueOf(latitude.getText()));
          LatLng pos2= new LatLng(Double.valueOf(longitude1.getText()), Double.valueOf(latitude1.getText()));

           Marker m = example.generateMarker(pos);
           if (test)
           {example.generateArea(pos,0.2);}
           example.generateSimplePath(pos,pos2, true);
    }

    @FXML
    private void TestCercle(ActionEvent event) {
        test=true;
    }
    
    
}
