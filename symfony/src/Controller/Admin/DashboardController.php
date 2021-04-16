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
        $missions = $this->getDoctrine()->getRepository(Mission::class)->count([]);
        $missionTypes = $this->getDoctrine()->getRepository(MissionType::class)->count([]);
        $hideouts = $this->getDoctrine()->getRepository(Hideout::class)->count([]);
        $hideoutTypes = $this->getDoctrine()->getRepository(HideoutType::class)->count([]);
        $specialities = $this->getDoctrine()->getRepository(Speciality::class)->count([]);
        $users = $this->getDoctrine()->getRepository(User::class)->count([]);

        return $this->render('Admin/dashboard.html.twig', [
            'page_title' => 'Dashboard',
            'missions' => $missions,
            'mission_types' => $missionTypes,
            'hideouts' => $hideouts,
            'hideout_types' => $hideoutTypes,
            'specialities' => $specialities,
            'users' => $users,
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('KGB');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linktoDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section("Database");
        yield MenuItem::linkToCrud('Missions', 'fa fa-suitcase', Mission::class);
        yield MenuItem::linkToCrud('Missions types', 'fa fa-suitcase', MissionType::class);
        yield MenuItem::linkToCrud('Hideouts', 'fa fa-eye-slash', Hideout::class);
        yield MenuItem::linkToCrud('Hideout types', 'fa fa-eye-slash', HideoutType::class);
        yield MenuItem::linkToCrud('Specialities', 'fa fa-trophy', Speciality::class);
        yield MenuItem::linkToCrud('Users', 'fa fa-users', User::class);
        yield MenuItem::section("Link");
        yield MenuItem::linkToRoute('To front office','fa fa-home', 'missions');
    }
}
