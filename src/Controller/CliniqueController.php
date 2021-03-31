<?php

namespace App\Controller;

use App\Entity\Clinique;
use App\Form\CliniqueFormType;
use App\Repository\CliniqueRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Psr7\uploadedFile;
use Symfony\Component\HttpFoundation\JsonRespImageonse;



class CliniqueController extends Controller
{ /**
 * @Route("/map", name="map")
 */
    public function map(): Response
    {
        return $this->render('clinique/carte.html.twig');
    }
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
    public function listCliniquepatient(Request $request)
    {
        $cliniques= $this->getDoctrine()->getRepository(Clinique::class)->findAll();
        $clinique = $this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $cliniques,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render("clinique/listepatient.html.twig",array('clinique'=>$clinique));

    }
    /**
     * @Route("/listes", name="listes")
     */
    public function listCliniquepatients1(Request $request)
    {
        $cliniques= $this->getDoctrine()->getRepository(Clinique::class)->categorie();
        $clinique = $this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $cliniques,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render("clinique/listepatient.html.twig",array('clinique'=>$clinique));

    }
    /**
     * @Route("/listes1", name="listes1")
     */
    public function listCliniquepatients2(Request $request)
    {
        $cliniques= $this->getDoctrine()->getRepository(Clinique::class)->categorie1();
        $clinique = $this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $cliniques,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render("clinique/listepatient.html.twig",array('clinique'=>$clinique));

    }
    /**
     * @Route("/listes2", name="listes2")
     */
    public function listCliniquepatients3(Request $request)
    {
        $cliniques= $this->getDoctrine()->getRepository(Clinique::class)->categorie2();
        $clinique = $this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $cliniques,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
        return $this->render("clinique/listepatient.html.twig",array('clinique'=>$clinique));

    }
    /**
     * @Route("/liste3", name="liste")
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
        {/**
         * @var UploadedFile $file
         */
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $clinique->setImage($fileName);
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
        {/**
         * @var UploadedFile $file
         */
            $file = $form->get('image')->getData();
            $fileName = md5(uniqid()).'.'.$file->guessExtension();
            $file->move($this->getParameter('images_directory'),$fileName);
            $clinique->setImage($fileName);
            $em->flush();
            return $this->redirectToRoute('liste');
        }
        return $this->render('clinique/modifierclinique.html.twig', [
            'our_form' => $form->createView(),
        ]);

    }
    /**
     * @Route ("/recherche1",name="recherche1")
     */
    public function recherche(CliniqueRepository   $repository , Request $request)
    {
        $data=$request->get('search');
        $clinique=$repository->SearchName($data);
        return $this->render('clinique/list.html.twig',array('clinique'=>$clinique));
    }
}
