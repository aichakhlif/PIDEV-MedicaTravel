<?php

namespace App\Controller;

use App\Form\ContactType;


use swift_Message;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Swift_Mailer;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request, \Swift_Mailer $mailer): Response
    { $form=$this->createForm(ContactType::class);
    $form->handleRequest($request);
    if($form->isSubmitted() && $form->isValid())
    {
        $contact=$form->getData();
       $message = (new \Swift_Message('Nouveau Contact'))
           ->setFrom($contact['email'])
           ->setTo('Medica.Codex2@gmail.com')
           ->setbody($this->renderView(
               'email/contact.html.twig', compact('contact')
           ), 'text/html'
           );
       $mailer->send($message);
       $this->addFlash('message','le message a bien ete envoye');
    }
        return $this->render('contact/index.html.twig', [
            'ContactForm' => $form->createView()
        ]);
    }
}
