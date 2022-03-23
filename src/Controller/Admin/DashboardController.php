<?php

namespace App\Controller\Admin;

use App\Entity\Hotels;
use App\Entity\Users;
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
            ->setController(GerantsCrudController::class)
            ->generateUrl();
        return $this->redirect($url);

    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Interface Groupe Hypnos');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Accueil','fas fa-home');

        yield MenuItem::subMenu('Utilisateurs','fa fa-users')
        ->setPermission('ROLE_ADMIN')
            ->setSubItems([
                MenuItem::linkToCrud('Administrateur(s)','fa fa-user-circle-o', Users::class)
                    ->setController(AdminCrudController::class),
                MenuItem::linkToCrud('Gérants','fa fa-user-circle-o', Users::class)
                    ->setController(GerantsCrudController::class),
                MenuItem::linkToCrud('Clients','fa fa-user-circle-o', Users::class),

            ]);

        yield MenuItem::linkToCrud('Hôtels','fa fa-header', Hotels::class)
                    ->setController(HotelsCrudController::class);
        yield MenuItem::linkToCrud('Suites','fa fa-bed', HotelRooms::class)
            ->setController(HotelRoomsCrudController::class);
    }
}
