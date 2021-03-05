<?php

namespace App\Controller;



use App\Entity\Intervention;
use App\Form\InterventionFormType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;

class InterventionController extends AbstractController
{
    /**
     * @Route("/intervention", name="intervention")
     */
    public function index(): Response
    {
        return $this->render('intervention/index.html.twig', [
            'controller_name' => 'InterventionController',
        ]);
    }
    /**
     * @Route("/listinter", name="listinter")
     */
    public function listinter()
    {
        $inter= $this->getDoctrine()->getRepository(Intervention::class)->findAll();
        return $this->render("intervention/list.html.twig",array('inter'=>$inter));

    }
    /**
     * @Route("/newinter", name="newinter")
     */
    public function Ajouterinter(Request $requet)
    {
        $inter= new Intervention();
        $form= $this->createForm(InterventionFormType::class,$inter);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($requet);

        if($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($inter);
            $em->flush();
            return $this->redirectToRoute("listinter");
        }
        return    $this->render("intervention/add.html.twig",[

            'our_form'=>$form->createView()
        ]);
    }
    /**
     * @Route("/dropinter/{id}", name="dropinter" )
     * @Method("DELETE")
     */
    public function dropinter($id)
    {
        $em=$this->getDoctrine()->getManager();
        $delete=$em->getRepository(intervention::class)->find($id);
        $em->remove($delete);
        $em->flush();
        return $this->redirectToRoute('listinter');

    }
}
