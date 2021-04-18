<?php


namespace App\Service;


use App\Repository\HideoutRepository;

class HideoutService
{
    private $hideoutRepository;

    public function __construct(HideoutRepository $hideoutRepository)
    {
        $this->hideoutRepository = $hideoutRepository;
    }

    public function getChoices(): array
    {
        $result = [];
        $types = $this->hideoutRepository->findAll();
        foreach ($types as $type) {
            $result[
                $type->getAddress()." ".
                $type->getPostcode()." ".
                $type->getCity()
            ] = $type->getIdHideout();
        }

        return $result;
    }
}