<?php

namespace App\Controller\Admin\Enshrouded;

use App\Entity\Enshrouded\Npc;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\CodeEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

#[AdminRoute(path: '/enshrouded/npcs', name: 'enshrouded_npc')]
class NpcCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Npc::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $enshroudedNpcIconDir = $this->getParameter('uploads.enshrouded_npc_icon_dir');

        return [
            IdField::new('id')->onlyOnIndex(),
            TextField::new('name', 'Nom'),
            CodeEditorField::new('description')->hideOnIndex(),
            TextField::new('iconFile', 'Illustration')->setFormType(VichImageType::class)->onlyOnForms(),
            ImageField::new('icon', 'Illustration')->setBasePath($enshroudedNpcIconDir)->onlyOnIndex(),
        ];
    }
}
