<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Repository\MissionRepository;
use App\Repository\MissionTypeRepository;
use App\Service\MissionService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
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
    public function index(MissionRepository $missionRepository, MissionTypeRepository $missionTypeRepository, MissionService $missionService): Response
    {
        $missionStatusValues = $missionService->getStatusValues();
        $missionCountryValues = $missionService->getCountryValues();
        $missionTypeValues = $missionTypeRepository->findAll();

        return $this->render('mission/index.html.twig', [
            'controller_name' => 'MissionController',
            'status' => $missionStatusValues,
            'countries' => $missionCountryValues,
            'types' => $missionTypeValues
        ]);
    }

    /**
     * @Route("/mission/get-missions")
     */
    public function getMissions(MissionService $missionService, Request $request): Response
    {
        $offset = $request->get('offset', 0);
        $limit = $request->get('limit', 10);
        $search = $request->get('search', '');
        $sort = $request->get('sort', '');
        $order = $request->get('order', '');
        $status = $request->get('status', '');
        $country = $request->get('country', '');
        $type = $request->get('type', '');

        $missions = $missionService->getMissionsListforDataTable($offset, $limit, $search, $sort, $order, $status, $country, $type);
        return new JsonResponse($missions);
    }

    /**
     * @Route("/mission/details/{idmission}")
     */
    public function getMissionDetails(MissionService $missionService, int $idmission): Response
    {
        $mission = $missionService->getMissionDetails($idmission);
        return new JsonResponse($mission);
    }

    /**
     * @Route("/admin/missions", name="admin_missions")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminMissions(MissionRepository $missionRepository, MissionTypeRepository $missionTypeRepository, MissionService $missionService): Response
    {
        $missionStatusValues = $missionService->getStatusValues();
        $missionCountryValues = $missionService->getCountryValues();
        $missionTypeValues = $missionTypeRepository->findAll();

        return $this->render('admin/missions.html.twig', [
            'controller_name' => 'MissionController',
            'status' => $missionStatusValues,
            'countries' => $missionCountryValues,
            'types' => $missionTypeValues
        ]);
    }
}
