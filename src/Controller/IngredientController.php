<?php

namespace App\Controller;

use App\Repository\IngredientRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class IngredientController extends AbstractController
{
    #[Route('/ingredient', name: 'ingredient')]
    public function index(Request $request, PaginatorInterface $paginator, IngredientRepository $repository): Response
    {
        
        $ingredients = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1), 10
        );
        return $this->render('pages/index.html.twig', [
            'ingredients' => $ingredients
        ]);
    }
}
