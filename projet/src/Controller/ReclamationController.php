<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    /**
     * @Route("/Afficher2", name="AfficherR")
     */
    public function AfficherR()
    {
        $reclamation = $this->getDoctrine()->getRepository(reclamation::class)->findAll();
        return $this->render('reclamation/AfficherR.html.twig', array('listreclamation' => $reclamation));
    }
    /**
     * @Route("/Afficher3", name="Afficher3")
     */
    public function Afficher3()
    {
        $reclamation = $this->getDoctrine()->getRepository(reclamation::class)->findAll();
        return $this->render('reclamation/Afficher3.html.twig', array('listreclamation' => $reclamation));
    }
    /**
     * @Route("/addR", name="addR")
     */
    public function addreclamation(Request $request)
    {
        $reclamation = new Reclamation();
        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('Afficher3');
        }
        return $this->render("reclamation/addR.html.twig", array("formreclamation" => $form->createView()));
    }
        /**
         * @Route("/deleteR/{id}", name="deleteR")
         */
        public function deleteR($id)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("AfficherR");
    }

    /**
     * @Route("/updateR/{id}", name="updateR")
     */
    public function updateR(Request $request,$id){
        $reclamation=  $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);

        $form = $this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() ){
            $em = $this->getDoctrine()->getManager();
            //$em->persist($student);
            $em->flush();//mise a jour

            return $this->redirectToRoute('AfficherR');
        }
        return $this->render("reclamation/addR.html.twig", array("formreclamation" => $form->createView()));
    }
}
