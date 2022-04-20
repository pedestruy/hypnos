<?php

namespace App\Controller\Admin;

use App\Entity\Reservations;
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

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;

class ReservationsCrudController extends AbstractCrudController
{
    public const ACTION_DUPLICATE = 'duplicate';

    public static function getEntityFqcn(): string
    {
        return Reservations::class;
    }

    public function configureActions(Actions $actions): Actions
    {
          $duplicate = Action::new(self::ACTION_DUPLICATE)
          ->linkToCrudAction('duplicateReservation')
          ->setCssClass('btn btn-info');
  
          return $actions
          ->add(Crud::PAGE_EDIT, $duplicate)
          ->reorder(Crud::PAGE_EDIT, [self::ACTION_DUPLICATE, Action::SAVE_AND_RETURN]);
      }


      public function configureFields(string $pageName): iterable
      {
          return [
              IdField::new('id')->hideOnForm(),
              AssociationField::new('suite')->setQueryBuilder(function (QueryBuilder $queryBuilder){
                  $queryBuilder->where('entity.active = true');
                }),
              AssociationField::new('user'),
              DateTimeField::new('createdAt') -> hideOnForm(),
              DateTimeField::new('startedAt'),
              DateTimeField::new('endedAt'),
              BooleanField::new('active'),
              
          ];
      }
  
      public function duplicateReservation(
          AdminContext $context,
          AdminUrlGenerator $adminUrlGenerator,
          EntityManagerInterface $em
          ): Response {
              /** @var Reservations $reservation */
              $reservation = $context->getEntity()->getInstance();
  
              $duplicatedReservation = clone $reservation;
  
              parent::persistEntity($em, $duplicatedReservation);
  
              $url = $adminUrlGenerator->setController(self::class)
                  ->setAction(Action::DETAIL)
                  ->setEntityId($duplicatedReservation->getId())
                  ->generateUrl();
  
              return $this->redirect($url);
          }
  }
