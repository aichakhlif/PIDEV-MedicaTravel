<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\PostLike;
use App\Entity\User;
use App\Entity\Categorie;
use App\Entity\Comment;
use App\Form\ArticleType;
use App\Form\CategorieType;
use App\Form\CommentsType;
use App\Repository\ArticleRepository;
use App\Repository\CategorieRepository;
use App\Repository\PostLikeRepository;
use ContainerAj7bnPz\PaginatorInterface_82dac15;
use Doctrine\Persistence\ObjectManager;
use Psr\Container\ContainerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;

class BlogController extends AbstractController
{
    /**
     * @Route("/blog", name="blog")
     */
    public function index(ArticleRepository $repo,CategorieRepository $repo1, Request $request, PaginatorInterface $paginator): Response
    {
        $articles = $paginator->paginate(
            $repo->findAll(), // Requête contenant les données à paginer (ici nos articles)
            $request->query->getInt('page', 1), // Numéro de la page en cours, passé dans l'URL, 1 si aucune page
            3 // Nombre de résultats par page
        );
        $Cat = $repo1->findAll();

        return $this->render('blog/Front/Blog.html.twig', [
            'controller_name' => 'BlogController','articles'=>$articles,'categories'=>$Cat
        ]);
    }

    /**
     * @Route("/blog/{id}", name="blog_show")
     * @param Id $id
     */
    public function show($id, Request $request)
    {
        $repo = $this->getDoctrine()->getRepository(Article::class);
        $repo2 = $this->getDoctrine()->getRepository(Comment::class);
        $comment=new Comment();
        $form=$this->createForm(CommentsType::class,$comment);
        $form->handleRequest($request);
        $hasAccess = $this->isGranted('ROLE_USER');
        $article = $repo->find($id);
        $darticles=$repo->findBy(array(),array('Date'=>'DESC'),3,0);
        $comments= $repo2->findBy(['article'=>$id] , array('createdAt'=>'DESC'));

            if ($form->isSubmitted() && $form->isValid()) {
               if (!$hasAccess){
                   $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
               }
               else{
                   $author=$this->getUser()->getUserName();
                   $comment->setAuthor($author);
                   $dt=new \DateTime();
                   $dt->add(new \DateInterval('PT1H'));
                   $comment->setCreatedAt($dt);
                   $comment->setArticle($article);
                   $em= $this->getDoctrine()->getManager();
                   $em->persist($comment);
                   $em->flush();
                   return $this->redirectToRoute('blog_show', array('id' => $id));
               }

            }

        return $this->render('blog/Front/show.html.twig',['article'=>$article,'comments'=>$comments,'darticles'=>$darticles, 'form'=> $form->createView()]);
    }

    /**
     * @Route("/Article/{id}/like", name="Article_Like")
     */
    public function like($id)
    {
        $liked=false;
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user=$this->getUser();
        $manager=$this->getDoctrine()->getManager();
        $article=$manager->getRepository(Article::class)->find($id);
        $likes=$manager->getRepository(PostLike::class)->findAll();
        foreach ($likes as $l){
            if (($l->getUser()->getId()==$user->getId()) && ($l->getArticle()->getId()==$id)){
                $manager->remove($l);
                $manager->flush();
                $liked=true;
                $this->addFlash('warning', 'Post unliked !');
            }
        }
        if (!$liked){
            $PostLike = new PostLike();
            $PostLike->setArticle($article);
            $PostLike->setUser($user);
            $manager->persist($PostLike);
            $manager->flush();
            $this->addFlash('success', 'Post liked !');
        }
        return $this->redirectToRoute('blog');

    }

    /**
     * @Route("/blog/{id}/remove/{idC}", name="blog_uncomment")
     */
    public function removeComment($id,$idC){
        $manager= $this->getDoctrine()->getManager();
        $comment= $manager->getRepository(Comment::class)->find($idC);
        $manager->remove($comment);
        $manager->flush();
        return $this->redirectToRoute('blog_show', array('id' => $id));

    }



