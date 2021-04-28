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
public class intervention {
    private int id ;
    private String description;
    private int  specialite_id;
    private String titre;

    public intervention() {
    }

    public intervention(int id, String description, String titre) {
        this.id = id;
        this.description = description;
        this.titre = titre;
    }

    public String getTitre() {
        return titre;
    }

    public void setTitre(String titre) {
        this.titre = titre;
    }
    

    public intervention(String description) {
        this.description = description;
    }

    public intervention(int id, String description) {
        this.id = id;
        this.description = description;
    }

    public intervention(String description, int specialite_id) {
        this.description = description;
        this.specialite_id = specialite_id;
    }
    

    public intervention(int id, String description, int specialite_id) {
        this.id = id;
        this.description = description;
        this.specialite_id = specialite_id;
    }
    

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public String getDescription() {
        return description;
    }

    public int getSpecialite_id() {
        return specialite_id;
    }

    public void setSpecialite_id(int specialite_id) {
        this.specialite_id = specialite_id;
    }

    public void setDescription(String description) {
        this.description = description;
    }

    @Override
    public String toString() {
        return "intervention{" + "id=" + id + ", description=" + description + ", specialite_id=" + specialite_id + '}';
    }
    

    
    
    
    
}
