<?php

namespace App\Controller;

use App\Entity\Reclamation;
use App\Form\ReclamationType;
use App\Repository\ReclamationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Dompdf\Dompdf;
use Dompdf\Options;
class ReclamationController extends AbstractController
{
    /**
     * @Route("/reclamation", name="reclamation")
     */
    public function index(): Response
    {
        return $this->render('reclamation/index.html.twig', [
            'controller_name' => 'ReclamationController',
        ]);
    }
    /**
     * @Route("/Afficher2", name="Afficher2")
     */
    public function Afficher()
    {
        $reclamation = $this->getDoctrine()->getRepository(reclamation::class)->findAll();

        return $this->render('reclamation/AfficherR.html.twig', array('listreclamation' => $reclamation));
    }
    /**
     * @Route("/Afficher3", name="Afficher3")
     */
    public function Afficher3()

    {

        $reclamation = $this->getDoctrine()->getRepository(reclamation::class)->findAll();
        return $this->render('reclamation/Afficher2.html.twig', array('listreclamation' => $reclamation));
    }
    /**
     * @Route("/addR", name="addR")
     */
    public function addreclamation(Request $request)
    {
        $reclamation = new Reclamation();

        $form = $this->createForm(ReclamationType::class, $reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($reclamation);
            $em->flush();
            return $this->redirectToRoute('Afficher3');
        }
        return $this->render("reclamation/addR.html.twig", array("formreclamation" => $form->createView()));
    }
        /**
         * @Route("/deleteR/{id}", name="deleteR")
         */
        public function deleteR($id)
    {
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($reclamation);
        $em->flush();
        return $this->redirectToRoute("Afficher3");
    }

    /**
     * @Route("/updateR/{id}", name="updateR")
     */
    public function updateR(Request $request,$id){
        $reclamation=  $this->getDoctrine()->getManager()->getRepository(Reclamation::class)->find($id);

        $form = $this->createForm(ReclamationType::class,$reclamation);
        $form->handleRequest($request);
        if ($form->isSubmitted() ){
            $em = $this->getDoctrine()->getManager();
            //$em->persist($student);
            $em->flush();//mise a jour

            return $this->redirectToRoute('Afficher3');
        }
        return $this->render("reclamation/addR.html.twig", array("formreclamation" => $form->createView()));
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
        $reclamation = $this->getDoctrine()->getRepository(Reclamation::class)->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->render('Reclamation/imprimer.html.twig', ['reclamation' => $reclamation]);

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
     * @Route ("/rechercherec",name="rechercherec")
     */
    public function recherche(ReclamationRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $reclamation=$repository->SearchName($data);
        return $this->render('reclamation/AfficherR.html.twig',array('listreclamation'=>$reclamation));
    }
    /***************back***********/
    /**
     * @Route("/AfficherRback", name="AfficherRback")
     */
    public function AfficherRback()

    {

        $reclamation = $this->getDoctrine()->getRepository(reclamation::class)->findAll();
        return $this->render('reclamation/AfficherR.html.twig', array('listreclamation' => $reclamation));
    }
}
