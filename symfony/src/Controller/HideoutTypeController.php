<?php

namespace App\Controller;

use App\Form\HideoutTypeType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HideoutTypeController extends AbstractController
{
    /**
     * @Route("/admin/hideout/type", name="hideout_type")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(): Response
    {
        return $this->render('hideout_type/index.html.twig', [
            'controller_name' => 'HideoutTypeController',
        ]);
    }

    /**
     * @Route("/admin/hideout/type/add", name="hideout_type_add")
     * @IsGranted("ROLE_ADMIN")
     */
    public function addHideoutType(Request $request): Response
    {
        $form = $this->createForm(HideoutTypeType::class)
            ->add('submit', SubmitType::class);

        $form->handleRequest($request);

        // The form is submitted
        if ($form->isSubmitted() && $form->isValid()) {
            $hideoutType = $form->getData();

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($hideoutType);
            $entityManager->flush();
        }

        return $this->render('hideout_type/add.html.twig', [
            'controller_name' => 'HideoutTypeController',
            'form' => $form->createView()
        ]);
    }
}
