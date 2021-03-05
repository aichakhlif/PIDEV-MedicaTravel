<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class OffreController extends AbstractController
{
    /**
     * @Route("/offre", name="offre")
     */
    public function index(): Response
    {
        return $this->render('offre/index.html.twig', [
            'controller_name' => 'OffreController',
        ]);
    }
    /**
     * @Route("/listoffre1", name="listoffre1")
     */
    public function listOffrepatient()
    {
        $offre= $this->getDoctrine()->getRepository(Offre::class)->findAll();
        return $this->render("offre/listepatient.html.twig",array('offre'=>$offre));

    }
    /**
     * @Route("/listoffre", name="listoffre")
     */
    public function listOffre()
    {
        $offre= $this->getDoctrine()->getRepository(Offre::class)->findAll();
        return $this->render("offre/list.html.twig",array('offre'=>$offre));

    }
    /**
     * @Route("/newoffre", name="newoffre")
     */
    public function AjouterOffre(Request $requet)
    {
        $offre= new offre();
        $form= $this->createForm(OffreFormType::class,$offre);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($requet);

        if($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($offre);
            $em->flush();
            return $this->redirectToRoute("listoffre");
        }
        return    $this->render("Offre/add.html.twig",[

            'our_form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/dropoffre/{id}", name="dropoffre" )
     * @Method("DELETE")
     */
    public function SupprimerOffre($id)
    {
        $em=$this->getDoctrine()->getManager();
        $delete=$em->getRepository(Offre::class)->find($id);
        $em->remove($delete);
        $em->flush();
        return $this->redirectToRoute('listoffre');

    }
    /**
     * @Route("/updateoffre/{id}", name="updateoffre" )
     * @Method("UPDATE")
     */
    public function ModifierOffre(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $clinique = $em->getRepository(Offre::class)->find($id);
        $form = $this->createForm(OffreFormType::class, $clinique);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listoffre');
        }
        return $this->render('Offre/modifieroffre.html.twig', [
            'our_form' => $form->createView(),
        ]);

    }
}