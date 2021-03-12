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


class ReservationoffreController extends AbstractController
{
    /**
     * @Route("/reservationoffre", name="reservationoffre")
     */
    public function index(): Response
    {
        return $this->render('reservationoffre/index.html.twig', [
            'controller_name' => 'ReservationoffreController',
        ]);
    }

    /**
     * @Route("/listResOffre", name="listResOffre")
     */
    public function listResOffre()
    {

        $res= $this->getDoctrine()->getRepository(ReservationOffre::class)->findAll();
        return $this->render("reservationoffre/listResOffre.html.twig",array('res'=>$res));
    }

    /**
     * @Route("/newresof/{id}", name="offre")

    public function reserveroffre(Request $request,$id)
    {
        $res= new ReservationOffre();
        //$form= $this->createForm(ReservationformType::class,$res);
        $form = $this->createForm(
            ReservationformType::class,
            array('offre' => $this->getParameter($id))
        );
        $form->add("Book appoitment",SubmitType::class,['attr'=>[
            'class'=>"site-btn"
        ]]);
        $em=$this->getDoctrine()->getManager();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $em->persist($res);

            $em->flush();
            return $this->redirectToRoute("listResOffre");
        }

        return    $this->render("reservationoffre/espaceclient.html.twig",['our_form'=>$form->createView()]);

    } */

    /**
     * @Route("/newresof", name="of")
*/
    public function reserveroffre(Request $request)
    {
    $res= new ReservationOffre();
    $form= $this->createForm(ReservationformType::class,$res);

    $form->add("Book appoitment",SubmitType::class,['attr'=>[
    'class'=>"site-btn"
    ]]);
    $em=$this->getDoctrine()->getManager();

    $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid())
    {
    $em->persist($res);

    $em->flush();
    return $this->redirectToRoute("listResOffre");
    }

    return    $this->render("reservationoffre/espaceclient.html.twig",['our_form'=>$form->createView()]);

    }


    /**
     * @Route("/dropreservationof/{id}", name="drop" )
     * @Method("DELETE")
     */


    public function remove( ReservationOffre  $id)
    {
        //$classr= $this->getDoctrine()->getRepository(classroom::class)->find(id);
        $em=$this->getDoctrine()->getManager();
        $em->remove($id);
        $em->flush();
        return $this->redirectToRoute("listResOffre");

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
     * @Route("/listreservationoffreBACK", name="resoffreBACK")
     */
    public function listreservationoffreback()
    {

        $res= $this->getDoctrine()->getRepository(ReservationOffre::class)->findAll();
        return $this->render("back/listresoffreBack.html.twig",array('res'=>$res));
    }





}
