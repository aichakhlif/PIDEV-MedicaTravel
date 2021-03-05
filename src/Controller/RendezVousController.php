<?php

namespace App\Controller;

use App\Entity\RendezVous;
use App\Form\RendezVousType;

use App\Repository\RendezVousRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

class RendezVousController extends AbstractController
{
    /**
     * @Route("rdv", name="rendezvous")
     */
    public function index(): Response
    {
        return $this->render('rendez_vous/index.html.twig', [
            'controller_name' => 'RendezVousController',
        ]);
    }
    /**
     * @Route("/listR", name="listR")
     */
    public function listR()
    {

        $ren= $this->getDoctrine()->getRepository(RendezVous::class)->findAll();
        return $this->render("rendez_vous/listeR.html.twig",array('ren'=>$ren));
    }
    /**
    /**
     * @Route("/newR", name="new")
     */
    public function add(Request $request)
    {

        $ren= new RendezVous();
        $form= $this->createForm(RendezVousType::class,$ren);
        $form->add("Book appoitment",SubmitType::class,['attr'=>[
            'class'=>"site-btn"
        ]]);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $em->persist($ren);

            $em->flush();
            return $this->redirectToRoute("listR");
        }

        return    $this->render("rendez_vous/add.html.twig",['our_form'=>$form->createView()]);

    }

    /**
     * @Route("/editR/{id}",name="edit")
     */

    public function edit(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $ren = $em->getRepository(RendezVous::class)->find($id);
        $form = $this->createForm(RendezVousType::class, $ren);
        $form->add("edit",SubmitType::class,['attr'=>[
            'class'=>"site-btn"
        ]]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listR');
        }
        return    $this->render("rendez_vous/add.html.twig",['our_form'=>$form->createView()]);

    }

    /**
     * @Route("/dropR/{id}", name="drop" )
     * @Method("DELETE")
     */


    public function remove( RendezVous  $id)
    {
        //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listR");

    }
}
