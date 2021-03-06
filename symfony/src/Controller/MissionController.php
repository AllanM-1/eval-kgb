<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Repository\MissionRepository;
use App\Service\MissionService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class MissionController extends AbstractController
{
    /**
     * @Route("/missions", name="missions")
     */
    public function index(): Response
    {
        return $this->render('mission/index.html.twig', [
            'controller_name' => 'MissionController',
        ]);
    }

    /**
     * @Route("/missions/get-missions")
     */
    public function getMissions(MissionService $missionService, Request $request): Response
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');
        $search = $request->get('search');

        $missions = $missionService->getMissionsListforDataTable($offset, $limit, $search);
//        dump($missions);
//        return new Response('<body></body>');
        return new JsonResponse($missions);
    }
}
