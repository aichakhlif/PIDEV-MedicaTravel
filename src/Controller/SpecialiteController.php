<?php

namespace App\Controller;

use App\Entity\Specialite;
use App\Form\Specialite1Type;
use App\Repository\SpecialiteRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/specialite")
 */
class SpecialiteController extends AbstractController
{
    /**
     * @Route("/", name="specialite_index", methods={"GET"})
     */
    public function index(SpecialiteRepository $specialiteRepository): Response
    {
        return $this->render('specialite/index.html.twig', [
            'specialites' => $specialiteRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="specialite_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $specialite = new Specialite();
        $form = $this->createForm(Specialite1Type::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($specialite);
            $entityManager->flush();

            return $this->redirectToRoute('specialite_index');
        }

        return $this->render('specialite/new.html.twig', [
            'specialite' => $specialite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specialite_show", methods={"GET"})
     */
    public function show(Specialite $specialite): Response
    {
        return $this->render('specialite/show.html.twig', [
            'specialite' => $specialite,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="specialite_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Specialite $specialite): Response
    {
        $form = $this->createForm(Specialite1Type::class, $specialite);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('specialite_index');
        }

        return $this->render('specialite/edit.html.twig', [
            'specialite' => $specialite,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="specialite_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Specialite $specialite): Response
    {
        if ($this->isCsrfTokenValid('delete'.$specialite->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($specialite);
            $entityManager->flush();
        }

        return $this->redirectToRoute('specialite_index');
    }
}
