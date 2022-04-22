<?php

namespace App\Controller\Admin;

use App\Entity\Article;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use phpDocumentor\Reflection\Types\Boolean;

class ArticleCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE = 'duplicate';
    public const ARTICLES_BASE_PATH = 'upload/images/articles';
    public const ARTICLES_UPLOAD_DIR = 'public/upload/images/articles';


    public static function getEntityFqcn(): string
    {
        return Article::class;
    }

    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new(self::ACTION_DUPLICATE)
            ->linkToCrudAction('duplicateArticle')
            ->SetCssClass('btn btn-success');

        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->reorder(crud::PAGE_EDIT, [self::ACTION_DUPLICATE, action::SAVE_AND_RETURN]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [

            yield IdField::new('id')->hideOnForm(),
            yield FormField::addTab('Etape 1'),
            yield FormField::addPanel('Renseigner tous les champs pour editer votre articles ')->setColumns(6),

            yield TextField::new('title', 'Titre de l\'article')->setColumns(6),
            yield SlugField::new('slug')
                ->setTargetFieldName('title'),
            yield TextareaField::new('featuredText', 'Texte mis en avant')->setColumns(12),
            yield TextEditorField::new('description')->setColumns(12),
            yield FormField::addTab('Etape 2', 'fa-solid fa-hand-point-right'),
            yield FormField::addPanel('Renseigner tous les champs pour editer votre articles '),
            yield ImageField::new('imagePath', 'Photo de l\'article')
                ->setColumns(6)
                ->setBasePath(self::ARTICLES_BASE_PATH)
                ->setUploadDir(self::ARTICLES_UPLOAD_DIR)
                ->setSortable(false),
            yield AssociationField::new('categories')->setQueryBuilder(function (QueryBuilder $queryBuilder) {
                $queryBuilder->where('entity.isPublic = true');
            }),
            yield TextField::new('author', 'l\'auteur de cette article')->setColumns(6),
            yield IntegerField::new('view', 'nombre de vue')->setColumns(6),
            yield IntegerField::new('mark', 'vote')->setColumns(6),
            yield DateTimeField::new('createdAt', 'Date de création'),
            yield BooleanField::new('isPublic', 'Publier cette article'),


        ];
    }

    public function duplicateArticle(
        AdminContext           $context,
        AdminUrlGenerator      $adminUrlGenerator,
        EntityManagerInterface $em
    ): Response
    {
        /** @var Article $article */
        $article = $context->getEntity()->getInstance();

        $duplicatedArticle = clone $article;

        parent::persistEntity($em, $duplicatedArticle);

        $url = $adminUrlGenerator->setController(self::class)
            ->setAction(Action::DETAIL)
            ->setEntityId($duplicatedArticle->getId())
            ->generateUrl();

        return $this->redirect($url);
    }

}
