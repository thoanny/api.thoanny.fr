<?php

namespace App\Controller\Admin;

use App\Entity\Membership;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminRoute;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

#[AdminRoute(path: '/memberships', name: 'membership')]
class MembershipCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Membership::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->onlyOnIndex(),
            ChoiceField::new('network', 'Réseau social')->setChoices([
                'Thoanny' => 'thoanny',
                'Twitch' => 'twitch',
                'Patreon' => 'patreon',
            ]),
            BooleanField::new('active', 'Actif'),
            TextField::new('name', 'Nom affiché'),
            IntegerField::new('uid', 'UID')->setHelp('0 si inconnu')->hideOnIndex(),
            DateTimeField::new('updatedAt', 'Mise à jour'),
            AssociationField::new('user', 'Utilisateur lié')->setSortProperty('nickname')->hideOnIndex(),
        ];
    }
}
