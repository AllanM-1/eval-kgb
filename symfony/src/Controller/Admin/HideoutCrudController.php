<?php

namespace App\Controller\Admin;

use App\Entity\Hideout;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class HideoutCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Hideout::class;
    }

    /*
    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id'),
            TextField::new('title'),
            TextEditorField::new('description'),
        ];
    }
    */
}
