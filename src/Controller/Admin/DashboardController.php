<?php

namespace App\Controller\Admin;

use App\Entity\Users;
use App\Entity\Sites;
use App\Entity\Suites;
use App\Repository\SuitesRepository;
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
            ->setController(UsersCrudController::class)
            ->generateUrl();
        return $this->redirect($url);

// return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Hypnos');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');

    //    yield MenuItem::section('Gestion des Utilisateurs');

        yield MenuItem::subMenu('Gestion des Utilisateurs')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-user-plus', Users::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', Users::class)
        ]);

        yield MenuItem::subMenu('Gestion des Sites')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-map', Sites::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', Sites::class)
        ]);

        yield MenuItem::subMenu('Gestion des Suites')->setSubItems([
            MenuItem::linkToCrud('Ajouter', 'fas fa-map', Suites::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Liste', 'fas fa-list', Suites::class)
        ]);
    }
}
