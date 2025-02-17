<?php

namespace App\Form\Admin\PressReview;

use App\Entity\PressReview\Category;
use App\Entity\PressReview\Issue;
use App\Entity\PressReview\Post;
use App\Entity\PressReview\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title')
            ->add('source')
            ->add('link')
            ->add('thumbnail')
            ->add('published_at', null, [
                'widget' => 'single_text',
            ])
            ->add('status', ChoiceType::class, [
                'choices' => [
                    'À faire' => 'todo',
                    'Rejeté' => 'rejected',
                    'Accepté' => 'accepted',
                    'Rédigé' => 'drafted',
                    'Révisé' => 'reviewed',
                ]
            ])
            ->add('description')
            ->add('lvl')
            ->add('category', EntityType::class, [
                'class' => Category::class,
                'choice_label' => 'name',
            ])
            ->add('issue', EntityType::class, [
                'class' => Issue::class,
                'choice_label' => 'name',
                'required' => false,
            ])
            ->add('tags', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => 'name',
                'multiple' => true,
                // TODO : trier par nom avec un QueryBuilder
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Post::class,
        ]);
    }
}
