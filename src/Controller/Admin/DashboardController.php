<?php

namespace App\Controller\Admin;


use App\Entity\Article;
use App\Entity\Categoryarticles;
use App\Entity\Comment;
use App\Entity\Recipe;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    public function __construct(
        private AdminUrlGenerator $adminUrlGenerator
    )
    {

    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        $url = $this->adminUrlGenerator
            ->setController(ArticleCrudController::class)
            ->generateUrl();
        return $this->redirect($url);


    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Thermorientalix');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Aller sur le site internet', 'fa fa-undo', routeName:'home.index' );
        yield MenuItem::linkToDashboard('Tableau de bord', 'fa fa-home');


        yield MenuItem::subMenu('Espace recettes', 'fa-solid fa-blender')->setSubItems([
            MenuItem::linkToCrud('Voir les recettes', 'fa fa-plus', Recipe::class),
            MenuItem::linkToCrud('Ajouter une recette', 'fa fa-eye', Recipe::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les categorie', 'fa fa-plus', Recipe::class),
        ]);


        yield MenuItem::subMenu('Blog', 'fa fa-newspaper')->setSubItems([

            MenuItem::linkToCrud('Voir les article', 'fa fa-plus', Article::class),
            MenuItem::linkToCrud('Ajouter un article', 'fa fa-eye', Article::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les categories', 'fa fa-plus', Categoryarticles::class),
            MenuItem::linkToCrud('Ajouter une categories', 'fa fa-eye', Categoryarticles::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les commentaires', 'fa fa-plus', Comment::class),

            ]);
        yield MenuItem::section('Videos', 'fa-solid fa-photo-film');
        yield MenuItem::section('Users', 'fa-solid fa-users');
        yield MenuItem::section('Petites annonces', 'fa-solid fa-bullhorn');


        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}
