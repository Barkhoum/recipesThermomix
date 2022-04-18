<?php

namespace App\Controller;

use App\Repository\ArticleRepository;
use App\Repository\CategoryarticlesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BlogController extends AbstractController
{
    #[Route('/blog', name: 'app_blog', methods: ['GET'])]
    public function index(ArticleRepository $articleRepo, CategoryarticlesRepository $categoryRepo): Response
    {
        return $this->render('pages/blog/index.html.twig', [
            'articles' => $articleRepo->findAll(),
            'categories' => $categoryRepo->findAllForWidget()
        ]);
    }
}
