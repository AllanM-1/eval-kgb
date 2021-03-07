<?php

namespace App\Service;

use App\Repository\MissionRepository;

class MissionService
{
    private $missionRepository;

    public function __construct(MissionRepository $missionRepository)
    {
        $this->missionRepository = $missionRepository;
    }

    /**
     * Finds all missions
     */
    public function getMissionsListforDataTable(int $offset, int $limit, string $search, string $sort, string $order): array
    {
        $total = $this->missionRepository->countMissionsList($search);

        $result['total'] = $total;
        $result['totalNotFiltered'] = $total;
        $result['rows'] = [];
        $missions = $this->missionRepository->findMissionsList($offset, $limit, $search, $sort, $order);
        foreach ($missions as $mission) {
            $result['rows'][] = [
                'idmission' => $mission->getIdMission(),
                'title' => $mission->getTitle(),
                'code' => $mission->getCode(),
                'country' => $mission->getCountry(),
                'type' => $mission->getType()->getName(),
                'status' => $mission->getStatus(),
                'start' => $mission->getStart()->format('d/m/Y'),
                'end' => $mission->getEnd()->format('d/m/Y')
            ];
        }
        return $result;
    }

    /**
     * Finds details of a mission
     */
    public function getMissionDetails($idmission): array
    {
        $mission = $this->missionRepository->find($idmission);

        // Mission details
        $result = [
            'idmission' => $mission->getIdMission(),
            'title' => $mission->getTitle(),
            'description' => $mission->getDescription(),
            'code' => $mission->getCode(),
            'country' => $mission->getCountry(),
            'type' => $mission->getType()->getName(),
            'speciality' => $mission->getSpec()->getName(),
            'status' => $mission->getStatus(),
            'start' => (!is_null($mission->getStart())) ? $mission->getStart()->format('d/m/Y H:i') : null,
            'end' => (!is_null($mission->getEnd())) ? $mission->getEnd()->format('d/m/Y H:i') : null
        ];

        // Hideouts details
        foreach ($mission->getIdHideout() as $hideout) {
            $result['hideout'][$hideout->getIdHideout()] = [
                'code' => $hideout->getCode(),
                'country' => $hideout->getCountry(),
                'address' => $hideout->getAddress(),
                'city' => $hideout->getCity(),
                'postcode' => $hideout->getPostcode(),
                'type' => $hideout->getType()->getName()
            ];
        }

        // Affected user
        foreach ($mission->getAffected() as $user) {
            $result['user'][$user->getIdUser()] = [
                'code' => $user->getCode(),
                'type' => $user->getType(),
                'name' => $user->getNom(),
                'firstname' => $user->getPrenom(),
                'born' => (!is_null($user->getBorn())) ? $user->getBorn()->format('d/m/Y') : null,
                'nationality' => $user->getNationality()
            ];

            foreach($user->getInSpeciality() as $speciality) {
                $result['user'][$user->getIdUser()]['speciality'][$speciality->getIdSpec()] = $speciality->getName();
            }
        }

        return $result;
    }
}