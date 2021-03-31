<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class RegistrationController extends AbstractController
{
    private $passwordEncoder;

    public function __construct(UserPasswordEncoderInterface $passwordEncoder)
    {
        $this->passwordEncoder = $passwordEncoder;
    }

    /**
     * @Route("/registration", name="registration")
     */
    public function index(Request $request)
    {
        $user = new User();

        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Encode the new users password
            $user->setPassword($this->passwordEncoder->encodePassword($user, $user->getPassword()));

            // Set their role
            $user->setRoles(['ROLE_USER']);

            // Save
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('app_login');
        }

        return $this->render('registration/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
    /**
     * @Route("/update/{id}", name="update")
     */
    public function update(Request $request,$id){
        $patient=  $this->getDoctrine()->getManager()->getRepository(User::class)->find($id);

        $form = $this->createForm(UserType::class,$patient);
        $form->handleRequest($request);
        if ($form->isSubmitted() ){
            $em = $this->getDoctrine()->getManager();
            //$em->persist($student);
            $em->flush();//mise a jour

            return $this->redirectToRoute('Afficherr');
        }
        return $this->render('registration/index.html.twig', array("form" => $form->createView()));
    }
    /**
     * @Route("/Afficherr", name="Afficherr")
     *
     */
    public function Afficher()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('base.html.twig', array('listuser' => $user));
    }
    /**
     * @Route("/AfficherC", name="AfficherC")
     *
     */
    public function AfficherC()
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('registration/Afficher.html.twig', array('listuser' => $user));
    }


    /**
     * @Route("/Afficherb", name="Afficher")
     *
     */
    public function Affichage(UserRepository $userrepository)
    {
        $user1=$userrepository->getCustomInformations();
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();
        return $this->render('back/registration/Afficherback.html.twig', array('listuser' => $user,'stat'=> $user1));
    }
    /**
     * @Route("/remove/{id}", name="remove")
     */
    public function delete($id)
    {
        $user = $this->getDoctrine()->getRepository(User::class)->find($id);
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();
        return $this->redirectToRoute("Afficherr");
    }
    /**
     * @Route ("/recherchemed",name="recherchemed")
     */
    public function recherche(UserRepository $repository , Request $request)
    {
        $data=$request->get('search');
        $user=$repository->SearchName($data);
        return $this->render('registration/Afficherback.html.twig',array('listuser'=>$user));
    }
    /**
     * @Route ("/stat",name="stat")
     */
   /* public function statistiques(UserRepository $userrepo)
    {
        $Users=$userrepo->findAll();
        $userage=[];

        foreach ($Users as $User)
        {
            $userage[]=$User->getage();}
        return $this->render('registration/stats.html.twig',[
                'usernage' => json_encode($userage),

            ]
            );

    }*/
    /**
     * @Route("/users/pass/modifier", name="users_pass_modifier")
     */
    public function editPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if($request->isMethod('POST')){
            $em = $this->getDoctrine()->getManager();

            $user = $this->getUser();

            // On vérifie si les 2 mots de passe sont identiques
            if($request->request->get('pass') == $request->request->get('pass2')){
                $user->setPassword($passwordEncoder->encodePassword($user, $request->request->get('pass')));
                $em->flush();
                $this->addFlash('message', 'Mot de passe mis à jour avec succès');

                return $this->redirectToRoute('Afficherr');
            }else{
                $this->addFlash('error', 'Les deux mots de passe ne sont pas identiques');
            }
        }

        return $this->render('registration/editpass.html.twig');
    }
    /************statpatient*********************/

}