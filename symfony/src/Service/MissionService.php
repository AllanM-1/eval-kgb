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
    public function getMissionsListforDataTable(int $offset, int $limit, string $search): array
    {
        $total = $this->missionRepository->countMissionsList($search);

        $result['total'] = $total;
        $result['totalNotFiltered'] = $total;
        $missions = $this->missionRepository->findMissionsList($offset, $limit, $search);
        foreach ($missions as $mission) {
            $result['rows'][] = [
                'idmission' => $mission->getIdMission(),
                'title' => $mission->getTitle(),
                'code' => $mission->getCode(),
                'country' => $mission->getCountry(),
                'type' => $mission->getType()->getName(),
                'start' => $mission->getStart()->format('d/m/Y'),
                'end' => $mission->getEnd()->format('d/m/Y')
                ];
//            dump($mission);
//
//            dump($mission->getType()->getName());
        }
        return $result;
    }
}