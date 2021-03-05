<?php

namespace App\Controller;
use App\Entity\Medecin;
use App\Form\MedecinFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class MedecinController extends AbstractController
{
    /**
     * @Route("/medecin", name="medecin")
     */
    public function index(): Response
    {
        return $this->render('medecin/index.html.twig', [
            'controller_name' => 'MedecinController',
        ]);
    }
    /**
     * @Route("/listmed", name="listmed")
     */
    public function listmed()
    {
        $med= $this->getDoctrine()->getRepository(medecin::class)->findAll();
        return $this->render("medecin/list.html.twig",array('med'=>$med));

    }
    /**
     * @Route("/newmed", name="newmed")
     */
    public function newmed(Request $requet)
    {
        $med= new Medecin();
        $form= $this->createForm(MedecinFormType::class,$med);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($requet);

        if($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($med);
            $em->flush();
            return $this->redirectToRoute("listmed");
        }
        return    $this->render("medecin/add.html.twig",[

            'our_form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/dropmed/{id}", name="dropmed" )
     * @Method("DELETE")
     */
    public function dropmed($id)
    {
        $em=$this->getDoctrine()->getManager();
        $delete=$em->getRepository(medecin::class)->find($id);
        $em->remove($delete);
        $em->flush();
        return $this->redirectToRoute('listmed');

    }
}
