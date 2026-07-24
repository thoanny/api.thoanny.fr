<?php

namespace App\Form\Enshrouded\Recipe;

use App\Entity\Enshrouded\Recipe\Ingredient;
use App\Form\Enshrouded\ItemAutocompleteField;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class IngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('item', ItemAutocompleteField::class, [
                'label' => 'Objet'
            ])
            ->add('quantity', IntegerType::class, [
                'label' => 'Quantité'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Ingredient::class,
        ]);
    }
}
