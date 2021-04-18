<?php

namespace App\Controller;

use App\Entity\Hideout;
use App\Entity\HideoutType;
use App\Entity\Mission;
use App\Entity\MissionType;
use App\Entity\Speciality;
use App\Entity\User;
use App\Form\UserType;
use App\Repository\SpecialityRepository;
use App\Repository\UserRepository;
use App\Service\SpecialityService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin/user", name="user")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }

    /**
     * @Route("/admin/user/add", name="user_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addUser(Request $request, SpecialityRepository $specialityRepository): Response
    {
        $specialityTypes = new SpecialityService($specialityRepository);
        $user = new User();

        $form = $this->createForm(UserType::class,
            null,
            [
                'speciality_choices' => $specialityTypes->getChoices()
            ]
        )
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        // The form is submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $user = $form->getData();

            // User speciality
            $spec = $specialityRepository->find(
                $request->get('user')['inSpeciality']
            );
            $user->addInSpeciality($spec);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();
        }

        return $this->render('user/add.html.twig', [
            'controller_name' => 'UserController',
            'form' => $form->createView()
        ]);
    }
}
