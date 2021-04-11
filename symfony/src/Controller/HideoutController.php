<?php

namespace App\Controller;

use App\Entity\Hideout;
use App\Repository\HideoutRepository;
use App\Form\HideoutType;
use App\Repository\HideoutTypeRepository;
use App\Service\HideoutService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HideoutController extends AbstractController
{
    /**
     * @Route("/admin/hideout", name="hideout")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render('hideout/index.html.twig', [
            'controller_name' => 'HideoutController',
        ]);
    }

    /**
     * @Route("/admin/hideout-add", name="hideout_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addHideout(Request $request, HideoutTypeRepository $hideoutTypeRepository): Response
    {
        $hideoutTypes = new HideoutService($hideoutTypeRepository);

        $form = $this->createForm(HideoutType::class,
            null,
            [
                'hideout_choices' => $hideoutTypes->getChoices()
            ]
        )
        ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        // The form is submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $hideout = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hideout);
            $entityManager->flush();
        }

        return $this->render('hideout/add.html.twig', [
            'controller_name' => 'HideoutController',
            'form' => $form->createView()
        ]);
    }
}
