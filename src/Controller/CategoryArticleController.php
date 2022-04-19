<?php

namespace App\Controller;

use App\Entity\Article;
use App\Entity\Categoryarticles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryArticleController extends AbstractController
{
    #[Route('/category/articles/{slug}', name: 'categoryarticles')]
    public function show(?Categoryarticles $categoryarticles): Response
    {

        return $this->render('pages/blog/categoryarticles/index.html.twig', [
            'categoryarticles'=> $categoryarticles,



        ]);
    }
}
