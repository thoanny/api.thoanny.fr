<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Event;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('startAt', null, [
                'widget' => 'single_text',
            ])
            ->add('endAt', null, [
                'widget' => 'single_text',
            ])
            ->add('all_day', CheckboxType::class, [
                'required' => false,
            ])
            ->add('url')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'download_label' => false,
                'help' => '512×288px'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Event::class,
        ]);
    }
}
