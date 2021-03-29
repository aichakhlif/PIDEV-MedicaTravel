<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Intervention;
use App\Entity\Medecin;
use App\Entity\Specialite;
use App\Form\InterventionFType;
use App\Form\MedecinFType;
use App\Form\SearchForm;
use App\Repository\InterventionRepository;
use App\Repository\MedecinRepository;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;

class InterventionController extends Controller
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
     * @Route("/searchdatainter", name="inter")
     */
    public function index(InterventionRepository $repository, Request $request)
    {
        $data = new SearchData();
        $form = $this->createForm(SearchForm::class, $data);
        $form->handleRequest($request);

        $op = $repository->findSearch($data);
        return $this->render('intervention/consulterIntervention.html.twig', [
            'listintervention' => $op,
            'form' => $form->createView()
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

    public function listoperations(MedecinRepository $medecinRepository)
    {
        $s=$medecinRepository->getCustomInformations();
        $op= $this->getDoctrine()->getRepository(Intervention::class)->findAll();
        return $this->render("intervention/listintervention.html.twig",array('listintervention'=>$op,'stat'=>$s));

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
    /**
     * @Route("/listimprimer",name="listimprimer")
     */
    public function list2()
    {
        //récupérer tous les articles de la table article de la BD
        // et les mettre dans le tableau $articles


        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);
        $inter = $this->getDoctrine()->getRepository(Intervention::class)->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->render('intervention/imprimer.html.twig', ['inter' => $inter]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (inline view)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => false
        ]);


    }

    /**
     * @Route("/voirinter/{idspec}",name="consulterMedecin_parSpecialite")
     */
    public function consulterMedecin(Request $request,$idspec)
    {
       $medecins= $this->getDoctrine()->getRepository(Medecin::class)->findwithSpec($idspec);
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

}
