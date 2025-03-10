<?php

namespace App\Form\Admin;

use App\Entity\Membership;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MembershipType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('network', ChoiceType::class, [
                'choices' => [
                    'Thoanny' => 'thoanny',
                    'Twitch' => 'twitch',
                    'Patreon' => 'patreon',
                ]
            ])
            ->add('active')
            ->add('name')
            ->add('uid')
            ->add('updatedAt', null, [
                'widget' => 'single_text',
            ])
            ->add('user', EntityType::class, [
                'class' => User::class,
                'choice_label' => 'nickname',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Membership::class,
        ]);
    }
}
