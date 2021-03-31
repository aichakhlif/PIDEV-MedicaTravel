<?php

namespace App\Controller;

use App\Entity\Offre;
use App\Form\OffreFormType;
use App\Repository\OffreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\HttpFoundation\Request;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Component\Mime\Email;
class OffreController extends Controller
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
     * @Route ("/recherche",name="recherche")
     */
    public function recherche(OffreRepository  $repository , Request $request)
    {
        $data=$request->get('search');
        $offre=$repository->SearchName($data);
        return $this->render('offre/list.html.twig',array('offre'=>$offre));
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
        $offre = $this->getDoctrine()->getRepository(Offre::class)->findAll();
        // Retrieve the HTML generated in our twig file
        $html = $this->render('offre/imprimer.html.twig', ['offre' => $offre]);

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
     * @Route("/listoffre1", name="listoffre1")
     */
    public function listOffrepatient(Request $request)
    {
        $offres= $this->getDoctrine()->getRepository(Offre::class)->DateExpr();
        $offre = $this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $offres,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );

        return $this->render("offre/listepatient.html.twig",array('offre'=>$offre));


    }
    /**
     * @Route("/listoffre2", name="listoffre2")
     */
    public function listOffrepatientri(Request $request)
    {
        $offres= $this->getDoctrine()->getRepository(Offre::class)->listOrderByDate();
        $offre = $this->get('knp_paginator')->paginate(
        // Doctrine Query, not results
            $offres,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            3
        );

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
     *  @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     * @Route("/newoffre", name="newoffre")
     */
    public function AjouterOffre(Request $requet,MailerInterface $mailer)
    {
        $offre= new offre();
        $form= $this->createForm(OffreFormType::class,$offre);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($requet);

        if($form->isSubmitted()&& $form->isValid())
        {
            $em->persist($offre);
            $em->flush();
            $email = (new Email())
                ->from('yassine.benzekri@esprit.tn')
                ->to((String)$offre->getClinique()->getEmail())
                ->priority(Email::PRIORITY_HIGH)
                ->subject('[MedicaTravel] Nouvelle Offre !')
                //->text('Sending emails is fun again!')
                ->html('<p>Bonjour cher(e) Responsable </p><br>
                   <p>Votre Clinique a été ajouté dans une nouvelle offre</p><br>');
            $mailer->send($email);
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