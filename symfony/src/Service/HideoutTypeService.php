<?php


namespace App\Service;


use App\Repository\HideoutTypeRepository;

class HideoutTypeService
{
    private $hideoutTypeRepository;

    public function __construct(HideoutTypeRepository $hideoutTypeRepository)
    {
        $this->hideoutTypeRepository = $hideoutTypeRepository;
    }

    public function getChoices(): array
    {
        $result = [];
        $types = $this->hideoutTypeRepository->findAll();
        foreach ($types as $type) {
            $result[$type->getName()] = $type->getIdHideoutType();
        }

        return $result;
    }
}