    /**
     * @Route("/BackBlog", name="BackBlog")

     */
    public function BackBlogAction(ArticleRepository $repo,CategorieRepository $repo1)
    {
        $categories =$repo1->findAll();
        $articles = $repo->findAll();
        return $this->render('blog/Back/BlogBack.html.twig',['articles'=>$articles,'categories'=>$categories]);
    }

    /**
     * @Route("/Remove/{id}", name="Supprimer" )

     */


    public function removeArticleAction(Article $article)
    {

        $em=$this->getDoctrine()->getManager();
        $em->remove($article);
        $em->flush();
        return $this->redirectToRoute("BackBlog");

    }

    /**
     * @Route("/RemoveCat/{id}", name="SupprimerCat" )

     */


    public function removeCatAction(Categorie $categorie)
    {

        $em=$this->getDoctrine()->getManager();
        $em->remove($categorie);
        $em->flush();
        return $this->redirectToRoute("BackBlog");

    }

    /**
     * @Route("/BackBlog/new", name="Article_new")
     * @Route ("/BackBlog/{id}/edit",name="Blog_edit")
     */
    public function create(Article $article = null,Request $request, \Swift_Mailer $mailer)
    {
        if(!$article) {
            $article = new  Article();
        }
        $form=$this->createForm(ArticleType::class,$article);
        $form->handleRequest($request) ;

        if ($form->isSubmitted()&& $form->isValid())
        {
            $file = $form['Image']->getData();
            if($file)
            {
                $fileName = md5(uniqid()).'.'.$file->guessExtension();
                $article->setImage($fileName);
                $file->move(
                    $this->getParameter('EventImage_directory'),
                    $fileName
                );
            }else
            {
                $article->setImage('default.png');
            }


            if(!$article->getId()) {
                $article->setDate(new \DateTime());
            }

            $manager=$this->getDoctrine()->getManager();
            $manager->persist($article);
            $manager->flush();
            $users=$manager->getRepository(User::class)->findAll();
            foreach ($users as $u){
                $message= (new \Swift_Message('[MedikaTravel] : Nouvel Article'))
                    ->setFrom("medikatravel2021@gmail.com")
                    ->setTo($u->getEmail())
                    ->setBody(
                        $this->renderView('emails/newsletter.html.twig',
                            compact('article')),
                        'text/html');
                $mailer->send($message);
            }

            //$this->redirectToRoute('blogBack_show', ['id' => $article->getId()]);
            return $this->redirectToRoute('BackBlog');

        }

        return $this->render('blog/Back/CreateArticle.html.twig',['formArticle'=>$form->createView(),'editMode'=>$article->getId()!==null]);
    }

    /**
     * @Route("/BackBlog/newCat", name="Cat_new")
     * @Route ("/BackBlog/{id}/edit_Cat",name="Cat_edit")
     */

    public function createCat(Categorie $cat = null,Request $request)
    {
        if(!$cat) {
            $cat = new  Categorie();
        }
        $form=$this->createForm(CategorieType::class,$cat);
        $form->handleRequest($request) ;

        if ($form->isSubmitted()&& $form->isValid())
        {


            $manager=$this->getDoctrine()->getManager();
            $manager->persist($cat);
            $manager->flush();
            //$this->redirectToRoute('blogBack_show', ['id' => $article->getId()]);
            return $this->redirectToRoute('BackBlog');

        }

        return $this->render('blog/Back/CreateCat.html.twig',['formCat'=>$form->createView(),'editMode'=>$cat->getId()!==null]);
    }




    /**
     * @Route("/searchAjax", name="searchAjax")
     */
    public function searchAction(Request $request)
    {
        $em=$this->getDoctrine()->getManager();
        $requestString=$request->get('q');
        $article= $em->getRepository('AppBundle:Article')->findEntitiesByString($requestString);
        if (!$article){
            $result['Article']['error'] = "Aucun resultat";
        }
        else {
            $result['Article'] = $this->getRealEntities($article);
        }

        return new Response(json_encode($result)) ;


    }

    public function getRealEntities($Articles){

        foreach ($Articles as $Article){
            $realEntities[$Article->getTitre()] = $Article->getFoo();
        }

        return $realEntities;
    }

}

