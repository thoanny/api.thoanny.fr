<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\Recipe\Recipe;
use App\Form\Enshrouded\Recipe\IngredientType;
use App\Form\Enshrouded\Recipe\RequirementType;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;

#[AdminRoute(path: '/enshrouded/recipes', name: 'enshrouded_recipe')]
class RecipeCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Recipe::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            AssociationField::new('outputItem', 'Objet produit'),
            IntegerField::new('outputQuantity', 'Quantité produite'),
            IntegerField::new('outputDuration', 'Durée de production')->hideOnIndex(),
            AssociationField::new('category', 'Catégorie'),
            CollectionField::new('requirements', 'Pré-requis')
                ->setEntryType(RequirementType::class)
                ->hideOnIndex(),
            CollectionField::new('ingredients', 'Ingrédients')
                ->setEntryType(IngredientType::class)
                ->hideOnIndex(),
            AssociationField::new('source', 'Origine du produit')->setHelp('Laisser vide si fabrication manuelle')
        ];
    }
}
