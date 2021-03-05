<?php

namespace App\Controller;
use App\Entity\Offre;
use App\Entity\Reservation;
use App\Entity\ReservationOffre;


use App\Form\ReservationformType;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;

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




}

