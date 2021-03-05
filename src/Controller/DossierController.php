<?php

namespace App\Controller;

use App\Entity\Dossier;
use App\Form\DossierType;


use App\Repository\DossierRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;


class DossierController extends AbstractController
{
    /**
     * @Route("/dossierA", name="dossier")
     */
    public function index(): Response
    {
        return $this->render('dossier/index.html.twig', [
            'controller_name' => 'DossierController',
        ]);
    }
    /**
     * @Route("/listdos", name="listdos")
     */
    public function listdos()
    {

        $dos= $this->getDoctrine()->getRepository(Dossier::class)->findAll();
        return $this->render("dossier/listeDossier.html.twig",array('dos'=>$dos));
    }
    /**
     * @Route("/newdos", name="cc")
     */
    public function add(Request $request)
    {

        $dos= new dossier();
        $form= $this->createForm(DossierType::class,$dos);
        $form->add("Book appoitment",SubmitType::class,['attr'=>[
            'class'=>"site-btn"
        ]]);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {

            $em->persist($dos);

            $em->flush();
            return $this->redirectToRoute("listdos");
        }

        return    $this->render("dossier/add.html.twig",['our_form'=>$form->createView()]);

    }

    /**
     * @Route("/editdossier/{id}",name="editd")
     */

    public function edit(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $dos = $em->getRepository(Dossier::class)->find($id);
        $form = $this->createForm(DossierType::class, $dos);
        $form->add("edit",SubmitType::class,['attr'=>[
            'class'=>"site-btn"
        ]]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listdos');
        }
        return    $this->render("dossier/add.html.twig",['our_form'=>$form->createView()]);



    }

    /**
     * @Route("/dropdossier/{id}", name="dropd" )
     * @Method("DELETE")
     */


    public function remove( Dossier  $id)
    {
        //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listdos");

    }

    /*****backkkkkkkkk**********************************/
    /**
     * @Route("/dossierback", name="dossierback")
     */
    public function back(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'DossierController',
        ]);
    }

    /**
     * @Route("/listdossierBACK", name="cc")
     */
    public function listdossierback()
    {

        $dos= $this->getDoctrine()->getRepository(Dossier::class)->findAll();
        return $this->render("back/listDossier.html.twig",array('dos'=>$dos));
    }
}
