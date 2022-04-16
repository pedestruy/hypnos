<?php

namespace App\Controller\Admin;

use App\Entity\Sites;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SitesCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Sites::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('name', 'Nom'),
            TextField::new('address'),
            TextField::new('city'),
            NumberField::new('zip'),
            BooleanField::new('active'),
            DateTimeField::new('updatedAt')->hideOnForm(),
            DateTimeField::new('createdAt')->hideOnForm(),
        ];
    }

    public function persistEntity(EntityManagerInterface $em, $entityInstance): void
    {
        if (!$entityInstance instanceof Sites) return;

        $entityInstance->setCreatedAt(new \DateTimeImmutable);

        parent::persistEntity($em, $entityInstance);
    }

    public function deleteEntity(EntityManagerInterface $em, $entityInstance): void
    {

        if (!$entityInstance instanceof Sites) return;

        foreach ($entityInstance->getSuite() as $suite){
            $em->remove($suite);
        }

        parent::deleteEntity($em, $entityInstance);
    }

}
