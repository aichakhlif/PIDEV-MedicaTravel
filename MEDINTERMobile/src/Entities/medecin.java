/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package Entities;

import java.util.ArrayList;
import java.util.List;

/**
 *
 * @author BENJOU
 */
public class medecin {
    private int id,num;
    private String nom , prenom ,email,pic;
        private int  specialite_id;

    private String listspec ;

    public medecin() {
    }
    

    public int getSpecialite_id() {
        return specialite_id;
    }

    public void setSpecialite_id(int specialite_id) {
        this.specialite_id = specialite_id;
    }

    public String getListspec() {
        return listspec;
    }

    public void setListspec(String listspec) {
        this.listspec = listspec;
    }

    

    public medecin(int num, String nom, String prenom, String email, String pic) {
        this.num = num;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.pic = pic;
    }

    public medecin(int num, String nom, String prenom, String email, String pic, int specialite_id) {
        this.num = num;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.pic = pic;
        this.specialite_id = specialite_id;
    }
    

    public medecin(int id, int num, String nom, String prenom, String email, String pic) {
        this.id = id;
        this.num = num;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.pic = pic;
    }

    public medecin(int id, int num, String nom, String prenom, String email, String pic, String listspec) {
        this.id = id;
        this.num = num;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.pic = pic;
        this.listspec = listspec;
    }

    public medecin(int id, int num, String nom, String prenom, String email, String pic, int specialite_id, String listspec) {
        this.id = id;
        this.num = num;
        this.nom = nom;
        this.prenom = prenom;
        this.email = email;
        this.pic = pic;
        this.specialite_id = specialite_id;
        this.listspec = listspec;
    }
    

    public int getId() {
        return id;
    }

    public void setId(int id) {
        this.id = id;
    }

    public int getNum() {
        return num;
    }

    public void setNum(int num) {
        this.num = num;
    }

    public String getNom() {
        return nom;
    }

    public void setNom(String nom) {
        this.nom = nom;
    }

    public String getPrenom() {
        return prenom;
    }

    public void setPrenom(String prenom) {
        this.prenom = prenom;
    }

    public String getEmail() {
        return email;
    }

    public void setEmail(String email) {
        this.email = email;
    }

    public String getPic() {
        return pic;
    }

    public void setPic(String pic) {
        this.pic = pic;
    }

    @Override
    public String toString() {
        return "medecin{" + "id=" + id + ", num=" + num + ", nom=" + nom + ", prenom=" + prenom + ", email=" + email + ", pic=" + pic + ", listspec=" + listspec + '}';
    }

    
    
}
