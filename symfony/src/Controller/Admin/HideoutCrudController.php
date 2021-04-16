<?php

namespace App\Controller\Admin;

use App\Entity\Hideout;
use App\Repository\HideoutTypeRepository;
use App\Service\HideoutTypeService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HideoutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hideout::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('code'),
            TextField::new('address'),
            TextField::new('postcode'),
            TextField::new('city'),
            CountryField::new('country'),
            AssociationField::new('type')
        ];
    }
}
