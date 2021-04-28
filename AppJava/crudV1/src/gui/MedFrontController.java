/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import ServiceO.MyListener;
import EntitiesO.medecin;
import java.io.File;
import java.net.URL;
import java.util.ResourceBundle;
import javafx.event.ActionEvent;
import javafx.fxml.FXML;
import javafx.fxml.Initializable;
import javafx.scene.control.Label;
import javafx.scene.image.Image;
import javafx.scene.image.ImageView;
import javafx.scene.input.MouseEvent;

/**
 * FXML Controller class
 *
 * @author Asus
 */
public class MedFrontController implements Initializable {

    @FXML
    private Label namecl;
    @FXML
    private Label clqn;
    @FXML
    private ImageView clqimg;
    @FXML
    private Label namecl2;
    @FXML
    private Label clqem;
    @FXML
    private Label namecl21;
    @FXML
    private Label clqad;
    @FXML
    private Label namecl211;
    @FXML
    private Label clqtel;
    @FXML
    private Label namecl2111;
private medecin medecin;
private MyListener mylistener;
    @FXML
    private Label clqspec;
    @FXML
    private Label id;
    /**
     * Initializes the controller class.
     */

    @Override
    public void initialize(URL url, ResourceBundle rb) {
        // TODO
    } 
  
        
    

    void setData(medecin medecin, MyListener mylistener) {
        this.medecin=medecin;
        this.mylistener =mylistener;
        this.id.setText(String.valueOf(medecin.getId()));
        clqn.setText(medecin.getNom());
         clqad.setText(medecin.getPrenom());
        clqem.setText(medecin.getEmail());  
        clqtel.setText(""+medecin.getNum());
         clqspec.setText(medecin.getListspec());
       File file = new File(medecin.getPic());
        System.out.println(file);
       
        Image im = null;
        if(file.exists()){
                 im = new Image(file.toURI().toString());
        }else{
            //im = new Image("resources/default-article.jpg"); // this is the defualt photo of the product
        }
         clqimg.setImage(im);
       
    }

    @FXML
    private void click(MouseEvent event) {
          mylistener.onClickListener(medecin);
        FrontFXMain.id_a=Integer.parseInt(this.id.getText());
        System.out.print(medecinFXMain.id_a);
    }

    
    
}
