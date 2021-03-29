<?php

namespace App\Controller;

use App\Data\SearchDataMed;
use App\Entity\Medecin;
use App\Form\MedecinFType;
use App\Form\RechercheForm;
use App\Repository\MedecinRepository;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

class MedecinController extends Controller
{
    /**
     * @Route("/searchdatamedecin", name="med")
     */
    public function index(MedecinRepository  $repository, Request $request)
    {
        $data = new SearchDataMed();
        $data->page = $request->get('page',1);
        $form = $this->createForm(RechercheForm::class, $data);
        $form->handleRequest($request);

        $medecin = $repository->SearchMed($data);
        return $this->render('medecin/listemedecinFront.html.twig', [
            'listmedecin' => $medecin,
            'Medform' => $form->createView()
        ]);
    }

    /**
     * @Route("/consulter", name="consultermedecin")
     */

    public function consulterMedecin(Request $request)
    {
        $medecins= $this->getDoctrine()->getRepository(Medecin::class)->findAll();
        $medecin = $this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $medecins,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            4
        );
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
     * @Route("/listeTrie", name="triemedecin")
     */

    public function listTrierDoctor()
    {
        $medecin= $this->getDoctrine()->getRepository(Medecin::class)->listOrderByName();
        return $this->render("medecin/listemedecin.html.twig",array('listmedecin'=>$medecin));

    }
    /**
     * @Route("/Trienum", name="trienummedecin")
     */

    public function listTrierNumDoctor()
    {
        $medecin= $this->getDoctrine()->getRepository(Medecin::class)->listOrderById();
        return $this->render("medecin/listemedecin.html.twig",array('listmedecin'=>$medecin));

    }
    /**
     * @Route("/recherchermedecin", name="searchDOC")
     */

    public function searchDoctor(MedecinRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $medecin=$repository->rechercher($data);
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
            $file = $form['pic']->getData();
            if($file)
            {$fileName = md5(uniqid()).'.'.$file->guessExtension();
            $medecin->setPic($fileName);


                $file->move(
                    $this->getParameter('EventImage_directory'),
                    $fileName
                );

            }else{
                $medecin->setPic('default.jpg');
            }
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
        $em = $this->getDoctrine()->getManager();
        $medecin = $em->getRepository(Medecin::class)->find($id);
        $form = $this->createForm(MedecinFType::class, $medecin);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid())
            {
                $file = $form['pic']->getData();
                if($file) {
                    $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                    $file->move(
                        $this->getParameter('EventImage_directory'),
                        $fileName
                    );
                    $medecin->setPic($fileName);
                }
                $em->flush();
                return $this->redirectToRoute('showmedecin');
            }
            return $this->render('medecin/add.html.twig', [
                'Doctorform' => $form->createView(),
            ]);

        }




}
