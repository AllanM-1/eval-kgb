<?php

namespace App\Controller;

use App\Entity\Speciality;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/user", name="user")
     */
    public function index(): Response
    {
        /*$user = new User();
        $user->setNom('MELIGNON');
        $user->setPrenom('Allan');
        $user->setType('agent');
        $user->setNationality('Française');

        $speciality = new Speciality();
        $speciality->setName('Elimination par empoisonnement');

        $user->addInSpeciality($speciality);

        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($user);
        $entityManager->flush();*/

        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("find-user")
     */
    public function findUser(UserRepository $userRepository): Response
    {
        dump($userRepository->findAll());
        return new Response('<body></body>');
    }

}
