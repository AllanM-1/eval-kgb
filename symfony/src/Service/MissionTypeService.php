<?php


namespace App\Service;


use App\Repository\MissionTypeRepository;

class MissionTypeService
{
    private $missionTypeRepository;

    public function __construct(MissionTypeRepository $missionTypeRepository)
    {
        $this->missionTypeRepository = $missionTypeRepository;
    }

    /**
     * @return array
     */
    public function getTypeChoices(): array
    {
        $result = [];
        $types = $this->missionTypeRepository->findAll();
        foreach ($types as $type) {
            $result[$type->getName()] = $type->getIdMissionType();
        }

        return $result;
    }
}