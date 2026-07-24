<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\Recipe\SourceItem;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;

#[AdminRoute(path: '/enshrouded/sources/items', name: 'enshrouded_source_item')]
class RecipeSourceItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SourceItem::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('item', 'Objet'),
        ];
    }
}
