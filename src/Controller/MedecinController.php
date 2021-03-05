<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\MedecinFType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MedecinController extends AbstractController
{
    /**
     * @Route("/consulter", name="consultermedecin")
     */

    public function consuterMedecin()
    {
        $medecin= $this->getDoctrine()->getRepository(Medecin::class)->findAll();
        return $this->render("medecin/consultermedecinFront.html.twig",array('listmedecin'=>$medecin));

    }


    /**
     * @Route("/liste", name="showmedecin")
     */

    public function listDoctor()
    {
        $medecin= $this->getDoctrine()->getRepository(Medecin::class)->findAll();
        return $this->render("medecin/listemedecin.html.twig",array('listmedecin'=>$medecin));

    }

    /**
     * @Route("/addmedecin", name="newmedecin")
     */
    public function AjouterMedecin(Request $requet)
    {
        $medecin= new medecin();
        $form= $this->createForm(MedecinFType::class,$medecin);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($requet);

        if($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($medecin);
            $em->flush();
            return $this->redirectToRoute("showmedecin");
        }
        return    $this->render("medecin/add.html.twig",[

            'Doctorform'=>$form->createView()
        ]);
    }


    /**
     * @Route("/deleteMedecin/{id}", name="deleteDOC" )
     */

    public function SupprimerMedecin($id)
    {
        $em=$this->getDoctrine()->getManager();
        $doc=$em->getRepository(Medecin::class)->find($id);
        $em->remove($doc);
        $em->flush();
        return $this->redirectToRoute('showmedecin');

    }

    /**
     * @Route("/updateMedecin/{id}", name="updateDOC" )
     */

    public function ModifierMedecin(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $medecin = $em->getRepository(Medecin::class)->find($id);
        $form = $this->createForm(MedecinFType::class, $medecin);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('showmedecin');
        }
        return $this->render('medecin/add.html.twig', [
            'Doctorform' => $form->createView(),
        ]);

    }
}
