<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type')
            ->setChoices([
                'Contact' => 'contact',
                'Agent' => 'agent',
                'Target' => 'target'
            ]),
            TextField::new('nom'),
            TextField::new('prenom'),
            DateField::new('born'),
            TextField::new('code'),
            CountryField::new('nationality'),
            AssociationField::new('inSpeciality', 'Specialities')
        ];
    }
}
