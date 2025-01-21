<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Scenario;
use App\Entity\OnceHuman\Server;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ServerType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('scenario', EntityType::class, [
                'class' => Scenario::class,
                'choice_label' => 'name',
            ])
            ->add('difficulty', ChoiceType::class, [
                'choices' => [
                    'Débutant' => 'easy',
                    'Normal' => 'normal',
                    'Difficile' => 'hard'
                ]
            ])
            ->add('startAt', null, [
                'widget' => 'single_text',
            ])
            ->add('closed')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Server::class,
        ]);
    }
}
