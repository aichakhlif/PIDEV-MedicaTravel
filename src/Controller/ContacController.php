<?php

namespace App\Controller;

use App\Entity\Medecin;
use App\Form\ContactType;


use swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Swift_Mailer;

class ContacController extends AbstractController
{
    /**
     * @Route("/contactou/{id}", name="contactous")
     * @return Response
     *
     *
     */
    public function index(Request $request, \Swift_Mailer $mailer,$id): Response
    {  $med=$this->getDoctrine()->getRepository(Medecin::class)->find($id);
        $form=$this->createForm(ContactType::class);
        $form->get('email')->setData($med->getEmail());
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $contact=$form->getData();
            $message = (new \Swift_Message('Nouveau Contact'))
                ->setFrom('Medica.Codex2@gmail.com')
                ->setTo($contact['email'])
                ->setbody($this->renderView(
                    'email/contactou.html.twig', compact('contact')
                ), 'text/html'
                );
            $mailer->send($message);
            $this->addFlash('message','le message a bien ete envoye');

        }
        return $this->render('contac/index.html.twig', [
            'ContactForm' => $form->createView()
        ]);
    }
}