<?php

namespace App\Form;

use App\Entity\Hideout;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CountryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class HideoutType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $hideoutTypes = $options['hideout_choices'];

        $builder
            ->add('code')
            ->add('address')
            ->add('postcode')
            ->add('city')
            ->add('country', CountryType::class)
            ->add('type', ChoiceType::class, ['mapped' => false, 'choices' => $hideoutTypes])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Hideout::class,
            'hideout_choices' => []
        ]);

        $resolver->setAllowedTypes('hideout_choices', 'array');
    }
}
