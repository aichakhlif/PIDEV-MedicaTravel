<?php

namespace App\Controller;
use App\Entity\Offre;
use App\Entity\Reservation;
use App\Entity\ReservationOffre;


use App\Entity\Student;
use App\Form\MailType;
use App\Form\RechercheType;
use App\Form\ReservationformType;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ReservationController extends AbstractController
{
    /**
     * @Route("/reservation", name="reservation")
     */
    public function index(): Response
    {
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    /**
     * @Route("/listreservation", name="listreservation")
     */
    public function listreservation()
    {

        $res= $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        return $this->render("reservation/listreservation.html.twig",array('res'=>$res));
    }
    /**
     * @Route("/listoffre", name="listoffre")
     */
    public function listoffre()
    {

        $res= $this->getDoctrine()->getRepository(Offre::class)->findAll();
        return $this->render("reservation/listoffre.html.twig",array('res'=>$res));
    }

    /**
     * @Route("/newres", name="new")
     */
    public function add(Request $request)
    {

        $res= new Reservation();
        $form= $this->createForm(ReservationType::class,$res);
        $form->add("Book appoitment",SubmitType::class,['attr'=>[
            'class'=>"site-btn"
        ]]);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($res);

            $em->flush();
            return $this->redirectToRoute("listreservation");
        }

        return    $this->render("reservation/espaceclient.html.twig",['our_form'=>$form->createView()]);

    }


    /**
     * @Route("/editreservation/{id}",name="edit")
     */

    public function edit(Request $request,$id)
    {
        $em=$this->getDoctrine()->getManager();
        $res = $em->getRepository(Reservation::class)->find($id);
        $form = $this->createForm(ReservationType::class, $res);
        $form->add("edit",SubmitType::class,['attr'=>[
            'class'=>"site-btn"
        ]]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $em->flush();
            return $this->redirectToRoute('listreservation');
        }
        return    $this->render("reservation/espaceclient.html.twig",['our_form'=>$form->createView()]);



    }

    /**
     * @Route("/dropreservation/{id}", name="dropreservation" )
     * @Method("DELETE")
     */


    public function remove( Reservation  $id)
    {
        //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listreservation");

    }


    /*****backkkkkkkkk**********************************/
    /**
     * @Route("/reservationback", name="reservationback")
     */
    public function back(): Response
    {
        return $this->render('back/index.html.twig', [
            'controller_name' => 'ReservationController',
        ]);
    }

    /**
     * @Route("/listreservationBACK", name="cc")
     */
    public function listreservationback()
    {

        $res= $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        return $this->render("back/listresBack.html.twig",array('res'=>$res));
    }


    /**
     * @Route("/recherche", name="recherche")

    public function rechercheS(Request $request)
    {
       $res= $this->getDoctrine()->getRepository(Reservation::class)->findAll();

        $form= $this->createForm(RechercheType::class);

        $form->handleRequest($request);

        if($form->isSubmitted())
        {
            $nom=$form->getData()->getNom();
            $res= $this->getDoctrine()->getRepository(Reservation::class)->rechercheS($nom);
            return $this->render("reservation/searchres.html.twig",array('res'=>$res,'our_form'=>$form->createView()));


        }

        return $this->render("reservation/searchres.html.twig",array("res"=>$res,'our_form'=>$form->createView()));
    }
*/

    /**
     * @Route("/mailing", name="mailing")
     */
    public function mailback(Request $request, \Swift_Mailer $mailer)
    {

        $res= $this->getDoctrine()->getRepository(Reservation::class)->findAll();

        $form = $this->createForm(MailType::class);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
         $contact =$form->getData();

           // dd($contact);
            $message=(new \Swift_Message('nouveau contact'))
                ->setFrom('aicha.khlif@esprit.tn')
                ->setTo($contact['email'])
                ->setBody(

                    $this->renderView(
                        'email/email.html.twig', compact('contact')
                    ),
                    'text/html'
                )
                ;
            //on envoie
            $mailer->send($message);
            $this->addFlash('message','le message est envoyer');
            return $this->redirectToRoute("cc");


        }
        return    $this->render("back/contact.html.twig",array("res"=>$res,'our_form'=>$form->createView()));

    }


    /**
     * @Route("/trireservation", name="trireservation")
     */
    public function trireservation()
    {

        $res= $this->getDoctrine()->getRepository(Reservation::class)->listresOrderByPays();
        return $this->render("reservation/listreservation.html.twig",array('res'=>$res));
    }

    /**
     * @Route("/trireservationinter", name="trireservationinter")
     */
    public function trireservationinter()
    {

        $res= $this->getDoctrine()->getRepository(Reservation::class)->listresOrderByintervention();
        return $this->render("reservation/listreservation.html.twig",array('res'=>$res));
    }

    /**
     * @Route("/pdf", name="pdf")
     */
    public function pdf(ReservationRepository $reservationRepository):Response
    {
// Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);

        $res=$reservationRepository->findAll();

        // Retrieve the HTML generated in our twig file
        $html =  $this->render("pdf/pdf.html.twig",['res'=>$res]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);

    }
}

