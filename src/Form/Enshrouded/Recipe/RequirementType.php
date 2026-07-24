<?php

namespace App\Form\Enshrouded\Recipe;

use App\Entity\Enshrouded\Recipe\Requirement;
use App\Entity\Enshrouded\Recipe\Source;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RequirementType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('source', EntityType::class, [
                'class' => Source::class,
                'autocomplete' => true
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Requirement::class,
        ]);
    }
}
