<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $specialityChoices = $options['speciality_choices'];

        $builder
            ->add('type', ChoiceType::class,
                [
                    'choices' => [
                        'Contact' => 'contact',
                        'Agent' => 'agent',
                        'Target' => 'target'
                    ]
                ]
            )
            ->add('nom')
            ->add('prenom')
            ->add('born', BirthdayType::class)
            ->add('code')
            ->add('nationality')
            ->add('inSpeciality', ChoiceType::class,
                [
                    'mapped' => false,
                    'choices' => $specialityChoices

                ]
            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => User::class,
            'speciality_choices' => []
        ]);

        $resolver->setAllowedTypes('speciality_choices', 'array');
    }
}
