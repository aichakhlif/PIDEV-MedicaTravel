/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package EntitiesO;

/**
 *
 * @author BENJOU
 */
public class specialite {
     private int id ;
    private String titre;

    public specialite() {
    }

    
    public specialite(String titre) {
        this.titre = titre;
    }

    public specialite(int id, String titre) {
        this.id = id;
        this.titre = titre;
    }

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }

    @Override
    public String toString() {
        return "specialite{" + "id=" + id + ", titre=" + titre + '}';
    }
    
    
    
}
