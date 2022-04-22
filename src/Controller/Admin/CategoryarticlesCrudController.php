<?php

namespace App\Controller\Admin;

use App\Entity\Categoryarticles;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ColorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField as DateTimeFieldAlias;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\SlugField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryarticlesCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE = 'duplicate';
    public const CATEGORYARTICLES_BASE_PATH = 'upload/images/categoryArticle';
    public const CATEGORYARTICLES_UPLOAD_DIR = 'public/upload/images/categoryArticle';

    public static function getEntityFqcn(): string
    {
        return Categoryarticles::class;
    }
    public function configureCrud(Crud $crud): Crud {
        return $crud
            // the labels used to refer to this entity in titles, buttons, etc.
            ->setEntityLabelInSingular('Categoryarticles')
            ->setEntityLabelInPlural('Categories')

            // in addition to a string, the argument of the singular and plural label methods
            // can be a closure that defines two nullable arguments: entityInstance (which will
            // be null in 'index' and 'new' pages) and the current page name
            ->setEntityLabelInSingular(
                fn (?Categoryarticles $categoryarticles, ?string $pageName) => $categoryarticles ? $categoryarticles->toString() : 'une catégorie pour les articles'
            )
            ->setEntityLabelInPlural(function (?Categoryarticles $categoryarticles, ?string $pageName) {
                return 'edit' === $pageName ? $categoryarticles->getLabel() : 'Liste des categories du blog';
            });
    }
    public function configureActions(Actions $actions): Actions
    {
        $duplicate = Action::new(self::ACTION_DUPLICATE)
            ->linkToCrudAction('duplicateCategoryarticles')
            ->SetCssClass('btn btn-success');


        return $actions
            ->add(Crud::PAGE_EDIT, $duplicate)
            ->reorder(crud::PAGE_EDIT, [self::ACTION_DUPLICATE, action::SAVE_AND_RETURN]);
    }

    public function configureFields(string $pageName): iterable
    {

        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name', 'Nom de la catégorie');
        yield SlugField::new('slug')
            ->setTargetFieldName('name');
        yield ImageField::new('imagePath', 'Photo de la categorie')
            ->setBasePath(self::CATEGORYARTICLES_BASE_PATH)
            ->setUploadDir(self::CATEGORYARTICLES_UPLOAD_DIR)
            ->setSortable(false);
        yield BooleanField::new('isPublic');
        yield DateTimeFieldAlias::new('updatedAt')->hideOnForm();
        yield DateTimeFieldAlias::new('createdAt')->hideOnForm();
    }

    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Categoryarticles) return;

        foreach ($entityInstance->getarticles() as $article) {
            $em->remove($article);
        }

        parent::deleteEntity($em, $entityInstance);
    }
}
