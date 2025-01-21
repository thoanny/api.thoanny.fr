<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Item;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class ItemAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Item::class,
            'searchable_fields' => ['name'],
            'choice_label' => 'name',
            'security' => 'ROLE_MANAGER',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC')
                ;
            }
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
