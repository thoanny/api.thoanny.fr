<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Entity\OnceHuman\Memetic;
use App\Entity\OnceHuman\MemeticCategory;
use App\Entity\OnceHuman\Scenario;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MemeticType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('category', EntityType::class, [
                'class' => MemeticCategory::class,
                'choice_label' => 'name',
            ])
            ->add('scenarios', EntityType::class, [
                'class' => Scenario::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('items', ItemAutocompleteField::class, [
                'multiple' => true,
                'required' => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Memetic::class,
        ]);
    }
}
