<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Comment;
use App\Form\Type\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ArticlesController extends AbstractController
{
    private EntityManagerInterface $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/articles', name: 'app_articles')]
    public function index(): Response
    {
        $repository = $this->entityManager->getRepository(Article::class);
        $articles = $repository->findAll([],['id' =>'DESC']);

        return $this->render('pages/blog/articles/index.html.twig');


    }
    #[Route('/article/{slug}', name: 'article_show')]
    public function show(?Article $article): Response
    {
        if(!$article){
            return $this->redirectToRoute('app_blog');
        }
        $comment = new Comment($article);

        $commentForm = $this->createForm(CommentType::class,$comment );

        return $this->renderForm('pages/blog/articles/index.html.twig', [
            'article' => $article,
            'commentForm'=> $commentForm

        ]);
    }
}
