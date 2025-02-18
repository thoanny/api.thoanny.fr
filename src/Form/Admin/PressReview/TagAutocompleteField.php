<?php

namespace App\Form\Admin\PressReview;

use App\Entity\PressReview\Tag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\Autocomplete\Form\AsEntityAutocompleteField;
use Symfony\UX\Autocomplete\Form\BaseEntityAutocompleteType;

#[AsEntityAutocompleteField]
class TagAutocompleteField extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'class' => Tag::class,
            'placeholder' => 'Choose a Tag',
            'multiple' => true,
            'choice_label' => 'name',
            'required' => false,
            'by_reference' => false,
            'searchable_fields' => ['name'],
            'security' => 'ROLE_ADMIN',
            'attr' => [
                'data-controller' => 'pr-post-tag',
                'data-pr-post-tag-url-value' => '/admin/press-reviews/tags/autocomplete/new',
            ],
        ]);
    }

    public function getParent(): string
    {
        return BaseEntityAutocompleteType::class;
    }
}
