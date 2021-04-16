<?php

namespace App\Controller\Admin;

use App\Entity\Mission;
use App\Repository\MissionTypeRepository;
use App\Repository\SpecialityRepository;
use App\Service\MissionService;
use App\Service\MissionTypeService;
use App\Service\SpecialityService;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CountryField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MissionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Mission::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            TextField::new('code'),
            CountryField::new('country'),
            ChoiceField::new('status')
            ->setChoices([
                MissionService::getTextStatus('inpreparation') => 'inpreparation',
                MissionService::getTextStatus('inprogress') => 'inprogress',
                MissionService::getTextStatus('completed') => 'completed',
                MissionService::getTextStatus('failed') => 'failed'
            ]),
            DateField::new('start'),
            DateField::new('end'),
            AssociationField::new('spec', 'Speciality'),
            AssociationField::new('type'),
            AssociationField::new('affected', 'Affected to'),
            AssociationField::new('idHideout', 'Hideouts')
        ];
    }
}
