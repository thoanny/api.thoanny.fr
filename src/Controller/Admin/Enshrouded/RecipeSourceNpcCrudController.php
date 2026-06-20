<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\Recipe\SourceNpc;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

class RecipeSourceNpcCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SourceNpc::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('npc', 'Personnage'),
        ];
    }
}
