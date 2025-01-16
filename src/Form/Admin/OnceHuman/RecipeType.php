<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Entity\OnceHuman\Recipe;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('quantity')
            ->add('item', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'name',
            ])
            ->add('workshop', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'name',
            ])
            ->add('duration')
            ->add('ingredients', CollectionType::class, [
                'entry_type' => RecipeIngredientType::class,
                'entry_options' => ['label' => false],
                'allow_add' => true,
                'label' => false,
                'by_reference' => false,
                'allow_delete' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
