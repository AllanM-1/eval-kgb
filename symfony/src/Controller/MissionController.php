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
     * @Route("/mission", name="mission")
     */
    public function index(): Response
    {
        return $this->render('mission/index.html.twig', [
            'controller_name' => 'MissionController',
        ]);
    }

    /**
     * @Route("/get-missions")
     */
    public function getMissions(MissionService $missionService, Request $request): Response
    {
        $offset = $request->get('offset');
        $limit = $request->get('limit');

        $missions = $missionService->getMissionsListforDataTable($offset, $limit);
//        dump($missions);
//        return new Response('<body></body>');
        return new JsonResponse($missions);
    }
}
