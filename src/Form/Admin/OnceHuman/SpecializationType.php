<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Scenario;
use App\Entity\OnceHuman\Specialization;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SpecializationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('type', ChoiceType::class, [
                'choices' => [
                    'Nouvelle formule' => 'formula-new',
                    'Formule améliorée' => 'formula-boost',
                    'Nouvelle installation' => 'facility-new',
                    'Installation améliorée' => 'facility-boost',
                ]
            ])
            ->add('description')
            ->add('levels', ChoiceType::class, [
                'choices' => [
                    5 => 5,
                    10 => 10,
                    15 => 15,
                    20 => 20,
                    25 => 25,
                    30 => 30,
                    35 => 35,
                    40 => 40,
                    45 => 45,
                    50 => 50
                ],
                'expanded' => true,
                'multiple' => true,
            ])
            ->add('scenarios', EntityType::class, [
                'class' => Scenario::class,
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Specialization::class,
        ]);
    }
}
