/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package crudv1;

import EntitiesO.intervention;
import EntitiesO.medecin;
import ServiceO.ServiceIntervention;
import ServiceO.ServiceMedecin;


/**
 *
 * @author BENJOU
 */
public class CrudV1 {

    /**
     * @param args the command line arguments
    
     */
    public static void main(String[] args)  {
        ServiceMedecin sm = new ServiceMedecin();
        ServiceIntervention si = new ServiceIntervention();
        intervention inter = new intervention("kdsff");
       // si.ajouterIntervention(inter);
        si.delete_inter(17);
     //   System.out.print(sm.AfficherMedecin());
       /* medecin m = new medecin(20,"neila","dgqdsfq","dsfqd@;,;","dfdff"); 
        sm.update(m,40);
        sm.AfficherMedecin();*/
        // TODO code application logic here
    }
    
}
