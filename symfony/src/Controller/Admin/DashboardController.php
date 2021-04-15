<?php

namespace App\Controller\Admin;

use App\Entity\Hideout;
use App\Entity\HideoutType;
use App\Entity\Mission;
use App\Entity\MissionType;
use App\Entity\Speciality;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return parent::index();
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Symfony');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('Missions', 'fa fa-suitcase', Mission::class);
        yield MenuItem::linkToCrud('Missions types', 'fa fa-suitcase', MissionType::class);
        yield MenuItem::linkToCrud('Hideouts', 'fa fa-eye-slash', Hideout::class);
        yield MenuItem::linkToCrud('Hideout types', 'fa fa-eye-slash', HideoutType::class);
        yield MenuItem::linkToCrud('Specialities', 'fa fa-trophy', Speciality::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
    }
}
