<?php

namespace App\Controller;

use App\Entity\Clinique;
use App\Form\CliniqueFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;


class CliniqueController extends AbstractController
{
    /**
     * @Route("/clinique", name="clinique")
     */
    public function index(): Response
    {
        return $this->render('clinique/index.html.twig', [
            'controller_name' => 'CliniqueController',
        ]);
    }
    /**
     * @Route("/liste1", name="liste1")
     */
    public function listCliniquepatient()
    {
        $clinique= $this->getDoctrine()->getRepository(Clinique::class)->findAll();
        return $this->render("clinique/listepatient.html.twig",array('clinique'=>$clinique));

    }
    /**
     * @Route("/liste", name="liste")
     */
    public function listCliniqueadmin()
    {
        $clinique= $this->getDoctrine()->getRepository(Clinique::class)->findAll();
        return $this->render("clinique/list.html.twig",array('clinique'=>$clinique));

    }
    /**
     * @Route("/newclinique", name="newclinique")
     */
    public function AjouterClinique(Request $requet)
    {
        $clinique= new clinique();
        $form= $this->createForm(CliniqueFormType::class,$clinique);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($requet);

        if($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($clinique);
            $em->flush();
            return $this->redirectToRoute("liste");
        }
        return    $this->render("clinique/add.html.twig",[

            'our_form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/dropclinique/{id}", name="dropclinique" )
     * @Method("DELETE")
     */
    public function dropClinique($id)
    {
        $em=$this->getDoctrine()->getManager();
        $delete=$em->getRepository(Clinique::class)->find($id);
        $em->remove($delete);
        $em->flush();
        return $this->redirectToRoute('liste');

    }
    /**
     * @Route("/updateclinique/{id}", name="updateclinique" )
     * @Method("UPDATE")
     */
    public function ModifierClinique(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $clinique = $em->getRepository(Clinique::class)->find($id);
        $form = $this->createForm(CliniqueFormType::class, $clinique);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('liste');
        }
        return $this->render('clinique/modifierclinique.html.twig', [
            'our_form' => $form->createView(),
        ]);

    }
}
