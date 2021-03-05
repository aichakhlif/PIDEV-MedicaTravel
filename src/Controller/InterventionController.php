<?php

namespace App\Controller;

use App\Entity\Intervention;
use App\Form\InterventionFType;
use App\Form\MedecinFType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class InterventionController extends AbstractController
{

    /**
     * @Route("/addop", name="newop")
     */
    public function AjouterIntervention(Request $requet)
    {
        $inter= new intervention();
        $form= $this->createForm(InterventionFType::class,$inter);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($requet);

        if($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($inter);
            $em->flush();
            return $this->redirectToRoute("showop");
        }
        return    $this->render("intervention/addINTER.html.twig",[

            'OPform'=>$form->createView()
        ]);
    }
    /**
     * @Route("/voirinter", name="interventions")
     */

    public function consulterintervention()
    {
        $op= $this->getDoctrine()->getRepository(Intervention::class)->findAll();
        return $this->render("intervention/consulterIntervention.html.twig",array('listintervention'=>$op));

    }

    /**
     * @Route("/listeInter", name="showop")
     */

    public function listoperations()
    {
        $op= $this->getDoctrine()->getRepository(Intervention::class)->findAll();
        return $this->render("intervention/listintervention.html.twig",array('listintervention'=>$op));

    }
    /**
     * @Route("/updateINTER/{id}", name="updateOP" )
     */

    public function Modifierintervention(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $op = $em->getRepository(Intervention::class)->find($id);
        $form = $this->createForm(InterventionFType::class, $op);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('showop');
        }
        return $this->render('intervention/addINTER.html.twig', [
            'OPform' => $form->createView(),
        ]);

    }
    /**
     * @Route("/deleteintervention/{id}", name="deleteOP" )
     */

    public function SupprimerIntervention($id)
    {
        $em=$this->getDoctrine()->getManager();
        $op=$em->getRepository(Intervention::class)->find($id);
        $em->remove($op);
        $em->flush();
        return $this->redirectToRoute('showop');

    }

}
