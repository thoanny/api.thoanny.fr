<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Entity\OnceHuman\Recipe;
use App\Entity\OnceHuman\RecipeIngredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeIngredientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity', IntegerType::class, [
                'label' => false,
                'attr' => [
                    'placeholder' => 'Quantity'
                ]
            ])
            ->add('item', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'name',
                'label' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RecipeIngredient::class,
        ]);
    }
}
