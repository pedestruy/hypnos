<?php

namespace App\Controller\Admin;

use App\Entity\Suites;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class SuitesCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE = 'duplicate';
    public const SUITES_BASE_PATH = 'upload/images/suites';
    public const SUITES_UPLOAD_DIR = 'public/upload/images/suites';

    public static function getEntityFqcn(): string
    {
        return Suites::class;
    }

    public function configureActions(Actions $actions): Actions
  {
        $duplicate = Action::new(self::ACTION_DUPLICATE)
        ->linkToCrudAction('duplicateSuite')
        ->setCssClass('btn btn-info');

        return $actions
        ->add(Crud::PAGE_EDIT, $duplicate)
        ->reorder(Crud::PAGE_EDIT, [self::ACTION_DUPLICATE, Action::SAVE_AND_RETURN]);
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('site')->setQueryBuilder(function (QueryBuilder $queryBuilder){
                $queryBuilder->where('entity.active = true');
            }),
            TextField::new('title', 'Titre'),
            ImageField::new('picture', 'Photo')
                ->setBasePath(self::SUITES_BASE_PATH)
                ->setUploadDir(self::SUITES_UPLOAD_DIR),
            MoneyField::new('price', 'Prix')->setCurrency('EUR'),
            BooleanField::new('active'),
            DateTimeField::new('updatedAt') -> hideOnForm(),
            DateTimeField::new('createdAt') -> hideOnForm(),
            
        ];
    }

    public function duplicateSuite(
        AdminContext $context,
        AdminUrlGenerator $adminUrlGenerator,
        EntityManagerInterface $em
        ): Response {
            /** @var Suites $suite */
            $suite = $context->getEntity()->getInstance();

            $duplicatedSuite = clone $suite;

            parent::persistEntity($em, $duplicatedSuite);

            $url = $adminUrlGenerator->setController(self::class)
                ->setAction(Action::DETAIL)
                ->setEntityId($duplicatedSuite->getId())
                ->generateUrl();

            return $this->redirect($url);
        }


}
