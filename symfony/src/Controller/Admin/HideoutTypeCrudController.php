<?php

namespace App\Controller\Admin;

use App\Entity\HideoutType;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class HideoutTypeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return HideoutType::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
        ];
    }
}
