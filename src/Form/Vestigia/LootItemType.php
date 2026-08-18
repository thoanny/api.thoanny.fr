<?php

namespace App\Form\Vestigia;

use App\Entity\Vestigia\Item;
use App\Entity\Vestigia\LootItem;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LootItemType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('rewardItem', EntityType::class, [
                'class' => Item::class,
                'choice_label' => 'name',
                'label' => 'Objet',
            ])
            ->add('min', IntegerType::class, [
                'label' => 'Min',
            ])
            ->add('max', IntegerType::class, [
                'label' => 'Max',
            ])
            ->add('chance', IntegerType::class, [
                'label' => 'Chance (%)',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => LootItem::class,
        ]);
    }
}
