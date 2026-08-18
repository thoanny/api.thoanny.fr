<?php

namespace App\Controller\Admin\Vestigia;

use App\Entity\Vestigia\Item;
use App\Form\Vestigia\LootItemType;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[AdminRoute(path: '/vestigia/items', name: 'vestigia_item')]
class ItemCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Item::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $vestigiaItemDir = $this->getParameter('uploads.vestigia_item_dir');
        $vestigiaItemRarity = $this->getParameter('vestigia.item.rarity');
        $vestigiaItemType = $this->getParameter('vestigia.item.type');

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            TextEditorField::new('description')->hideOnIndex(),
            ChoiceField::new('type', 'Type')->setChoices(array_flip($vestigiaItemType)),
            ChoiceField::new('rarity', 'Rareté')->setChoices(array_flip($vestigiaItemRarity)),
            BooleanField::new('stackable', 'Empilable'),
            TextField::new('iconFile', 'Illustration')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('icon', 'Illustration')->setBasePath($vestigiaItemDir)->onlyOnIndex(),
            CollectionField::new('loots', 'Table de loots')
                ->setEntryType(LootItemType::class)
                ->renderExpanded()
                ->setEntryIsComplex()
                ->hideOnIndex()
            ,
        ];
    }

}
