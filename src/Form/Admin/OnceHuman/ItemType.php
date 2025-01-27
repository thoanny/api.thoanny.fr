<?php

namespace App\Form\Admin\OnceHuman;

use App\Entity\OnceHuman\Item;
use App\Entity\OnceHuman\ItemCategory;
use App\Entity\OnceHuman\Scenario;
use App\Repository\OnceHuman\ItemCategoryRepository;
use App\Repository\OnceHuman\ScenarioRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('description')
            ->add('howToGet')
            ->add('rarity', ChoiceType::class, [
                'choices' => [
                    'Basique (blanc)' => 'white',
                    'Commun (vert)' => 'green',
                    'Rare (bleu)' => 'blue',
                    'Épique (violet)' => 'purple',
                    'Légendaire (orange)' => 'orange'
                ]
            ])
            ->add('weight')
            ->add('category', EntityType::class, [
                'class' => ItemCategory::class,
                'choice_label' => 'name',
                'query_builder' => function (ItemCategoryRepository $er) {
                    return $er->createQueryBuilder('c')
                        ->orderBy('c.name', 'ASC');
                }
            ])
            ->add('scenario', EntityType::class, [
                'class' => Scenario::class,
                'expanded' => true,
                'multiple' => true,
                'choice_label' => 'name',
                'query_builder' => function (ScenarioRepository $er) {
                    return $er->createQueryBuilder('s')
                        ->orderBy('s.name', 'ASC');
                }
            ])
            ->add('iconFile', VichImageType::class, [
                'required' => false,
                'download_label' => false,
                'help' => '80×80px'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Item::class,
        ]);
    }
}
