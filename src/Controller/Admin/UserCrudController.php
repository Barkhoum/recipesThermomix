<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AvatarField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            yield FormField::addPanel('Information de connexion '),
            yield TextField::new('fullName', 'Nom complet')->setColumns(6),
            yield TextField::new('pseudo')->setColumns(6),
            yield EmailField::new('email')->setColumns(6),
            yield TextField::new('password', 'Mot de passe')->setColumns(6)->onlyOnForms(),
            yield TextField::new('plainPassword', 'comfimation du mot de passe')->setColumns(6)->onlyOnForms(),
            yield DateTimeField::new('createdAt')->onlyOnDetail(),


        ];
    }

}
