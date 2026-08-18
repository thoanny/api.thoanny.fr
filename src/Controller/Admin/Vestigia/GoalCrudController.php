<?php

namespace App\Controller\Admin\Vestigia;

use App\Entity\Vestigia\Goal;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminRoute(path: '/vestigia/goals', name: 'vestigia_goal')]
class GoalCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Goal::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            TextField::new('label'),
            ChoiceField::new('type')->setChoices([
                'Quotidien' => 'daily',
                'Hebdomadaire' => 'weekly',
                'Défi' => 'challenge',
            ]),
            NumberField::new('steps', 'Nombre de pas'),
            NumberField::new('duration', 'Durée')->setHelp('En minutes.'),
            AssociationField::new('rewardItem', 'Récompense'),
            NumberField::new('rewardQuantity', 'Quantité'),
        ];
    }
}
