<?php

namespace App\Form;

use App\Entity\Mission;
use App\Service\MissionService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MissionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $specialityChoices = $options['speciality_choices'];
        $typeChoices = $options['type_choices'];
        $userChoices = $options['user_choices'];
        $hideoutChoices = $options['hideout_choices'];

        $builder
            ->add('title')
            ->add('description')
            ->add('code')
            ->add('country', CountryType::class)
            ->add('status', ChoiceType::class,
                [
                    'mapped' => false,
                    'choices' => [
                        MissionService::getTextStatus('inpreparation') => 'inpreparation',
                        MissionService::getTextStatus('inprogress') => 'inprogress',
                        MissionService::getTextStatus('completed') => 'completed',
                        MissionService::getTextStatus('failed') => 'failed'
                    ]

                ]
            )
            ->add('start', DateTimeType::class)
            ->add('end', DateTimeType::class)
            ->add('spec', ChoiceType::class,
                [
                    'mapped' => false,
                    'choices' => $specialityChoices

                ]
            )
            ->add('type', ChoiceType::class,
                [
                    'mapped' => false,
                    'choices' => $typeChoices

                ]
            )
            ->add('affected', ChoiceType::class,
                [
                    'mapped' => false,
                    'choices' => $userChoices

                ]
            )
            ->add('idHideout', ChoiceType::class,
                [
                    'mapped' => false,
                    'choices' => $hideoutChoices

                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Mission::class,
            'speciality_choices' => [],
            'type_choices' => [],
            'user_choices' => [],
            'hideout_choices' => []
        ]);

        $resolver->setAllowedTypes('speciality_choices', 'array');
        $resolver->setAllowedTypes('type_choices', 'array');
        $resolver->setAllowedTypes('user_choices', 'array');
        $resolver->setAllowedTypes('hideout_choices', 'array');
    }
}
