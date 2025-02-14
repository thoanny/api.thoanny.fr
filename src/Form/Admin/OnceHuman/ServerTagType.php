<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\ServerTag;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ServerTagType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('iconFile', VichImageType::class, [
                'required' => false,
                'download_label' => false,
                'help' => '48×48px'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => ServerTag::class,
        ]);
    }
}
