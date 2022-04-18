<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EspaceUserController extends AbstractController
{
    #[Route('/espace/user', name: 'app_espace_user')]
    public function index(): Response
    {
        return $this->render('espace_user/index.html.twig', [
            'controller_name' => 'EspaceUserController',
        ]);
    }
}
