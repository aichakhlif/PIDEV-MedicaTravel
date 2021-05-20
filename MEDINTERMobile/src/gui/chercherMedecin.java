/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package gui;

import Entities.medecin;
import ServiceMedecin.MedecinService;
import com.codename1.components.ImageViewer;
import com.codename1.components.SpanLabel;
import com.codename1.ui.Container;
import com.codename1.ui.EncodedImage;
import com.codename1.ui.Form;
import com.codename1.ui.Image;
import com.codename1.ui.TextField;
import com.codename1.ui.URLImage;
import com.codename1.ui.layouts.BoxLayout;
import com.codename1.ui.list.ContainerList;
import com.codename1.ui.util.Resources;
import com.mycompany.myapp.MyApplication;
import static com.mycompany.myapp.MyApplication.theme;
import java.util.ArrayList;

/**
 *
 * @author BENJOU
 */
public class chercherMedecin extends Form{
   Resources theme;
   String chercher;
    private ContainerList listContainer;

    public chercherMedecin(Resources theme,String chercher) {
        this.theme=theme;
        this.setLayout(BoxLayout.y());
                   this.chercher=chercher; 


        addGui();
        addAction();
    }
      private void addGui() {
        listContainer = new ContainerList();
        listContainer.setScrollableY(false);
        listContainer.setScrollVisible(true);
            MedecinService ms = new MedecinService();

     ArrayList<medecin> allmedecins = ms.getMedecins(chercher);
        for (medecin m : allmedecins){
       //AFFICHER Image
            EncodedImage placeHolder = EncodedImage.createFromImage(MyApplication.theme.getImage("placeholder-image.png"), false);
            String url = "http://127.0.0.1:8000/Uploads/Image/" + m.getPic();
            Image img = URLImage.createToStorage(placeHolder, url, url);
            ImageViewer image = new ImageViewer(img);
       //End Afficher Image
       Container c = new Container();
       c.setLayout(BoxLayout.y());
       c.add(image);
       c.add(new SpanLabel("nom : " + m.getNom()));
       c.add(new SpanLabel("prenom : " + m.getPrenom()));
       c.add(new SpanLabel("numero  : " + m.getNum()));
       c.add(new SpanLabel("Email  : " + m.getEmail()));
       c.add(new SpanLabel("List speicalites : " + m.getListspec()));
       getToolbar().addCommandToLeftSideMenu("Retour",null,(evt)->{
           Form medecinList = new MedecinFormFront(theme);
        medecinList.show();
       });
       listContainer.add(c);
       
   
   }
   this.add(listContainer);
   }

    private void addAction() {
    
    }
    
    
    
}
