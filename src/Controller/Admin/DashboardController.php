<?php

namespace App\Controller\Admin;

use App\Entity\Contacts;
use App\Entity\Reservations;
use App\Entity\User;
use App\Entity\Sites;
use App\Entity\Subjects;
use App\Entity\Suites;
use App\Repository\UsersRepository;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

use function PHPSTORM_META\override;

class DashboardController extends AbstractDashboardController
{
    private UsersRepository $usersRepository;
    public function __construct(UsersRepository $usersRepository)
    {
        $this->usersRepository = $usersRepository;
    }
//  public function __construct(private AdminUrlGenerator $adminUrlGenerator)
//  {
//  }
//  #[IsGranted(data: ROLE_SUPER_ADMIN)]
      #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        #$url = $this->adminUrlGenerator
         #   ->setController(UsersCrudController::class)
         #   ->generateUrl();
        #return $this->redirect($url);
        return $this->render('admin/index.html.twig');

// return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hypnos');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToRoute('Aller sur le site', 'fas fa-undo', 'app_home');

    //    yield MenuItem::section('Gestion des Utilisateurs');

        yield MenuItem::subMenu('Utilisateurs', 'fas fa-user')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-user-plus', User::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', User::class)
        ]);

        
        yield MenuItem::subMenu('Contacts', 'fas fa-comment')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Contacts::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', Contacts::class)
        ]);

        yield MenuItem::subMenu('Catégorie Comment', 'fas fa-chart-pie')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Subjects::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', Subjects::class)
        ]);

        yield MenuItem::subMenu('Sites','fas fa-vihara')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Sites::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', Sites::class)
        ]);

        yield MenuItem::subMenu('Suites', 'fas fa-bed')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-plus', Suites::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', Suites::class)
        ]);

        yield MenuItem::subMenu('Réservations', 'fas fa-calendar-alt')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-calendar-plus', Reservations::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', Reservations::class)
        ]);
    }

    public function configureActions(): Actions
    {
        return parent::configureActions()
            ->add(Crud::PAGE_INDEX, Action::DETAIL);

    }
}
