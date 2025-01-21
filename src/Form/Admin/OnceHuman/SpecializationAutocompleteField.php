<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Specialization;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class SpecializationAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Specialization::class,
            'searchable_fields' => ['name'],
            'choice_label' => 'name',
            'security' => 'ROLE_MANAGER',
            'multiple' => true,
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('s')
                    ->orderBy('s.name', 'ASC')
                ;
            }
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
