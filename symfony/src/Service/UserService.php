<?php


namespace App\Service;


use App\Repository\UserRepository;

class UserService
{
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getChoices(): array
    {
        $result = [];
        $types = $this->userRepository->findAll();
        foreach ($types as $type) {
            $result[$type->getNom()." ".$type->getPrenom()] = $type->getIdUser();
        }

        return $result;
    }
}