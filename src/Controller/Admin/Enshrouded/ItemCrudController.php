<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\Item\Item;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[AdminRoute(path: '/enshrouded/items', name: 'enshrouded_item')]
class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $enshroudedItemIconDir = $this->getParameter('uploads.enshrouded_item_icon_dir');

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            AssociationField::new('category', 'Catégorie'),
            IntegerField::new('level', 'Niveau')->hideOnIndex(),
            ChoiceField::new('quality', 'Qualité')->setChoices([
                'Ordinaire' => 'common',
                'Peu courant' => 'uncommon',
                'Rare' => 'rare',
                'Épique' => 'epic',
                'Légendaire' => 'legendary',
            ]),
            CodeEditorField::new('description', 'Description')->hideOnIndex(),
            CodeEditorField::new('comment', 'Commentaire')->hideOnIndex(),
            ChoiceField::new('equippable', 'Équipable')->setChoices([
                'Équipable' => 'equippable',
                'Équipable (à distance)' => 'ranger',
                'Utilisation directe' => 'direct_use',
            ]),
            TextField::new('iconFile', 'Illustration')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('icon', 'Illustration')->setBasePath($enshroudedItemIconDir)->onlyOnIndex(),
        ];
    }
}
