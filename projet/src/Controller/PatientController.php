<?php

namespace App\Controller;

use App\Entity\Patient;

use App\Form\PatientTypType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PatientController extends AbstractController
{

    /**
     * @Route("/Afficher", name="Afficher")
     */
    public function Afficher()
    {
        $patient = $this->getDoctrine()->getRepository(patient::class)->findAll();
        return $this->render('patient/Afficher.html.twig', array('listpatient' => $patient));


    }
    /**
     * @Route("/Afficher1", name="Afficher1")
     *
     */
    public function Afficher1()
    {
        $patient = $this->getDoctrine()->getRepository(patient::class)->findAll();
        return $this->render('patient/Afficherfront.html.twig', array('listpatient' => $patient));


    }


    /**
     * @Route("/addpatient1", name="addpatient1")
     */
    public function addpatient1(Request $request)
    {
        $patient = new Patient();
        $form = $this->createForm(patientTypType::class, $patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($patient);
            $em->flush();
            return $this->redirectToRoute('Afficher1');
        }
        return $this->render("patient/add.html.twig", array("formpatient" => $form->createView()));
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function deleteR($id)
    {
        $patient = $this->getDoctrine()->getRepository(Patient::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($patient);
        $em->flush();
        return $this->redirectToRoute("Afficher");
    }
    /**
     * @Route("/delete1/{id}", name="delete1")
     */
    public function delete1($id)
    {
        $patient = $this->getDoctrine()->getRepository(Patient::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($patient);
        $em->flush();
        return $this->redirectToRoute("Afficher1");
    }

    /**
     * @Route("/updatepatient/{id}", name="updatepatient")
     */
    public function updatepatient(Request $request,$id){
        $patient=  $this->getDoctrine()->getManager()->getRepository(Patient::class)->find($id);

        $form = $this->createForm(PatientTypType::class,$patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() ){
            $em = $this->getDoctrine()->getManager();
            //$em->persist($student);
            $em->flush();//mise a jour

            return $this->redirectToRoute('Afficher');
        }
        return $this->render("patient/add.html.twig", array("formpatient" => $form->createView()));
    }
}