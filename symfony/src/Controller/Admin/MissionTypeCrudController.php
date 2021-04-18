<?php

namespace App\Controller\Admin;

use App\Entity\MissionType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MissionTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return MissionType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
}
