<?php


namespace App\Service;


use App\Repository\SpecialityRepository;

class SpecialityService
{
    private $specialityRepository;

    public function __construct(SpecialityRepository $specialityRepository)
    {
        $this->specialityRepository = $specialityRepository;
    }

    /**
     * @return array
     */
    public function getChoices(): array
    {
        $result = [];
        $types = $this->specialityRepository->findAll();
        foreach ($types as $type) {
            $result[$type->getName()] = $type->getIdSpec();
        }

        return $result;
    }
}