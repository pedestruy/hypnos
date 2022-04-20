<?php

namespace App\Controller\Admin;

use App\Entity\Subjects;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class SubjectsCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Subjects::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
