<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Form\MissionType;
use App\Repository\HideoutRepository;
use App\Repository\MissionRepository;
use App\Repository\MissionTypeRepository;
use App\Repository\SpecialityRepository;
use App\Repository\UserRepository;
use App\Service\HideoutService;
use App\Service\MissionService;
use App\Service\MissionTypeService;
use App\Service\SpecialityService;
use App\Service\UserService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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

    /**
     * @Route("/admin/mission/add", name="mission_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addMission(
        Request $request,
        SpecialityRepository $specialityRepository,
        MissionTypeRepository $missionTypeRepository,
        UserRepository $userRepository,
        HideoutRepository $hideoutRepository
    ): Response
    {
        $specialityTypes = new SpecialityService($specialityRepository);
        $missionTypes = new MissionTypeService($missionTypeRepository);
        $userAffected = new UserService($userRepository);
        $hideoutChoices = new HideoutService($hideoutRepository);
        $mission = new Mission();

        $form = $this->createForm(MissionType::class,
            null,
            [
                'speciality_choices' => $specialityTypes->getChoices(),
                'type_choices' => $missionTypes->getTypeChoices(),
                'user_choices' => $userAffected->getChoices(),
                'hideout_choices' => $hideoutChoices->getChoices()
            ]
        )
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        // The form is submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $mission = $form->getData();

            // Mission speciality
            $spec = $specialityRepository->find(
                $request->get('mission')['spec']
            );
            $mission->setSpec($spec);

            // Mission type
            $type = $missionTypeRepository->find(
                $request->get('mission')['type']
            );
            $mission->setType($type);

            $mission->setStatus($request->get('mission')['status']);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($mission);
            $entityManager->flush();
        }

        return $this->render('mission/add.html.twig', [
            'controller_name' => 'MissionController',
            'form' => $form->createView()
        ]);
    }
}
