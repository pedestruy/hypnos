<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


        public function configureFields(string $pageName): iterable
    {
            yield IdField::new('id')->hideOnForm();
            yield TextField::new('name');
            yield EmailField::new('email');
            yield ChoiceField::new('roles')
                ->allowMultipleChoices()
                ->renderAsBadges([
                    'ROLE_ADMIN'=>'success',
                    'ROLE_MANAGER'=>'warning',
                    'ROLE_USER'=>'danger',
                ])
                ->setChoices([
                    'Administrateur'=>'ROLE_ADMIN',
                    'Gérant'=>'ROLE_MANAGER',
                    'Utilisateur'=>'ROLE_USER',
                ]);

    }

}
